<?php
/**
 * Pour ajouter ou modifier une categorie.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../fonctions/add_img.php';
    include_once dirname(__FILE__) . '/../fonctions/delete_file.php';
    include_once dirname(__FILE__) . '/../fonctions/modif_name_file.php';
    include_once dirname(__FILE__) . '/../class/enum_type.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    /* le nom de l'image */
    $img = "";

    /* on verifit qu'une image a ete envoye */
    if(!empty($_FILES) && array_key_exists('file', $_FILES) && !empty($_FILES['file']['name'])) {
        /* on creer un nom unique pour l'image' */
        $name = modif_name_file($_FILES['file']['name']);
        /* on le deplace au bonne endroit avec le bon nom */
        if(add_img($_FILES['file']['tmp_name'], $name, Enum_Type::CATEGORIE)) {
            $img = $name;
        }
    }
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":name" => "",
                ":desc" => "",
                ":display" => 0
            );

    /* un id a 0 par defaut, pour signaler un nouveau logo */
    $id = 0;
    /* si on a un id, modifier une categorie */
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        /* on recupere l'id de la categorie */
        $id = $_POST['id'];
        $values[":id"] = $id;
    } else {
        /* sinon on recupere l'id de l'utilisateur */
        $values[":id_user"] = $_SESSION['id_user'];
    }

    /* debut : de la recuperation des post */
    if(array_key_exists("name", $_POST) && !empty($_POST['name'])) {
        $values[":name"] = htmlspecialchars(stripslashes(trim($_POST['name'])));
    }
    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":desc"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
    }
    if(array_key_exists("display", $_POST) && !empty($_POST['display'])) {
        $values[":display"] = 1;
    }
    /* fin : de la recuperation des post */

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $sgbd->beginTransaction();
            /* pour verifier la validiter des informations (eviter les doublons) */
            $valide = true;
            /* verifier qu'on a bien entree un nom */
            if(empty($values[":name"])) {
                echo "Merci d'entrer un nom.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le nom n'a pas deja ete utilise */
                $res = $sgbd->prepare("SELECT * FROM categorie WHERE nom_cat=:nom_cat && id_cat!=:id");
                $res->execute([
                    ":nom_cat" => $values[":name"],
                    ":id" => $id
                ]);
                /* s'il est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le nom est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* si l'id n'est pas a  0 */
                if(!empty($id)) {
                    /* modifier le contenu dans la base de donnee */
                    $res = $sgbd->prepare("UPDATE categorie SET nom_cat=:name, description_cat=:desc, display_cat=:display WHERE id_cat=:id");
                    $res->execute($values);
                } else {
                    /* sinon on insert le contenu a la base de donnee */
                    $res = $sgbd->prepare("INSERT INTO categorie (nom_cat, description_cat, display_cat, id_user) VALUES (:name, :desc, :display, :id_user)");
                    $res->execute($values);
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                /* si on a une image a entrer */
                if(!empty($img)) {
                    /* on recupere l'ancien fichier */
                    $res = $sgbd->prepare("SELECT * FROM categorie WHERE id_cat=:id");
                    $res->execute([
                        ":id" => $id
                    ]);
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    /* on supprime l'ancien fichier */
                    delete_file($data["avatar_cat"]);
                    /* on entre le nouveau fichier */
                    $res = $sgbd->prepare("UPDATE categorie SET avatar_cat=:avatar_cat WHERE id_cat=:id");
                    $res->execute([
                        ":avatar_cat" => $img,
                        ":id" => $id
                    ]);
                }
                echo "true";
            }
            /* on transmets les commits sous format securise */
            $sgbd->commit();
        } catch (Exception $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
        }
    }

} else {
    header("Status: 403");
}

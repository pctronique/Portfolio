<?php
/**
 * Pour ajouter ou modifier un logo.
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
        if(add_img($_FILES['file']['tmp_name'], $name, Enum_Type::LOGO)) {
            $img = $name;
        }
    }
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":name" => "",
                ":title" => ""
            );

    /* un id a 0 par defaut, pour signaler un nouveau logo */
    $id = 0;
    /* si on a un id, modifier un logo */
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        /* on recupere l'id du logo */
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
    if(array_key_exists("title", $_POST) && !empty($_POST['title'])) {
        $values[":title"] = htmlspecialchars(stripslashes(trim($_POST['title'])));
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
            /* verifier qu'on a bien entree un titre */
            if(empty($values[":title"])) {
                echo "Merci d'entrer un titre.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le titre n'a pas deja ete utilise */
                $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE title_competences_logo=:title_competences_logo && id_competences_logo!=:id");
                $res->execute([
                    ":title_competences_logo" => $values[":title"],
                    ":id" => $id
                ]);
                /* s'il est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le titre est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* si l'id n'est pas a  0 */
                if(!empty($id)) {
                    /* modifier le contenu dans la base de donnee */
                    $res = $sgbd->prepare("UPDATE competences_logo SET nom_competences_logo=:name, title_competences_logo=:title WHERE id_competences_logo=:id");
                    $res->execute($values);
                } else {
                    /* sinon on insert le contenu a la base de donnee */
                    $res = $sgbd->prepare("INSERT INTO competences_logo (nom_competences_logo, title_competences_logo, id_user_creator) VALUES (:name, :title, :id_user)");
                    $res->execute($values);
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                /* si on a une image a entrer */
                if(!empty($img)) {
                    /* on recupere l'ancien fichier */
                    $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE id_competences_logo=:id");
                    $res->execute([
                        ":id" => $id
                    ]);
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    /* on supprime l'ancien fichier */
                    delete_file($data["src_competences_logo"]);
                    /* on entre le nouveau fichier */
                    $res = $sgbd->prepare("UPDATE competences_logo SET src_competences_logo=:src_competences_logo WHERE id_competences_logo=:id");
                    $res->execute([
                        ":src_competences_logo" => $img,
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

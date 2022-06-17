<?php
/**
 * Pour ajouter ou modifier un produit.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';
    include_once dirname(__FILE__) . '/../fonctions/add_img.php';
    include_once dirname(__FILE__) . '/../fonctions/delete_file.php';
    include_once dirname(__FILE__) . '/../fonctions/modif_name_file.php';
    include_once dirname(__FILE__) . '/../class/enum_type.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    /* le nom de l'image */
    $img = "";

    /* on verifit qu'une image a ete envoye */
    if(!empty($_FILES) && array_key_exists('file', $_FILES) && !empty($_FILES['file']['name'])) {
        /* on creer un nom unique pour l'image' */
        $name = modif_name_file($_FILES['file']['name']);
        /* on le deplace au bonne endroit avec le bon nom */
        if(add_img($_FILES['file']['tmp_name'], $name, Enum_Type::PRODUITS)) {
            $img = $name;
        }
    }
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":name" => "",
                ":desc" => "",
                ":src" => "",
                ":srcGit" => "",
                ":display" => 0
            );

    /* tableau des valeurs complementaires du produit */
    $tab_cat = [];
    $tab_langP = [];
    $tab_framW = [];

    /* ajouter les valeurs a entrer, dans des tableaux */
    foreach ($_POST as $key => $value) {
        $name = explode("_", $key)[0];
        if($name == "langP") {
            array_push($tab_langP, $value);
        } else if($name == "cat") {
            array_push($tab_cat, $value);
        } else if($name == "framW") {
            array_push($tab_framW, $value);
        }
    }

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
    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":desc"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
    }
    if(array_key_exists("src", $_POST) && !empty($_POST['src'])) {
        $values[":src"] = htmlspecialchars(stripslashes(trim($_POST['src'])));
    }
    if(array_key_exists("srcGit", $_POST) && !empty($_POST['srcGit'])) {
        $values[":srcGit"] = htmlspecialchars(stripslashes(trim($_POST['srcGit'])));
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
            /* verifier qu'on a bien entree un titre */
            if(empty($values[":name"])) {
                echo "Merci d'entrer un nom.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le nom n'a pas deja ete utilise */
                $res = $sgbd->prepare("SELECT * FROM produits WHERE nom_produit=:nom_produit && id_produit!=:id_produit");
                $res->execute([
                    ":nom_produit" => $values[":name"],
                    ":id_produit" => $id
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
                    $res = $sgbd->prepare("UPDATE produits SET nom_produit=:name, description_produit=:desc, src_produit=:src, src_git_produit=:srcGit, display_produit=:display WHERE id_produit=:id");
                    $res->execute($values);

                    /* supprime le produit et le lien avec les autres tables */
                    $res = $sgbd->prepare("DELETE FROM cat_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    $res = $sgbd->prepare("DELETE FROM language_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    $res = $sgbd->prepare("DELETE FROM framework_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                } else {
                    /* sinon on insert le contenu a la base de donnee */
                    $res = $sgbd->prepare("INSERT INTO produits (nom_produit, description_produit, src_produit, src_git_produit, display_produit, id_user) VALUES (:name, :desc, :src, :srcGit, :display, :id_user)");
                    $res->execute($values);
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                /* si on a une image a entrer */
                if(!empty($img)) {
                    $res = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id");
                    $res->execute([
                        ":id" => $id
                    ]);
                    /* on recupere l'ancien fichier */
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    /* on supprime l'ancien fichier */
                    foreach ($data as $valueLine) {
                        delete_file($valueLine["src_photo"]);
                    }
                    /* recupere l'id du produit */
                    $res = $sgbd->prepare("DELETE FROM photos WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    /* insere la nouvelle image */
                    $res = $sgbd->prepare("INSERT INTO photos (src_photo, alt_photo, titre_photo, id_produit) VALUES (:src_photo, :alt_photo, :titre_photo, :id_produit)");
                    $res->execute([
                        ":src_photo" => $img,
                        ":alt_photo" => $values[":name"],
                        ":titre_photo" => $values[":name"],
                        ":id_produit" => $id
                    ]);
                }
                /* si le tableau php (array) des language des pas vide */
                foreach ($tab_langP as $value) {
                    /* entrer les valeurs */
                    $res = $sgbd->prepare("INSERT INTO language_produit(id_language, id_produit) VALUES (:id_language, :id_produit)");
                    $res->execute([
                        ":id_language" => $value,
                        ":id_produit" => $id
                    ]);
                }
                /* si le tableau php (array) des framework n'est pas vide */
                foreach ($tab_framW as $value) {
                    /* entrer les valeurs */
                    $res = $sgbd->prepare("INSERT INTO framework_produit(id_framework, id_produit) VALUES (:id_framework, :id_produit)");
                    $res->execute([
                        ":id_framework" => $value,
                        ":id_produit" => $id
                    ]);
                }
                /* si le tableau php (array) des categories n'est pas vide */
                foreach ($tab_cat as $value) {
                    /* entrer les valeurs */
                    $res = $sgbd->prepare("INSERT INTO cat_produit(id_cat, id_produit) VALUES (:id_cat, :id_produit)");
                    $res->execute([
                        ":id_cat" => $value,
                        ":id_produit" => $id
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
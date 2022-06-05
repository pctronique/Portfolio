<?php

/* demarrer la session */
session_start();

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    

    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';
    include_once dirname(__FILE__) . '/../fonctions/add_img.php';
    include_once dirname(__FILE__) . '/../fonctions/delete_file.php';
    include_once dirname(__FILE__) . '/../fonctions/modif_name_file.php';
    $img = "";

    if(!empty($_FILES) && array_key_exists('file', $_FILES) && !empty($_FILES['file']['name'])) {
        $name = modif_name_file($_FILES['file']['name']);
        if(add_img($_FILES['file']['tmp_name'], $name)) {
            $img = $name;
        }
    }
    
    $values = array(
                ":name" => "",
                ":title" => ""
            );

    $id = 0;
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $values[":id"] = $id;
    } else {
        $values[":id_user"] = $_SESSION['id_user'];
    }

    if(array_key_exists("name", $_POST) && !empty($_POST['name'])) {
        $values[":name"] = htmlspecialchars(stripslashes(trim($_POST['name'])));
    }

    if(array_key_exists("title", $_POST) && !empty($_POST['title'])) {
        $values[":title"] = htmlspecialchars(stripslashes(trim($_POST['title'])));
    }

    /*Connexion*/
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $sgbd->beginTransaction();
            /* pour verifier la validiter des informations (eviter les doublons ou probleme de mot de passe) */
            $valide = true;
            /* si c'est valide, on continu la verification */
            if(empty($values[":title"])) {
                echo "Merci d'entrer un titre.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le login n'a pas deja ete utilise par une autre personne */
                $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE title_competences_logo=:title_competences_logo && id_competences_logo!=:id");
                $res->execute([
                    ":title_competences_logo" => $values[":title"],
                    ":id" => $id
                ]);
                /* si le login est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le titre est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                if(!empty($id)) {
                    $res = $sgbd->prepare("UPDATE competences_logo SET nom_competences_logo=:name, title_competences_logo=:title WHERE id_competences_logo=:id");
                    $res->execute($values);
                } else {
                    $res = $sgbd->prepare("INSERT INTO competences_logo (nom_competences_logo, title_competences_logo, id_user_creator) VALUES (:name, :title, :id_user)");
                    $res->execute($values);
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                if(!empty($img)) {
                    $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE id_competences_logo=:id");
                    $res->execute([
                        ":id" => $id
                    ]);
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    delete_file($data["src_competences_logo"]);
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
    echo "error 404";
}

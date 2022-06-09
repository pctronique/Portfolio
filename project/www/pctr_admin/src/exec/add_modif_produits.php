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
    
    $values = array(
                ":name" => "",
                ":desc" => "",
                ":src" => ""
            );

    $tab_cat = [];
    $tab_langP = [];
    $tab_framW = [];
    $img = "";

    if(!empty($_FILES) && array_key_exists('file', $_FILES) && !empty($_FILES['file']['name'])) {
        $name = modif_name_file($_FILES['file']['name']);
        if(add_img($_FILES['file']['tmp_name'], $name)) {
            $img = $name;
        }
    }

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

    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":desc"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
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
            if(empty($values[":name"])) {
                echo "Merci d'entrer un nom.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le login n'a pas deja ete utilise par une autre personne */
                $res = $sgbd->prepare("SELECT * FROM produits WHERE nom_produit=:nom_produit && id_produit!=:id_produit");
                $res->execute([
                    ":nom_produit" => $values[":name"],
                    ":id_produit" => $id
                ]);
                /* si le login est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le nom est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                if(!empty($id)) {
                    $res = $sgbd->prepare("UPDATE produits SET nom_produit=:name, description_produit=:desc, src_produit=:src WHERE id_produit=:id");
                    $res->execute($values);

                    $res = $sgbd->prepare("DELETE FROM cat_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    $res = $sgbd->prepare("DELETE FROM language_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    $res = $sgbd->prepare("DELETE FROM framework_produit WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                } else {
                    $res = $sgbd->prepare("INSERT INTO produits (nom_produit, description_produit, src_produit, id_user) VALUES (:name, :desc, :src, :id_user)");
                    $res->execute($values);
                    /* recupere son id */
                    $id = $sgbd->lastInsertId();
                }
                if(!empty($img)) {
                    $res = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id");
                    $res->execute([
                        ":id" => $id
                    ]);
                    $data = $res->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $valueLine) {
                        delete_file($valueLine["src_photo"]);
                    }
                    $res = $sgbd->prepare("DELETE FROM photos WHERE id_produit=:id");
                    $res->execute([":id" => $id]);
                    $res = $sgbd->prepare("INSERT INTO photos (src_photo, alt_photo, titre_photo, id_produit) VALUES (:src_photo, :alt_photo, :titre_photo, :id_produit)");
                    $res->execute([
                        ":src_photo" => $img,
                        ":alt_photo" => $values[":name"],
                        ":titre_photo" => $values[":name"],
                        ":id_produit" => $id
                    ]);
                }
                foreach ($tab_langP as $value) {
                    $res = $sgbd->prepare("INSERT INTO language_produit(id_language, id_produit) VALUES (:id_language, :id_produit)");
                    $res->execute([
                        ":id_language" => $value,
                        ":id_produit" => $id
                    ]);
                }
                foreach ($tab_framW as $value) {
                    $res = $sgbd->prepare("INSERT INTO framework_produit(id_framework, id_produit) VALUES (:id_framework, :id_produit)");
                    $res->execute([
                        ":id_framework" => $value,
                        ":id_produit" => $id
                    ]);
                }
                foreach ($tab_cat as $value) {
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
    echo "error 404";
}
<?php

/* demarrer la session */
session_start();

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {
    
    $values = array(
                ":name" => "",
                ":desc" => "",
                ":src" => ""
            );

    $tab_cat = [];
    $tab_langP = [];

    foreach ($_POST as $key => $value) {
        $name = explode("_", $key)[0];
        if($name == "langP") {
            array_push($tab_cat, $value);
        } else if($name == "cat") {
            array_push($tab_langP, $value);
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
        $values[":name"] = $_POST['name'];
    }

    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":desc"] = $_POST['description'];
    }

    /*Connexion*/
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $sgbd->beginTransaction();
            if(!empty($id)) {
                $res = $sgbd->prepare("UPDATE produits SET nom_produit=:name, description_produit=:desc, src_produit=:src WHERE id_produit=:id");
                $res->execute($values);

                $res = $sgbd->prepare("DELETE FROM cat_produit WHERE id_produit=:id");
                $res->execute([":id" => $id]);
                $res = $sgbd->prepare("DELETE FROM language_produit WHERE id_produit=:id");
                $res->execute([":id" => $id]);
            } else {
                $res = $sgbd->prepare("INSERT INTO produits (nom_produit, description_produit, src_produit, id_user) VALUES (:name, :desc, :src, :id_user)");
                $res->execute($values);
                /* recupere son id */
                $id = $sgbd->lastInsertId();
            }
            foreach ($tab_langP as $value) {
                $res = $sgbd->prepare("INSERT INTO language_produit(id_language, id_produit, id_user) VALUES (:id_language, :id_produit, :id_user)");
                $res->execute([
                    ":id_language" => $value,
                    ":id_produit" => $id,
                    ":id_user" => $_SESSION['id_user']
                ]);
            }
            foreach ($tab_langP as $value) {
                $res = $sgbd->prepare("INSERT INTO cat_produit(id_cat, id_produit) VALUES (:id_language, :id_produit)");
                $res->execute([
                    ":id_language" => $value,
                    ":id_produit" => $id
                ]);
            }
            /* on transmets les commits sous format securise */
            $sgbd->commit();
            echo "true";
        } catch (PDOException $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
        }
    }

} else {
    echo "error 404";
}
<?php

/* demarrer la session */
session_start();

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {
    
    $exp = "type";
    $values = array(
                ":title" => "",
                ":start" => "",
                ":progress" => "",
                ":fin" => "",
                ":compt" => "",
                ":lieu" => "",
                ":desc" => ""
            );

    $id = 0;
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $values[":id"] = $id;
    } else {
        $values[":id_user"] = $_SESSION['id_user'];
    }

    if(array_key_exists("title", $_POST) && !empty($_POST['title'])) {
        $values[":title"] = $_POST['title'];
    }

    if(array_key_exists("start", $_POST) && !empty($_POST['start'])) {
        $values[":start"] = $_POST['start'];
    }

    if(array_key_exists("progress", $_POST) && !empty($_POST['progress'])) {
        $values[":progress"] = $_POST['progress'];
    }

    if(array_key_exists("fin", $_POST) && !empty($_POST['fin'])) {
        $values[":fin"] = $_POST['fin'];
    }

    if(array_key_exists("compt", $_POST) && !empty($_POST['compt'])) {
        $values[":compt"] = $_POST['compt'];
    }

    if(array_key_exists("lieu", $_POST) && !empty($_POST['lieu'])) {
        $values[":lieu"] = $_POST['lieu'];
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
            if(!empty($id)) {
                $res = $sgbd->prepare("UPDATE categorie1 SET nom_cat=:name, description_cat=:desc WHERE id_cat=:id");
                $res->execute($values);
            } else {
                $res = $sgbd->prepare("INSERT INTO categorie1 (nom_cat, description_cat, id_user) VALUES (:name, :desc, :id_user)");
                $res->execute($values);
            }
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
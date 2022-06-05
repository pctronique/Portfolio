<?php

/* demarrer la session */
session_start();

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {
    
    $tab_logos = [];
    
    foreach ($_POST as $key => $value) {
        $name = explode("_", $key)[0];
        if($name == "cv") {
            array_push($tab_logos, $value);
        }
    }

    /*Connexion*/
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("DELETE FROM cv_display WHERE id_user=:id_user");
            $res->execute([":id_user" => $_SESSION['id_user']]);
            foreach ($tab_logos as $value) {
                $res = $sgbd->prepare("INSERT INTO cv_display(id_cv, id_user) VALUES (:id_cv, :id_user)");
                $res->execute([
                    ":id_cv" => $value,
                    ":id_user" => $_SESSION['id_user']
                ]);
            }
            echo "true";
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

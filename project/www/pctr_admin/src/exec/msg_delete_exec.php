<?php
/**
 * Executer la suppression d'un message par l'utilisateur.
 */

/* demarrer la session */
session_start();

/* inclure des fonctionnalites à la page */
include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

/* verifier qu'on as le droit de venir sur cette page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* se connecter a la base de donnees */
    $sgbd = connexion_sgbd();
    /* verifier qu'on est bien connecte a la base */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* supprimer le message */
            $res = $sgbd->prepare("DELETE FROM messages WHERE id_msg=:id_msg");
            $res->execute([":id_msg" => $_POST['id_msg']]);
            echo "true";
        } catch (PDOException $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
        }
    } else {
        echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
    }
} else {
    echo "error 404";
}
      
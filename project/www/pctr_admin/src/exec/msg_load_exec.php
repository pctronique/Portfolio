<?php 
/**
 * Executer l'ouverture d'un message.
 */

/* demarrer la session */
session_start();

/* verifier qu'on as le droit de venir sur cette page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

/* inclure des fonctionnalites à la page */
include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    /* verifier qu'on vient a partir d'un formulaire */
    if (!empty($_POST) && array_key_exists('id', $_POST)) {
        /* se connecter a la base de donnees */
        $sgbd = connexion_sgbd();
        /* verifier qu'on est bien connecte a la base */
        if(!empty($sgbd)) {
            /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
            try {
                /* recupere le message */
                $res = $sgbd->prepare("SELECT * FROM messages WHERE id_msg=:id_msg");
                $res->execute([
                    ":id_msg" => $_POST['id']
                ]);
                /* note le message comme lu */
                $tab = $res->fetchAll(PDO::FETCH_ASSOC);
                $res = $sgbd->prepare("UPDATE messages SET lu_msg=1 WHERE id_msg=:id_msg");
                $res->execute([
                    ":id_msg" => $_POST['id']
                ]);
                /* retourne le message sous le format d'un tableau */
                echo "true"."[#json#]".json_encode($tab);
            } catch (PDOException $e) {
                /* sauvegarde le message d'erreur dans le fichier "errors.log" */
                $error_log = new Error_Log();
                $error_log->addError($e);
                echo "Désolé, une erreur c'est produite lors du téléchargement de la page.";
            }
        } else {
            echo "Une erreur est survenu lors de la connexion.";
        }
    } else {
        header("Status: 403");
    }
} else {
    header("Status: 403");
}

<?php
/**
 * supprimer un CV.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST) && array_key_exists('id', $_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../fonctions/delete_file.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    /* demarrer la session */
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* recupere l'ancien fichier */
            $res = $sgbd->prepare("SELECT * FROM cv WHERE id_cv=:id");
            $res->execute([
                ":id" => $_POST['id']
            ]);
            $data = $res->fetch(PDO::FETCH_ASSOC);
            /* supprime le fichier */
            delete_file($data["src_cv"]);

            /* supprime le contenu de la tabe sgbd */
            $res = $sgbd->prepare("DELETE FROM cv WHERE id_cv=:id");
            $res->execute([":id" => $_POST['id']]);
            echo "true";
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

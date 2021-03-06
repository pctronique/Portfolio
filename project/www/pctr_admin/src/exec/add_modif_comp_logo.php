<?php
/**
 * Pour activer ou desactiver un logo.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';
    
    /* creation de la table pour contenir les logos */
    $tab_logos = [];
    
    /* entrer les logos a activer */
    foreach ($_POST as $key => $value) {
        $name = explode("_", $key)[0];
        if($name == "logo") {
            array_push($tab_logos, $value);
        }
    }

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* supprime l'ancien list actives */
            $res = $sgbd->prepare("DELETE FROM competences_logo_user WHERE id_user=:id_user");
            $res->execute([":id_user" => $_SESSION['id_user']]);
            /* ajoute la nouvelle liste */
            foreach ($tab_logos as $value) {
                $res = $sgbd->prepare("INSERT INTO competences_logo_user(id_competences_logo, id_user) VALUES (:id_competences_logo, :id_user)");
                $res->execute([
                    ":id_competences_logo" => $value,
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
    header("Status: 403");
}

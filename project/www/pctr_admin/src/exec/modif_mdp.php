<?php
/**
 * Pour modifier le mot de passe.
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
    include_once dirname(__FILE__) . '/../../../src/class/Pass_Crypt.php';

    /* demarrer la session */
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $validation = true;
            /* recuperer l'utilisateur dans la base par le login ou l'email */
            $res = $sgbd->prepare("SELECT * FROM utilisateur LEFT JOIN admin ON utilisateur.id_admin = admin.id_admin WHERE id_user=:id_user");
            $res->bindParam(':login', $_SESSION['login']);
            $res->execute([
                ":id_user" => $_SESSION['id_user']
            ]);
            /* si on a trouve un utilisateur */
            if($res->rowCount() > 0) {
                /* recuperer ces informations */
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valueLine) {
                    /* verifier qu'il n'a pas ete banni */
                    if($valueLine['id_admin'] != 4) {
                        /* verifier la validiter du mot de passe */
                        if(!Pass_Crypt::verify($_POST['old-pass'], $valueLine['mot_pass_user'])) {
                            $validation = false;
                            echo "erreur avec l'ancien mot de passe.";
                        }
                    }
                }
            }
            /* si l'ancien mot de passe est valide */
            if($validation) {
                /* verifier que les deux nouveau mot de passes sont identiques */
                if( $_POST["new_pass"] == $_POST["repet-pass"]){
                    /* verifier que le mot de passe n'est pas vide */
                    if (!empty($_POST["new_pass"]))
                    {
                        /* entrer le nouveau mot de passe */
                        $res = $sgbd->prepare("UPDATE utilisateur SET mot_pass_user=:mot_pass_user WHERE id_user=:id_user");
                        $res->execute([
                            ":id_user" => $_SESSION['id_user'],
                            ":mot_pass_user" => Pass_Crypt::password($_POST["new_pass"])
                        ]);
                        echo "true";
                    } else {
                        echo "le mot de passe ne peut pas être vide.";
                    }
                } else {
                    echo "les mots de passe ne sont pas identiques.";
                }
            }
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
<?php 
/**
 * Execute l'envoie d'un message au gestionnaire ou administrateur.
 */

/* inclure des fonctionnalites à la page */
include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';
include_once dirname(__FILE__) . '/../class/Error_Log.php';
include_once dirname(__FILE__) . '/../fonctions/message_email.php';

// verifier qu'on est bien passe par un formulaire (ou transmit les informations par post)
if(!empty($_POST) && array_key_exists('name', $_POST) && array_key_exists('first_name', $_POST) && 
    array_key_exists('email', $_POST) && array_key_exists('user_text', $_POST) && array_key_exists('objet', $_POST)) {

    /* se connecter a la base de donnees */
    $sgbd = connexion_sgbd();
    /* verifier qu'on est bien connecte a la base */
    if(!empty($sgbd)) {
        /* regex de validation de l'adresse email */
        $regexEmailValide = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";

        /* verifier la validiter des informations */
        if(preg_match("/^.{3,40}$/", $_POST['name']) && preg_match("/^.{3,40}$/", $_POST['first_name']) 
            && preg_match($regexEmailValide,$_POST['email']) && preg_match("/^.{3,255}$/",$_POST['objet']) 
            && preg_match("/^.{8,}$/",str_replace("\n", "", $_POST['user_text']))) {
            /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
            try {
                /* protege les commits du sql, pour eviter des erreurs d'envois */
                /* une requete va avoir besoin des informations des requetes precedentes */
                $sgbd->beginTransaction();
                /* insert le message dans la base de donnees */
                $res = $sgbd->prepare("INSERT INTO messages(Nom_msg, Prenom_msg, Email_msg, Objet_msg, Message_msg) VALUES ".
                    "(:Nom,:Prenom,:Email,:Objet,:Message)");
                $res->execute([
                    ":Nom" => htmlspecialchars(stripslashes(trim($_POST['name']))),
                    ":Prenom" => htmlspecialchars(stripslashes(trim($_POST['first_name']))),
                    ":Email" => htmlspecialchars(stripslashes(trim($_POST['email']))),
                    ":Objet" => htmlspecialchars(stripslashes(trim($_POST['objet']))),
                    ":Message" => htmlspecialchars(stripslashes(trim($_POST['user_text']))),
                ]);
                /* recupere son id */
                $id_insert = $sgbd->lastInsertId();
                /* on joute l'id du message */
                $res = $sgbd->prepare("INSERT INTO messages_utilisateur (id_msg, id_user) VALUES (:id_msg,:id_user)");
                $res->execute([
                    ":id_msg" => $id_insert,
                    ":id_user" => 1
                ]);
                $text = htmlspecialchars(stripslashes(trim($_POST['name'])))."<br />";
                $text = htmlspecialchars(stripslashes(trim($_POST['first_name'])))."<br />";
                $text = htmlspecialchars(stripslashes(trim($_POST['user_text'])))."<br />";
                message_email("mon_email@moi.fr", htmlspecialchars(stripslashes(trim($_POST['email']))), htmlspecialchars(stripslashes(trim($_POST['objet']))), $text);
                /* on transmets les commits sous format securise */
                $sgbd->commit();
                echo "true";
            } catch (PDOException $exc) {
                /* sauvegarde le message d'erreur dans le fichier "errors.log" */
                $error_log = new Error_Log();
                $error_log->addError($e);
                echo "Une erreur c'est produite lors de l'envoie du message.";
            }
        } else {
            echo 'Il manque des informations pour transmettre le message.';
        }
    } else {
        echo "Une erreur c'est produite lors de l'envoie du message.";
    }

} else {
    header("Status: 403");
}

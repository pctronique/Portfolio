<?php
/**
 * Pour ajouter ou modifier un framework.
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
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":name" => ""
            );

    /* un id a 0 par defaut, pour signaler un nouveau logo */
    $id = 0;
    /* si on a un id, modifier un framework */
    if(array_key_exists("id", $_POST) && !empty($_POST['id'])) {
        /* on recupere l'id d'un framework */
        $id = $_POST['id'];
        $values[":id"] = $id;
    } else {
        /* sinon on recupere l'id de l'utilisateur */
        $values[":id_user"] = $_SESSION['id_user'];
    }

    /* debut : de la recuperation des post */
    if(array_key_exists("name", $_POST) && !empty($_POST['name'])) {
        $values[":name"] = htmlspecialchars(stripslashes(trim($_POST['name'])));
    }
    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":desc"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
    }
    /* fin : de la recuperation des post */

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* verifier qu'on a bien entree un nom */
            if(empty($values[":name"])) {
                echo "Merci d'entrer un nom.";
                $valide = false;
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le nom n'a pas deja ete utilise */
                $res = $sgbd->prepare("SELECT * FROM framework WHERE nom_framework=:nom_framework &&  id_framework!=:id");
                $res->execute([
                    ":nom_framework" => $values[":name"],
                    ":id" => $id
                ]);
                /* s'il est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le nom est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* si l'id n'est pas a  0 */
                if(!empty($id)) {
                    /* modifier le contenu dans la base de donnee */
                    $res = $sgbd->prepare("UPDATE framework SET nom_framework=:name WHERE id_framework=:id");
                    $res->execute($values);
                } else {
                    /* sinon on insert le contenu a la base de donnee */
                    $res = $sgbd->prepare("INSERT INTO framework (nom_framework, id_user) VALUES (:name, :id_user)");
                    $res->execute($values);
                }
                echo "true";
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
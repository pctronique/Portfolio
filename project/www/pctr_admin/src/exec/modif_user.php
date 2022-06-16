<?php
/**
 * Pour modifier les informations de l'utilisateur.
 */

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_POST)) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../fonctions/add_img.php';
    include_once dirname(__FILE__) . '/../fonctions/delete_file.php';
    include_once dirname(__FILE__) . '/../fonctions/modif_name_file.php';
    include_once dirname(__FILE__) . '/../class/enum_type.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/../../../src/class/Error_Log.php';

    /* le nom de l'image */
    $img = "";

    /* on verifit qu'une image a ete envoye */
    if(!empty($_FILES) && array_key_exists('file', $_FILES) && !empty($_FILES['file']['name'])) {
        /* on creer un nom unique pour l'image' */
        $name = modif_name_file($_FILES['file']['name']);
        /* on le deplace au bonne endroit avec le bon nom */
        if(add_img($_FILES['file']['tmp_name'], $name, Enum_Type::USER)) {
            $img = $name;
        }
    }
    
    /* creation d'un tableau avec les valeurs de recuperation du post */
    $values = array(
                ":name" => "",
                ":first_name" => "",
                ":login" => "",
                ":email" => "",
                ":description" => ""
            );

    /* recupere l'id de l'utilisateur */
    $values[":id_user"] = $_SESSION['id_user'];

    /* debut : de la recuperation des post */
    if(array_key_exists("name", $_POST) && !empty($_POST['name'])) {
        $values[":name"] = htmlspecialchars(stripslashes(trim($_POST['name'])));
    }
    if(array_key_exists("first-name", $_POST) && !empty($_POST['first-name'])) {
        $values[":first_name"] = htmlspecialchars(stripslashes(trim($_POST['first-name'])));
    }
    if(array_key_exists("login", $_POST) && !empty($_POST['login'])) {
        $values[":login"] = htmlspecialchars(stripslashes(trim($_POST['login'])));
    }
    if(array_key_exists("email", $_POST) && !empty($_POST['email'])) {
        $values[":email"] = htmlspecialchars(stripslashes(trim($_POST['email'])));
    }
    if(array_key_exists("description", $_POST) && !empty($_POST['description'])) {
        $values[":description"] = htmlspecialchars(stripslashes(trim($_POST['description'])));
    }
    /* fin : de la recuperation des post */

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $sgbd->beginTransaction();
            /* pour verifier la validiter des informations (eviter les doublons ou probleme de mot de passe) */
            $valide = true;
            /* verifier qu'on a bien entree un login */
            if(empty($values[":login"])) {
                echo "Merci d'entrer un login.";
                $valide = false;
            }
            /* verifier qu'on a bien entree un email */
            if($valide) {
                if(empty($values[":email"])) {
                    echo "Merci d'entrer un email.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le login n'a pas deja ete utilise par une autre personne */
                $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE login_user=:login && id_user!=:id_user");
                $res->execute([
                    ":login" => $values[":login"],
                    ":id_user" => $values[":id_user"]
                ]);
                /* si le login est deja utilise */
                if($res->rowCount() > 0) {
                    echo "le login est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                /* on verifit que le login n'a pas deja ete utilise par une autre personne */
                $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE email_user=:email && id_user!=:id_user");
                $res->execute([
                    ":email" => $values[":email"],
                    ":id_user" => $values[":id_user"]
                ]);
                /* si le login est deja utilise */
                if($res->rowCount() > 0) {
                    echo "l'email est déja utilisé, merci d'en prendre un autre.";
                    $valide = false;
                }
            }
            /* si c'est valide, on continu la verification */
            if($valide) {
                $res = $sgbd->prepare("UPDATE utilisateur SET nom_user=:name,prenom_user=:first_name,login_user=:login,email_user=:email, description_user=:description WHERE id_user=:id_user");
                $res->execute($values);
                /* si on a une image a entrer */
                if(!empty($img)) {
                    /* on recupere l'ancien fichier */
                    $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE id_user=:id");
                    $res->execute([
                        ":id" => $values[":id_user"]
                    ]);
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    /* on supprime l'ancien fichier */
                    delete_file($data["avatar_user"]);
                    /* on entre le nouveau fichier */
                    $res = $sgbd->prepare("UPDATE utilisateur SET avatar_user=:avatar_user WHERE id_user=:id_user");
                    $res->execute([
                        ":avatar_user" => $img,
                        ":id_user" => $values[":id_user"]
                    ]);
                    /* recupere l'avatar */
                    $_SESSION['avatar'] = $img;
                }
                
                /* recupere les informations de connexion */
                $_SESSION['nom'] = htmlspecialchars(stripslashes(trim($_POST['name'])));
                $_SESSION['prenom'] = htmlspecialchars(stripslashes(trim($_POST['first-name'])));
                $_SESSION['login'] = htmlspecialchars(stripslashes(trim($_POST['login'])));
                $_SESSION['email'] = htmlspecialchars(stripslashes(trim($_POST['email'])));
                
                echo "true";
            }
            /* on transmets les commits sous format securise */
            $sgbd->commit();
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
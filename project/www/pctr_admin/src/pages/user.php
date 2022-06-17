<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_user = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/user.html', true);

    /* creation des variables */
    $img = "./src/img/Add_Image_icon-icons_54218.svg";
    $name = "";
    $first_name = "";
    $login = "";
    $description = "";
    $email = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE id_user=:id");
            $res->execute([
                ":id" => $_SESSION['id_user']
            ]);
            if($res->rowCount() > 0) {
                $data = $res->fetch(PDO::FETCH_ASSOC);
                $name = $data["nom_user"];
                $first_name = $data["prenom_user"];
                $login = $data["login_user"];
                $email = $data["email_user"];
                $description = $data["description_user"];
                if(!empty($data["avatar_user"])) {
                    $img = "./../data/thumb/".$data["avatar_user"];
                }
            }
            
        } catch (Exception $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            //header("Status: 500");
            $page_acc->setNum_error(500);
        }
    } else {
        //header("Status: 500");
        $page_acc->setNum_error(500);
    }

    /* affiche les valeurs sur la page html */
    $html = str_replace("[##IMG_USER##]", $img, $html);
    $html = str_replace("[##NAME_USER##]", $name, $html);
    $html = str_replace("[##FIRST_NAME_USER##]", $first_name, $html);
    $html = str_replace("[##LOGIN_USER##]", $login, $html);
    $html = str_replace("[##EMAIL_USER##]", $email, $html);
    $html = str_replace("[##DESC_USER##]", $description, $html);

    /* recupere le contenu */
    $page_user->setContenu($html);
    $page_user->addCss("./src/css/addimg.css");
    $page_user->addCss("./src/css/style_add_logo.css");
    $page_user->addJs("./src/js/addimg.js");
    $page_user->addJs("./src/js/user.js");
    $page_user->addJs("./src/js/utilisateur_password.js");

} else {
    header("Status: 403");
}
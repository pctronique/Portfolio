<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_add_logo = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/add_logo.html', true);

    /* creation des variables */
    $id = 0;
    $img = "./src/img/Add_Image_icon-icons_54218.svg";
    $name = "";
    $title = "";
    $find = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a unid recuperer le contnu a afficher */
            if(!empty($_GET) && array_key_exists("id", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE id_competences_logo=:id");
                $res->execute([
                    ":id" => $_GET['id']
                ]);
                if($res->rowCount() > 0) {
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    $id = $_GET['id'];
                    $name = $data['nom_competences_logo'];
                    $title = $data['title_competences_logo'];
                    if(!empty($data["src_competences_logo"])) {
                        $img = "./../data/thumb/".$data["src_competences_logo"];
                    }
                }
            }

            /* recupere tout les contenu de la table sgbd */
            $res = $sgbd->prepare("SELECT * FROM competences_logo");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE (title_competences_logo  LIKE :find OR nom_competences_logo LIKE :find)");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("logo", $valueLine["id_competences_logo"], $valueLine["title_competences_logo"]);
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
    $html = str_replace("[##IMG_LOGO##]", $img, $html);
    $html = str_replace("[##ID_LOGO##]", $id, $html);
    $html = str_replace("[##NAME_LOGO##]", $name, $html);
    $html = str_replace("[##TITLE_LOGO##]", $title, $html);
    $html = str_replace("[##FIND_LOGO##]", $find, $html);

    /* recupere le contenu */
    $page_add_logo->setContenu($html);
    $page_add_logo->addCss("./src/css/addimg.css");
    $page_add_logo->addCss("./src/css/style_add_logo.css");
    $page_add_logo->addJs("./src/js/addimg.js");
    $page_add_logo->addJs("./src/js/add_logo.js");
} else {
    header("Status: 403");
}
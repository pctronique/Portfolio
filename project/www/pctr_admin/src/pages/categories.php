<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_cat = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

    /* creation des variables */
    $id = 0;
    $name = "";
    $desc = "";
    $find = "";
    $display = "checked";
    $img = "./src/img/Add_Image_icon-icons_54218.svg";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a unid recuperer le contnu a afficher */
            if(!empty($_GET) && array_key_exists("id", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM categorie WHERE id_cat=:id");
                $res->execute([
                    ":id" => $_GET['id']
                ]);
                if($res->rowCount() > 0) {
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    $id = $_GET['id'];
                    $name = $data['nom_cat'];
                    $desc = $data['description_cat'];
                    $display = $data['display_cat'] == "1" ? "checked" : "";
                    if(!empty($data["avatar_cat"])) {
                        $img = "./../data/thumb/".$data["avatar_cat"];
                    }
                }
            }

            /* recupere tout les contenu de la table sgbd */
            $res = $sgbd->prepare("SELECT * FROM categorie");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM categorie WHERE (nom_cat LIKE :find OR description_cat LIKE :find)");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("cat", $valueLine["id_cat"], $valueLine["nom_cat"], $valueLine['display_cat'] == "1", true);
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
    $html = str_replace("[##IMG_CAT##]", $img, $html);
    $html = str_replace("[##ID_CAT##]", $id, $html);
    $html = str_replace("[##NAME_CAT##]", $name, $html);
    $html = str_replace("[##DESC_CAT##]", $desc, $html);
    $html = str_replace("[##FIND_CAT##]", $find, $html);
    $html = str_replace("[##DISPLAY_CAT##]", $display, $html);

    /* recupere le contenu */
    $page_cat->setContenu($html);
    $page_cat->addCss("./src/css/addimg.css");
    $page_cat->addCss("./src/css/style_cat.css");
    $page_cat->addJs("./src/js/addimg.js");
    $page_cat->addJs("./src/js/categories.js");
} else {
    header("Status: 403");
}
<?php

/**
 * Afficher la page d'accueil.
 */


/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_add_cv = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/add_cv.html', true);

    /* creation des variables */
    $id = 0;
    $display = "checked";
    $src = "";
    $name = "";
    $title = "";
    $find = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a un id sur le lien de la page */
            if(!empty($_GET) && array_key_exists("id", $_GET)) {
                /* verifier que l'id retourne bien des valeurs */
                $res = $sgbd->prepare("SELECT * FROM cv WHERE id_cv=:id");
                $res->execute([
                    ":id" => $_GET['id']
                ]);
                if($res->rowCount() > 0) {
                    /* on recupere les valeurs */
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    $id = $_GET['id'];
                    $name = $data['nom_cv'];
                    $title = $data['title_cv'];
                    $display = $data['display_cv'] == "1" ? "checked" : "";
                    if(!empty($data["src_cv"])) {
                        $src = $data["src_cv"];
                    }
                }
            }

            /* recupere tout les contenu de la table sgbd */
            $res = $sgbd->prepare("SELECT * FROM cv");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                /* recupere les valeurs trouves */
                $res = $sgbd->prepare("SELECT * FROM cv WHERE (title_cv LIKE :find OR nom_cv LIKE :find)");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("cv", $valueLine["id_cv"], $valueLine["title_cv"], $valueLine['display_cv'] == "1", true);
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
    $html = str_replace("[##SRC_CV##]", $src, $html);
    $html = str_replace("[##ID_CV##]", $id, $html);
    $html = str_replace("[##NAME_CV##]", $name, $html);
    $html = str_replace("[##TITLE_CV##]", $title, $html);
    $html = str_replace("[##FIND_CV##]", $find, $html);
    $html = str_replace("[##DISPLAY_CV##]", $display, $html);

    /* recupere le contenu */
    $page_add_cv->setContenu($html);
    /* recuper le js lier a la page */
    $page_add_cv->addJs("./src/js/add_cv.js");
} else {
    header("Status: 403");
}
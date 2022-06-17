<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_loisir = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/loisir.html', true);

    /* creation des variables */
    $id = 0;
    $display = "checked";
    $name = "";
    $desc = "";
    $find = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a unid recuperer le contnu a afficher */
            if(!empty($_GET) && array_key_exists("id", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM loisir WHERE id_loisir=:id");
                $res->execute([
                    ":id" => $_GET['id']
                ]);
                if($res->rowCount() > 0) {
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    $id = $_GET['id'];
                    $name = $data['name_loisir'];
                    $desc = $data['description_loisir'];
                    $display = $data['display_loisir'] == "1" ? "checked" : "";
                }
            }

            /* recupere tout les contenu de la table sgbd */
            $res = $sgbd->prepare("SELECT * FROM loisir");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM loisir WHERE (name_loisir LIKE :find OR description_loisir LIKE :find)");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("cat", $valueLine["id_loisir"], $valueLine["name_loisir"], $valueLine['display_loisir'] == "1", true);
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
    $html = str_replace("[##ID_LOISI##]", $id, $html);
    $html = str_replace("[##NAME_LOISI##]", $name, $html);
    $html = str_replace("[##DESC_LOISI##]", $desc, $html);
    $html = str_replace("[##FIND_LOISI##]", $find, $html);
    $html = str_replace("[##DISPLAY_LOISI##]", $display, $html);

    /* recupere le contenu */
    $page_loisir->setContenu($html);
    $page_loisir->addJs("./src/js/loisir.js");
} else {
    header("Status: 403");
}
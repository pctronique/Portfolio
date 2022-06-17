<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    /* pour ajouter les checkbox dans la page */
    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, string $src, bool $checked = false) {
        $checkbox = "<figure><input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<img class=\"logo-img\" src=\"./../data/img/".$src."\" alt=\"logo ".$name."\" /><label class=\"form-check-label text-light\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label></figure>[##n##]"."\n";
        return $checkbox;
    }

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_comp_logo = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/comp_logo.html', true);

    /* creation des variables */
    $id = 0;
    $tab_logo = [];
    $logos = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* recupere les logos active */
            $res = $sgbd->prepare("SELECT * FROM competences_logo_user WHERE id_user=:id_user");
            $res->execute([":id_user" => $_SESSION['id_user']]);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                array_push($tab_logo, $valueLine["id_competences_logo"]);
            }

            /* recupere tout les contenu de la table sgbd a afficher */
            $res = $sgbd->prepare("SELECT * FROM competences_logo");
            $res->execute();
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            /* selectionne ou non les logos */
            foreach ($data as $valueLine) {
                $the_checked = false;
                if (in_array($valueLine["id_competences_logo"], $tab_logo)) {
                    $the_checked = true;
                }
                $logos .= addCheckbox("logo", $valueLine["id_competences_logo"], $valueLine["title_competences_logo"], $valueLine["id_competences_logo"], $valueLine["src_competences_logo"], $the_checked);
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
    $html = str_replace("[##CHECK_LOGO##]", $logos, $html);
    $html = str_replace("[##n##]", "<br />", $html);

    /* recupere le contenu */
    $page_comp_logo->setContenu($html);
    $page_comp_logo->addJs("./src/js/comp_logo.js");
} else {
    header("Status: 403");
}
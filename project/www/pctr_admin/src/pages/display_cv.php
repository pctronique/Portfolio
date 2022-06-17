<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    /* pour ajouter les checkbox dans la page */
    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, bool $checked = false) {
        $checkbox = "<input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<label class=\"form-check-label text-light\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label>[##n##]"."\n";
        return $checkbox;
    }

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_disp_cv = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/display_cv.html', true);

    /* creation des variables */
    $id = 0;
    $tab_cv = [];
    $cv = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* recupere les cv selectionnes */
            $res = $sgbd->prepare("SELECT * FROM cv_display WHERE id_user=:id_user");
            $res->execute([":id_user" => $_SESSION['id_user']]);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                array_push($tab_cv, $valueLine["id_cv"]);
            }

            /* recupere tout les contenu de la table sgbd */
            $res = $sgbd->prepare("SELECT * FROM cv WHERE id_user=:id_user");
            $res->execute([":id_user" => $_SESSION['id_user']]);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            /* selectionne ou non les cv */
            foreach ($data as $valueLine) {
                $the_checked = false;
                if (in_array($valueLine["id_cv"], $tab_cv)) {
                    $the_checked = true;
                }
                $cv .= addCheckbox("cv", $valueLine["id_cv"], $valueLine["title_cv"], $valueLine["id_cv"], $the_checked);
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
    $html = str_replace("[##CHECK_CV##]", $cv, $html);
    $html = str_replace("[##n##]", "<br />", $html);

    /* recupere le contenu */
    $page_disp_cv->setContenu($html);
    $page_disp_cv->addJs("./src/js/display_cv.js");
} else {
    header("Status: 403");
}
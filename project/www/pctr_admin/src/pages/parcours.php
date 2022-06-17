<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_parc = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/parcours.html', true);

    /* creation des variables */
    $id = 0;
    $exp = "checked";
    $display = "checked";
    $form = "";
    $name = "";
    $title = "";
    $entreprise = "";
    $start = "";
    $progress = "";
    $fin = "";
    $lieu = "";
    $desc = "";
    $find = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a unid recuperer le contnu a afficher */
            if(!empty($_GET) && array_key_exists("id", $_GET)) {
                /* recupere le parcours */
                $res = $sgbd->prepare("SELECT * FROM parcours WHERE id_parcours=:id");
                $res->execute([
                    ":id" => $_GET['id']
                ]);
                /* s'il n'est pas vide */
                if($res->rowCount() > 0) {
                    /* recupere le type de parcours */
                    $exp = "";
                    $form = "";
                    /* pour une formation */
                    $resForm = $sgbd->prepare("SELECT * FROM formations WHERE id_parcours=:id");
                    $resForm->execute([
                        ":id" => $_GET['id']
                    ]);
                    if($resForm->rowCount() > 0) {
                        $form = "checked";
                    }
                    /* experience professionel */
                    $resExp = $sgbd->prepare("SELECT * FROM experiences WHERE id_parcours=:id");
                    $resExp->execute([
                        ":id" => $_GET['id']
                    ]);
                    if($resExp->rowCount() > 0) {
                        $exp = "checked";
                    }
                    /* recupere les informations du parcours */
                    $data = $res->fetch(PDO::FETCH_ASSOC);
                    $id = $_GET['id'];
                    $name = $data['nom_parcours'];
                    $title = $data['title_parcours'];
                    $entreprise = $data['entreprise_parcours'];
                    if($data['date_debut_parcours'] != "0000-00-00 00:00:00") {
                        $start = date('Y-m-d', strtotime($data['date_debut_parcours']));
                    }
                    $display = $data['display_parcours'] == "1" ? "checked" : "";
                    $progress = $data['in_progress_parcours'] == "1" ? "checked" : "";
                    if($data['date_fin_parcours'] != "0000-00-00 00:00:00") {
                        $fin = date('Y-m-d', strtotime($data['date_fin_parcours']));
                    }
                    $lieu = $data['lieu_parcours'];
                    $desc = $data['description_parcours'];
                }
            }

            /* pour remplir le tableau de la page */
            $res = $sgbd->prepare("SELECT * FROM parcours");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                $res = $sgbd->prepare("SELECT * FROM parcours WHERE (nom_parcours LIKE :find OR title_parcours LIKE :find OR ".
                    "entreprise_parcours LIKE :find OR type_parcours LIKE :find OR ".
                    "lieu_parcours LIKE :find OR description_parcours LIKE :find ".
                    ")");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("comp", $valueLine["id_parcours"], $valueLine["nom_parcours"], $valueLine['display_parcours'] == "1", true);
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
    $html = str_replace("[##ID_PARC##]", $id, $html);
    $html = str_replace("[##ENTREPRISE_PARC##]", $entreprise, $html);
    $html = str_replace("[##EXP_PARC##]", $exp, $html);
    $html = str_replace("[##FORM_PARC##]", $form, $html);
    $html = str_replace("[##NAME_PARC##]", $name, $html);
    $html = str_replace("[##TITLE_PARC##]", $title, $html);
    $html = str_replace("[##START_PARC##]", $start, $html);
    $html = str_replace("[##PROGRESS_PARC##]", $progress, $html);
    $html = str_replace("[##FIN_PARC##]", $fin, $html);
    $html = str_replace("[##LIEU_PARC##]", $lieu, $html);
    $html = str_replace("[##DESC_PARC##]", $desc, $html);
    $html = str_replace("[##FIND_PARC##]", $find, $html);
    $html = str_replace("[##DISPLAY_PARC##]", $display, $html);

    /* recupere le contenu */
    $page_parc->setContenu($html);
    $page_parc->addJs("./src/js/parcours.js");
} else {
    header("Status: 403");
}
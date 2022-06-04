<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_parc = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/parcours.html', true);

    $id = 0;
    $exp = "checked";
    $form = "";
    $title = "";
    $start = "";
    $progress = "";
    $fin = "";
    $compt = "";
    $lieu = "";
    $desc = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM parcours WHERE id_parcours=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $title = $data['title_compt'];
            $start = $data['date_debut_parcours'];
            $progress = $data['in_progress_parcours'] == "1" ? "checked" : "";
            $fin = $data['date_fin_parcours'];
            $compt = $data['type_parcours'];
            $lieu = $data['lieu_parcours'];
            $desc = $data['description_parcours'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM parcours");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("comp", $valueLine["id_parcours"], $valueLine["title_compt"]);
    }

    $html = str_replace("[##ID_PARC##]", $id, $html);
    $html = str_replace("[##EXP_PARC##]", $exp, $html);
    $html = str_replace("[##FORM_PARC##]", $form, $html);
    $html = str_replace("[##TITLE_PARC##]", $title, $html);
    $html = str_replace("[##START_PARC##]", $start, $html);
    $html = str_replace("[##PROGRESS_PARC##]", $progress, $html);
    $html = str_replace("[##FIN_PARC##]", $fin, $html);
    $html = str_replace("[##COMPT_PARC##]", $compt, $html);
    $html = str_replace("[##LIEU_PARC##]", $lieu, $html);
    $html = str_replace("[##DESC_PARC##]", $desc, $html);
    $html = str_replace("[##FIND_PARC##]", $find, $html);
    $page_parc->setContenu($html);
    $page_parc->addJs("./src/js/parcours.js");
} else {
    header('Location: ./../../../');
    exit();
}
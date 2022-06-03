<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_compt = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true);

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
        $res = $sgbd->prepare("SELECT * FROM list_competences WHERE id_list_competences=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $title = $data['title_compt'];
            $start = $data['date_denut_competence'];
            $progress = $data['in_progress_competence'] == "1" ? "checked" : "";
            $fin = $data['date_fin_competences'];
            $compt = $data['type_competence'];
            $lieu = $data['lieu_competence'];
            $desc = $data['description_competence'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM list_competences");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("comp", $valueLine["id_list_competences"], $valueLine["title_compt"]);
    }

    $html = str_replace("[##ID_COMP##]", $id, $html);
    $html = str_replace("[##EXP_COMP##]", $exp, $html);
    $html = str_replace("[##FORM_COMP##]", $form, $html);
    $html = str_replace("[##TITLE_COMP##]", $title, $html);
    $html = str_replace("[##START_COMP##]", $start, $html);
    $html = str_replace("[##PROGRESS_COMP##]", $progress, $html);
    $html = str_replace("[##FIN_COMP##]", $fin, $html);
    $html = str_replace("[##COMPT_COMP##]", $compt, $html);
    $html = str_replace("[##LIEU_COMP##]", $lieu, $html);
    $html = str_replace("[##DESC_COMP##]", $desc, $html);
    $html = str_replace("[##FIND_COMP##]", $find, $html);
    $page_compt->setContenu($html);
    $page_compt->addJs("./src/js/competences.js");
} else {
    header('Location: ./../../../');
    exit();
}
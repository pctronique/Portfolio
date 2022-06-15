<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_comp = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true);

    $id = 0;
    $display = "checked";
    $name = "";
    $desc = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM competences WHERE id_competences=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['title_competence'];
            $desc = $data['description_competences'];
            $display = $data['display_competences'] == "1" ? "checked" : "";
        }
    }

    $res = $sgbd->prepare("SELECT * FROM competences");
    $res->execute();

    if(!empty($_GET) && array_key_exists("find", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM competences WHERE (title_competence LIKE :find OR description_competences LIKE :find)");
        $res->execute([":find" => "%".$_GET["find"]."%"]);
    }

    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("info", $valueLine["id_competences"], $valueLine["title_competence"], $valueLine['display_competences'] == "1", true);
    }

    $html = str_replace("[##ID_COMP##]", $id, $html);
    $html = str_replace("[##NAME_COMP##]", $name, $html);
    $html = str_replace("[##DESC_COMP##]", $desc, $html);
    $html = str_replace("[##FIND_COMP##]", $find, $html);
    $html = str_replace("[##DISPLAY_COMP##]", $display, $html);
    $page_comp->setContenu($html);
    $page_comp->addJs("./src/js/competences.js");
} else {
    header("Status: 403");
}
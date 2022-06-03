<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_info = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/informations.html', true);

    $id = 0;
    $name = "";
    $desc = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM info_competences WHERE id_info_competences=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['title_info_competence'];
            $desc = $data['description_competences'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM info_competences");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("info", $data["id_info_competences"], $data["title_info_competence"]);
    }

    $html = str_replace("[##ID_INF##]", $id, $html);
    $html = str_replace("[##NAME_INF##]", $name, $html);
    $html = str_replace("[##DESC_INF##]", $desc, $html);
    $html = str_replace("[##FIND_INF##]", $find, $html);
    $page_info->setContenu($html);
    $page_info->addJs("./src/js/informations.js");
} else {
    header('Location: ./../../../');
    exit();
}
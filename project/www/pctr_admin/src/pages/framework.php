<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_framW = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/framework.html', true);

    $id = 0;
    $name = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM  framework WHERE id_framework=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_framework'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM  framework");
    $res->execute();

    if(!empty($_GET) && array_key_exists("find", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM framework WHERE (nom_framework  LIKE :find)");
        $res->execute([":find" => "%".$_GET["find"]."%"]);
    }

    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("framw", $valueLine["id_framework"], $valueLine["nom_framework"]);
    }

    $html = str_replace("[##ID_FRAMW##]", $id, $html);
    $html = str_replace("[##NAME_FRAMW##]", $name, $html);
    $html = str_replace("[##FIND_FRAMW##]", $find, $html);
    $page_framW->setContenu($html);
    $page_framW->addJs("./src/js/framework.js");
} else {
    header("Status: 403");
}
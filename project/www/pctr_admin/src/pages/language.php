<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_langP = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/language.html', true);

    $id = 0;
    $name = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM language WHERE id_language=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_language'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM language");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("langp", $valueLine["id_language"], $valueLine["nom_language"]);
    }

    $html = str_replace("[##ID_LANGP##]", $id, $html);
    $html = str_replace("[##NAME_LANGP##]", $name, $html);
    $html = str_replace("[##FIND_LANGP##]", $find, $html);
    $page_langP->setContenu($html);
    $page_langP->addJs("./src/js/language.js");
} else {
    header("Status: 403");
}
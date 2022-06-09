<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_loisir = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/loisir.html', true);

    $id = 0;
    $display = "checked";
    $name = "";
    $desc = "";
    $find = "";

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

    $res = $sgbd->prepare("SELECT * FROM loisir");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("cat", $valueLine["id_loisir"], $valueLine["name_loisir"]);
    }

    $html = str_replace("[##ID_LOISI##]", $id, $html);
    $html = str_replace("[##NAME_LOISI##]", $name, $html);
    $html = str_replace("[##DESC_LOISI##]", $desc, $html);
    $html = str_replace("[##FIND_LOISI##]", $find, $html);
    $html = str_replace("[##DISPLAY_LOISI##]", $display, $html);
    $page_loisir->setContenu($html);
    $page_loisir->addJs("./src/js/loisir.js");
} else {
    header('Location: ./../../../');
    exit();
}
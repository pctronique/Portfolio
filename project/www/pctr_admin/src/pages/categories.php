<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_cat = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

    $id = 0;
    $name = "";
    $desc = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM categorie WHERE id_cat=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_cat'];
            $desc = $data['description_cat'];
        }
    }

    $res = $sgbd->prepare("SELECT * FROM categorie");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("cat", $valueLine["id_cat"], $valueLine["nom_cat"]);
    }

    $html = str_replace("[##ID_CAT##]", $id, $html);
    $html = str_replace("[##NAME_CAT##]", $name, $html);
    $html = str_replace("[##DESC_CAT##]", $desc, $html);
    $html = str_replace("[##FIND_CAT##]", $find, $html);
    $page_cat->setContenu($html);
    $page_cat->addJs("./src/js/categories.js");
} else {
    header('Location: ./../../../');
    exit();
}
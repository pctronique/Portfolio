<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_add_logo = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/add_logo.html', true);

    $id = 0;
    $img = "./src/img/icons8-ajouter-une-image-90.png";
    $name = "";
    $title = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM competences_logo WHERE id_competences_logo=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_competences_logo'];
            $title = $data['title_competences_logo'];
            if(!empty($data["src_competences_logo"])) {
                $img = "./../data/img/".$data["src_competences_logo"];
            }
        }
    }

    $res = $sgbd->prepare("SELECT * FROM competences_logo");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("logo", $valueLine["id_competences_logo"], $valueLine["title_competences_logo"]);
    }

    $html = str_replace("[##IMG_LOGO##]", $img, $html);
    $html = str_replace("[##ID_LOGO##]", $id, $html);
    $html = str_replace("[##NAME_LOGO##]", $name, $html);
    $html = str_replace("[##TITLE_LOGO##]", $title, $html);
    $html = str_replace("[##FIND_LOGO##]", $find, $html);
    $page_add_logo->setContenu($html);
    $page_add_logo->addCss("./src/css/addimg.css");
    $page_add_logo->addJs("./src/js/addimg.js");
    $page_add_logo->addJs("./src/js/add_logo.js");
} else {
    header('Location: ./../../../');
    exit();
}
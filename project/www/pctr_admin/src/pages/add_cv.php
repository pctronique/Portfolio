<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_add_cv = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/add_cv.html', true);

    $id = 0;
    $src = "";
    $name = "";
    $title = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM cv WHERE id_cv=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_cv'];
            $title = $data['title_cv'];
            if(!empty($data["src_cv"])) {
                $src = $data["src_cv"];
            }
        }
    }

    $res = $sgbd->prepare("SELECT * FROM cv");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("cv", $valueLine["id_cv"], $valueLine["title_cv"]);
    }

    $html = str_replace("[##SRC_CV##]", $src, $html);
    $html = str_replace("[##ID_CV##]", $id, $html);
    $html = str_replace("[##NAME_CV##]", $name, $html);
    $html = str_replace("[##TITLE_CV##]", $title, $html);
    $html = str_replace("[##FIND_CV##]", $find, $html);
    $page_add_cv->setContenu($html);
    $page_add_cv->addJs("./src/js/add_cv.js");
} else {
    header('Location: ./../../../');
    exit();
}
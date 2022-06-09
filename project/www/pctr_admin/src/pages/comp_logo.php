<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, string $src, bool $checked = false) {
        $checkbox = "<figure><input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<img class=\"logo-img\" src=\"./../data/img/".$src."\" alt=\"logo ".$name."\" /><label class=\"form-check-label text-light\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label></figure>[##n##]"."\n";
        return $checkbox;
    }

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_comp_logo = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/comp_logo.html', true);

    $id = 0;
    $tab_logo = [];
    $logos = "";

    $res = $sgbd->prepare("SELECT * FROM competences_logo_user WHERE id_user=:id_user");
    $res->execute([":id_user" => $_SESSION['id_user']]);
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        array_push($tab_logo, $valueLine["id_competences_logo"]);
    }
    
    $res = $sgbd->prepare("SELECT * FROM competences_logo");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $the_checked = false;
        if (in_array($valueLine["id_competences_logo"], $tab_logo)) {
            $the_checked = true;
        }
        $logos .= addCheckbox("logo", $valueLine["id_competences_logo"], $valueLine["title_competences_logo"], $valueLine["id_competences_logo"], $valueLine["src_competences_logo"], $the_checked);
    }

    $html = str_replace("[##CHECK_LOGO##]", $logos, $html);
    $html = str_replace("[##n##]", "<br />", $html);
    $page_comp_logo->setContenu($html);
    $page_comp_logo->addJs("./src/js/comp_logo.js");
} else {
    header('Location: ./../../../');
    exit();
}
<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, bool $checked = false) {
        $checkbox = "<input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<label class=\"form-check-label text-light\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label>[##n##]"."\n";
        return $checkbox;
    }

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_disp_cv = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/display_cv.html', true);

    $id = 0;
    $tab_cv = [];
    $cv = "";

    $res = $sgbd->prepare("SELECT * FROM cv_display WHERE id_user=:id_user");
    $res->execute([":id_user" => $_SESSION['id_user']]);
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        array_push($tab_cv, $valueLine["id_cv"]);
    }
    
    $res = $sgbd->prepare("SELECT * FROM cv WHERE id_user=:id_user");
    $res->execute([":id_user" => $_SESSION['id_user']]);
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $the_checked = false;
        if (in_array($valueLine["id_cv"], $tab_cv)) {
            $the_checked = true;
        }
        $cv .= addCheckbox("cv", $valueLine["id_cv"], $valueLine["title_cv"], $valueLine["id_cv"], $the_checked);
    }

    $html = str_replace("[##CHECK_CV##]", $cv, $html);
    $html = str_replace("[##n##]", "<br />", $html);
    $page_disp_cv->setContenu($html);
    $page_disp_cv->addJs("./src/js/display_cv.js");
} else {
    header("Status: 403");
}
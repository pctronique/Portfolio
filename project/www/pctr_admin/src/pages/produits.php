<?php

function add(?string $name, ?string $title, bool $checked = false) {
    $checkbox = "<input class=\"form-check-input\" type=\"checkbox\" value=\"\" name=\"".$name."\" id=\"flexCheckDefault\"";
    $checkbox .= $checked ? "" : "checked"." >"."\n";
    $checkbox .= "<label class=\"form-check-label text-light\" for=\"flexCheckDefault\">"."\n";
    $checkbox .= $title."\n";
    $checkbox .= "</label>"."\n";
    return $checkbox;
}

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_prod = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/produits.html', true);

$name = "";
$desc = "";
$cat = "";
$langp = "";
$find = "";

$html = str_replace("[##NAME_PROD##]", $name, $html);
$html = str_replace("[##DESC_PROD##]", $desc, $html);
$html = str_replace("[##CAT_PROD##]", $cat, $html);
$html = str_replace("[##LANGP_PROD##]", $langp, $html);
$html = str_replace("[##FIND_PROD##]", $find, $html);
$page_prod->setContenu($html);
$page_prod->addCss("./src/js/produits.js");
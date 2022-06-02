<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_loisir = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/loisir.html', true);

$name = "";
$desc = "";
$find = "";

$html = str_replace("[##NAME_LOISI##]", $name, $html);
$html = str_replace("[##DESC_LOISI##]", $desc, $html);
$html = str_replace("[##FIND_LOISI##]", $find, $html);
$page_loisir->setContenu($html);
$page_loisir->addCss("./src/js/loisir.js");
<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_cat = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

$name = "";
$desc = "";
$find = "";

$html = str_replace("[##NAME_CAT##]", $name, $html);
$html = str_replace("[##DESC_CAT##]", $desc, $html);
$html = str_replace("[##FIND_CAT##]", $find, $html);
$page_cat->setContenu($html);
$page_cat->addCss("./src/js/categories.js");
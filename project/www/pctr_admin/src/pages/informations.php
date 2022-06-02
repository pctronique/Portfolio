<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_info = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/informations.html', true);

$name = "";
$desc = "";
$find = "";

$html = str_replace("[##NAME_COMPT##]", $name, $html);
$html = str_replace("[##DESC_COMPT##]", $desc, $html);
$html = str_replace("[##FIND_COMPT##]", $find, $html);
$page_info->setContenu($html);
$page_info->addCss("./src/js/informations.js");
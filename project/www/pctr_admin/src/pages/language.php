<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_langP = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/language.html', true);

$name = "";
$find = "";

$html = str_replace("[##NAME_LANGP##]", $name, $html);
$html = str_replace("[##FIND_LANGP##]", $find, $html);
$page_langP->setContenu($html);
$page_langP->addCss("./src/js/language.js");
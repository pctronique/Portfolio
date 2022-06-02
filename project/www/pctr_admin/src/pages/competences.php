<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_compt = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true);

$exp = "checked";
$form = "";
$title = "";
$start = "";
$progress = "";
$fin = "";
$compt = "";
$lieu = "";
$desc = "";
$find = "";

$html = str_replace("[##EXP_COMP##]", $exp, $html);
$html = str_replace("[##FORM_COMP##]", $form, $html);
$html = str_replace("[##TITLE_COMP##]", $title, $html);
$html = str_replace("[##START_COMP##]", $start, $html);
$html = str_replace("[##PROGRESS_COMP##]", $progress, $html);
$html = str_replace("[##FIN_COMP##]", $fin, $html);
$html = str_replace("[##COMPT_COMP##]", $compt, $html);
$html = str_replace("[##LIEU_COMP##]", $lieu, $html);
$html = str_replace("[##DESC_COMP##]", $desc, $html);
$html = str_replace("[##FIND_COMP##]", $find, $html);
$page_compt->setContenu($html);
$page_compt->addCss("./src/js/competences.js");
<?php

include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

$page_cat = new Contenu_Page();

$name_cat = "WEB";

$html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

$html = str_replace("[##categorie##]", $name_cat, $html);

$page_cat->setContenu($html);
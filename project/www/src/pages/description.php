<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "desc" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_desc = new Contenu_Page();

    $name_desc = "WEB";

    $html = file_get_contents(dirname(__FILE__) . '/../templates/description.html', true);

    $html = str_replace("[##produit##]", $name_desc, $html);

    $page_desc->addCss("./src/css/style_description.css");
    $page_desc->setContenu($html);

}
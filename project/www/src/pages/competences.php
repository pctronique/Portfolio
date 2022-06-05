<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "comp" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_compet = new Contenu_Page();

    $page_compet->addCss("./src/css/style_competences.css");
    $page_compet->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true));

}
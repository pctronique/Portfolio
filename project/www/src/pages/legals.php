<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "legales" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_legal = new Contenu_Page();

    $page_legal->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/legal.html', true));

}
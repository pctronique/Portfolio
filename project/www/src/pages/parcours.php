<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "parc" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_parc = new Contenu_Page();

    $page_parc->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/parcours.html', true));

}
<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_acc = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true);

    $html = str_replace("[##NAME##]", $_SESSION['prenom'], $html);

    $page_acc->setContenu($html);
} else {
    header("Status: 403");
}
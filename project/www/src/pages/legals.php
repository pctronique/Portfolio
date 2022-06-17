<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "legales" && defined("USER_ID") && !empty(USER_ID)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_legal = new Contenu_Page();

    /* recupere le contenu a afficher */
    $page_legal->addCss("./src/css/legals.css");
    $page_legal->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/legals.html', true));

} else {
    header("Status: 403");
}
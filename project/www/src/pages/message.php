<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "msg" && defined("USER_ID") && !empty(USER_ID)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_msg = new Contenu_Page();

    /* recupere le contenu a afficher */
    $page_msg->addCss("./src/css/style_message.css");
    $page_msg->addJs("./src/js/message.js");
    $page_msg->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/message.html', true));

} else {
    header("Status: 403");
}
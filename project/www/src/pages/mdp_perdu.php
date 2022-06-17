<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "mmdp" && defined("USER_ID") && !empty(USER_ID)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_mmdp = new Contenu_Page();

    /* recupere le contenu a afficher */
    $page_mmdp->addCss("./src/css/style_message.css");
    $page_mmdp->addJs("./src/js/message.js");
    $page_mmdp->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/mdp_perdu.html', true));

} else {
    header("Status: 403");
}
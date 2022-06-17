<?php
/**
 * Afficher la page du mot de passe perdu. 
 */

/* affiche le contenu de la page html */

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "mmdp" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_mmdp = new Contenu_Page();

    $page_mmdp->addCss("./src/css/style_message.css");
    $page_mmdp->addJs("./src/js/message.js");
    $page_mmdp->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/mdp_perdu.html', true));

} else {
    header("Status: 403");
}
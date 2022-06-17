<?php
/**
 * Afficher la page d'accueil.
 */

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_acc = new Contenu_Page();

    /* entrer le html de la page */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true);

    /* remplacer les valeurs de la page a afficher */
    $html = str_replace("[##NAME##]", $_SESSION['prenom'], $html);

    /* recupere le contenu */
    $page_acc->setContenu($html);
} else {
    header("Status: 403");
}
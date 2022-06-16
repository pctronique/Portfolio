<?php
/**
 * Pour afficher le resultat d'une recherche sur le tableau de l'ecran.
 */

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION) && !empty($_GET) && array_key_exists("tab", $_GET)) {

        /* creation d'un tableau, pour les valeur a afficher */
        $tab = "";

        /* recupere les valeurs */
        if(!empty($_GET["tab"])) {
            if($_GET["tab"] == "add_cv") {
                include_once dirname(__FILE__) . '/../fonctions/find_add_cv.php';
                $tab = find_add_cv();
            }
        }

        /* transmets les valeurs */
        echo "true"."[##TAB_FIND##]".$tab;

} else {
    header("Status: 403");
}
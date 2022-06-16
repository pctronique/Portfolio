<?php
/**
 * Afficher la page pour modifier le mot de passe.
 */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "mmdp" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* recupere le contenu de la page html a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/modif_mdp.html', true);
    /* si aucun code n'est entree */
    $code = "";
    if(!empty($_GET) && array_key_exists("code", $_GET)) {
        /* si on a un code, le recuperer */
        $code = $_GET["code"];
    }

    $page_mmdp = new Contenu_Page();

    $page_mmdp->addCss("./src/css/style_message.css");
    $page_mmdp->addJs("./src/js/modif_mdp.js");
    $page_mmdp->setContenu(str_replace("#code#",$code,$html));

} else {
    header("Status: 403");
}


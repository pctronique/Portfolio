<?php

/*Connexion*/
include_once dirname(__FILE__) . '/src/fonctions/connexion_sgbd.php';

$sgbd = connexion_sgbd();
if(!empty($sgbd)) {

}

$ind=null;

include_once dirname(__FILE__) . '/src/pages/acc.php';
$css = $page_acc->displayCss();
$js = $page_acc->displayJs();
$contenu = $page_acc->getContenu();

if(!empty($_GET) && array_key_exists("ind", $_GET)) {
    $ind=$_GET['ind'];
}

if(!empty($ind)) {
    if($ind == "desc") {
        include_once dirname(__FILE__) . '/src/pages/description.php';
        $css = $page_desc->displayCss();
        $js = $page_desc->displayJs();
        $contenu = $page_desc->getContenu();
    } else if($ind == "cat") {
        include_once dirname(__FILE__) . '/src/pages/categories.php';
        $css = $page_cat->displayCss();
        $js = $page_cat->displayJs();
        $contenu = $page_cat->getContenu();
    } else if($ind == "comp") {
        include_once dirname(__FILE__) . '/src/pages/competences.php';
        $css = $page_compet->displayCss();
        $js = $page_compet->displayJs();
        $contenu = $page_compet->getContenu();
    } else if($ind == "parc") {
        include_once dirname(__FILE__) . '/src/pages/parcours.php';
        $css = $page_parc->displayCss();
        $js = $page_parc->displayJs();
        $contenu = $page_parc->getContenu();
    } else if($ind == "msg") {
        include_once dirname(__FILE__) . '/src/pages/message.php';
        $css = $page_msg->displayCss();
        $js = $page_msg->displayJs();
        $contenu = $page_msg->getContenu();
    } else if($ind == "legales") {
        include_once dirname(__FILE__) . '/src/pages/legals.php';
        $css = $page_legal->displayCss();
        $js = $page_legal->displayJs();
        $contenu = $page_legal->getContenu();
    }
}

echo str_replace("[##CONTENU_CSS##]", !empty($css) ? "\n".$css : "", 
    str_replace("[##CONTENU_JS##]", !empty($js) ? "\n".$js : "",
    str_replace("[##CONTENU##]", $contenu, 
    file_get_contents(dirname(__FILE__) . '/src/templates/menu_footer_header.html', true))));
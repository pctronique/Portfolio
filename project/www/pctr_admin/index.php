<?php

/*Connexion*/
include_once dirname(__FILE__) . '/../src/fonctions/connexion_sgbd.php';

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
        include_once dirname(__FILE__) . '/src/pages/produits.php';
        $css = $page_prod->displayCss();
        $js = $page_prod->displayJs();
        $contenu = $page_prod->getContenu();
    } else if($ind == "cat") {
        include_once dirname(__FILE__) . '/src/pages/categories.php';
        $css = $page_cat->displayCss();
        $js = $page_cat->displayJs();
        $contenu = $page_cat->getContenu();
    } else if($ind == "comp") {
        include_once dirname(__FILE__) . '/src/pages/competences.php';
        $css = $page_compt->displayCss();
        $js = $page_compt->displayJs();
        $contenu = $page_compt->getContenu();
    } else if($ind == "lang") {
        include_once dirname(__FILE__) . '/src/pages/language.php';
        $css = $page_langP->displayCss();
        $js = $page_langP->displayJs();
        $contenu = $page_langP->getContenu();
    } else if($ind == "loisi") {
        include_once dirname(__FILE__) . '/src/pages/loisir.php';
        $css = $page_loisir->displayCss();
        $js = $page_loisir->displayJs();
        $contenu = $page_loisir->getContenu();
    } else if($ind == "info") {
        include_once dirname(__FILE__) . '/src/pages/informations.php';
        $css = $page_info->displayCss();
        $js = $page_info->displayJs();
        $contenu = $page_info->getContenu();
    } else if($ind == "user") {
        include_once dirname(__FILE__) . '/src/pages/user.php';
        $css = $page_user->displayCss();
        $js = $page_user->displayJs();
        $contenu = $page_user->getContenu();
    }
}

echo str_replace("[##CONTENU_CSS##]", !empty($css) ? "\n".$css : "", 
    str_replace("[##CONTENU_JS##]", !empty($js) ? "\n".$js : "",
    str_replace("[##CONTENU##]", $contenu, 
    file_get_contents(dirname(__FILE__) . '/src/templates/menu_footer_header.html', true))));
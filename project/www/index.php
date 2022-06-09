<?php

define("USER_ID", "1");

/*Connexion*/
include_once dirname(__FILE__) . '/src/fonctions/connexion_sgbd.php';

session_start();

$isConnected = false;

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
array_key_exists('email', $_SESSION)) {
    $isConnected = true;
}

$cats = "";

$sgbd = connexion_sgbd();
if(!empty($sgbd)) {
    $res = $sgbd->prepare("SELECT * FROM categorie");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $cats .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./?ind=cat&cat=".$valueLine["id_cat"]."\">".$valueLine["nom_cat"]."</a></li>";
    }
}

$ind=null;

include_once dirname(__FILE__) . '/src/pages/acc.php';
$css = $page_acc->displayCss();
$js = $page_acc->displayJs();
$contenu = $page_acc->getContenu();

if(!empty($_GET) && array_key_exists("ind", $_GET)) {
    $ind=$_GET['ind'];
}

$connected = "<input type=\"checkbox\" name=\"pass-perdu-display\" id=\"pass-perdu-display\" />";
$connected .= "<form id=\"form-pass\" action=\"#\" method=\"post\">";
$connected .= "<input type=\"text\" name=\"name-user\" id=\"name-user\" placeholder=\"Login\" />";
$connected .= "<input type=\"password\" name=\"pass-user\" id=\"pass-user\" placeholder=\"Mot de passe\" autocomplete />";
$connected .= "<label for=\"pass-perdu-display\">Mot de passe perdu</label>";
$connected .= "<a href=\"#\" id=\"connected\" class=\"bt-connect\">Se connecter</a>";
$connected .= "</form>";

if($isConnected) {
    $connected = "<ul>";
    $connected .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./pctr_admin\">Admin</a></li>";
    $connected .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./src/exec/deconnexion_exec.php\">Déconnexion</a></li>";
    $connected .= "</ul>";
}

if(!empty($ind)) {
    if($ind == "desc") {
        include_once dirname(__FILE__) . '/src/pages/description.php';
        $css = $page_desc->displayCss();
        $js = $page_desc->displayJs();
        $contenu = $page_desc->getContenu();
    } else if($ind == "propos") {
        include_once dirname(__FILE__) . '/src/pages/a_propos.php';
        $css = $page_propos->displayCss();
        $js = $page_propos->displayJs();
        $contenu = $page_propos->getContenu();
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
    } else if($ind == "mmdp") {
        include_once dirname(__FILE__) . '/src/pages/modif_mdp.php';
        $css = $page_mmdp->displayCss();
        $js = $page_mmdp->displayJs();
        $contenu = $page_mmdp->getContenu();
    }
}

echo str_replace("[##CONTENU_CSS##]", !empty($css) ? "\n".$css : "", 
    str_replace("[##CONTENU_JS##]", !empty($js) ? "\n".$js : "",
    str_replace("[##CONTENU##]", $contenu, 
    str_replace("[##CONNECTED##]", $connected, 
    str_replace("[##CATEGORIES##]", $cats, 
    file_get_contents(dirname(__FILE__) . '/src/templates/menu_footer_header.html', true))))));
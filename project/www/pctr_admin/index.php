<?php

/* demarrer la session */
session_start();

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../src/fonctions/connexion_sgbd.php';
    include_once dirname(__FILE__) . '/src/fonctions/add_td_find.php';

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* mettre l'index a null */
    $ind=null;

    /* par defaut on recupere la page d'accueil */
    include_once dirname(__FILE__) . '/src/pages/acc.php';
    $css = $page_acc->displayCss();
    $js = $page_acc->displayJs();
    $contenu = $page_acc->getContenu();

    /* si on a un get ind, on le recupere */
    if(!empty($_GET) && array_key_exists("ind", $_GET)) {
        $ind=$_GET['ind'];
    }

    /* si l'index n'est pas vide on recupere la page a afficher */
    if(!empty($ind)) {
        switch ($ind) {
            case "desc":
                include_once dirname(__FILE__) . '/src/pages/produits.php';
                $css = $page_prod->displayCss();
                $js = $page_prod->displayJs();
                $contenu = $page_prod->getContenu();
                break;
            case "cat":
                include_once dirname(__FILE__) . '/src/pages/categories.php';
                $css = $page_cat->displayCss();
                $js = $page_cat->displayJs();
                $contenu = $page_cat->getContenu();
                break;
            case "comp":
                include_once dirname(__FILE__) . '/src/pages/competences.php';
                $css = $page_comp->displayCss();
                $js = $page_comp->displayJs();
                $contenu = $page_comp->getContenu();
                break;
            case "add_logo":
                include_once dirname(__FILE__) . '/src/pages/add_logo.php';
                $css = $page_add_logo->displayCss();
                $js = $page_add_logo->displayJs();
                $contenu = $page_add_logo->getContenu();
                break;
            case "add_cv":
                include_once dirname(__FILE__) . '/src/pages/add_cv.php';
                $css = $page_add_cv->displayCss();
                $js = $page_add_cv->displayJs();
                $contenu = $page_add_cv->getContenu();
                break;
            case "disp_cv":
                include_once dirname(__FILE__) . '/src/pages/display_cv.php';
                $css = $page_disp_cv->displayCss();
                $js = $page_disp_cv->displayJs();
                $contenu = $page_disp_cv->getContenu();
                break;
            case "comp_logo":
                include_once dirname(__FILE__) . '/src/pages/comp_logo.php';
                $css = $page_comp_logo->displayCss();
                $js = $page_comp_logo->displayJs();
                $contenu = $page_comp_logo->getContenu();
                break;
            case "lang":
                include_once dirname(__FILE__) . '/src/pages/language.php';
                $css = $page_langP->displayCss();
                $js = $page_langP->displayJs();
                $contenu = $page_langP->getContenu();
                break;
            case "framW":
                include_once dirname(__FILE__) . '/src/pages/framework.php';
                $css = $page_framW->displayCss();
                $js = $page_framW->displayJs();
                $contenu = $page_framW->getContenu();
                break;
            case "loisi":
                include_once dirname(__FILE__) . '/src/pages/loisir.php';
                $css = $page_loisir->displayCss();
                $js = $page_loisir->displayJs();
                $contenu = $page_loisir->getContenu();
                break;
            case "parc":
                include_once dirname(__FILE__) . '/src/pages/parcours.php';
                $css = $page_parc->displayCss();
                $js = $page_parc->displayJs();
                $contenu = $page_parc->getContenu();
                break;
            case "user":
                include_once dirname(__FILE__) . '/src/pages/user.php';
                $css = $page_user->displayCss();
                $js = $page_user->displayJs();
                $contenu = $page_user->getContenu();
                break;
            case "msg":
                include_once dirname(__FILE__) . '/src/pages/message.php';
                $css = $page_msg->displayCss();
                $js = $page_msg->displayJs();
                $contenu = $page_msg->getContenu();
                break;
        }
    }

    /* afficher la page */
    /* on place le contenu dans l'index */
    echo str_replace("[##CONTENU_CSS##]", !empty($css) ? "\n".$css : "", 
        str_replace("[##CONTENU_JS##]", !empty($js) ? "\n".$js : "",
        str_replace("[##CONTENU##]", $contenu, 
        file_get_contents(dirname(__FILE__) . '/src/templates/menu_footer_header.html', true))));

} else {
    header('Location: ./../../');
    exit();
}
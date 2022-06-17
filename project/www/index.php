<?php

/* definir une constante pour l'id utilisateur */
define("USER_ID", "1");

/*Connexion*/
include_once dirname(__FILE__) . '/src/fonctions/connexion_sgbd.php';

/* demarrer la session */
session_start();

/* desactiver la connexion par defaut */
$isConnected = false;

/* verifier qu'on est connecter */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
array_key_exists('email', $_SESSION)) {
    $isConnected = true;
}

/* mettre la liste des categorie a vide */
$cats = "";

/*Connexion*/
$sgbd = connexion_sgbd();

/* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
if(!empty($sgbd)) {
    /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
    try {
        /* recuperer la liste des categories */
        $res = $sgbd->prepare("SELECT * FROM categorie WHERE display_cat=1");
        $res->execute();
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $valueLine) {
            $cat_img = "";
            if(!empty($valueLine["avatar_cat"])) {
                $cat_img = '<img src="./data/thumb/'.$valueLine["avatar_cat"].'" alt="icon '.$valueLine["nom_cat"].'">';
            }
            
            $cats .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./?ind=cat&cat=".$valueLine["id_cat"]."\">".$cat_img.$valueLine["nom_cat"]."</a></li>";
        }
    } catch (Exception $e) {
        /* sauvegarde le message d'erreur dans le fichier "errors.log" */
        $error_log = new Error_Log();
        $error_log->addError($e);
        header("Status: 500");
    }
} else {
    header("Status: 500");
}

/* mettre l'index a null */
$ind=null;

/* par defaut on recupere la page d'accueil */
include_once dirname(__FILE__) . '/src/pages/acc.php';
$css = $page_acc->displayCss();
$js = $page_acc->displayJs();
$contenu = $page_acc->getContenu();
$num_error = $page_acc->getNum_error();
$msg_error = $page_acc->getMsg_error();

/* si on a un get ind, on le recupere */
if(!empty($_GET) && array_key_exists("ind", $_GET)) {
    $ind=$_GET['ind'];
}

/* recuperer l'affichage du menu de droite, pour se connecter */
$connected = '<input type="checkbox" name="pass-perdu-display" id="pass-perdu-display" />';
$connected .= '<form id="form-pass" action="#" method="post">';
$connected .= '<div id="display-name" class="display-login">';
$connected .= '<i class="bi bi-person"></i>';
$connected .= '<input type="text" name="name-user" id="name-user" placeholder="Login" />';
$connected .= '</div>';
$connected .= '<div id="display-pass" class="display-login">';
$connected .= '<i class="bi bi-lock"></i>';
$connected .= '<input type="password" name="pass-user" id="pass-user" class="formPass" placeholder="Mot de passe" autocomplete />';
$connected .= '<div class="input-group-text togglePassword"><i class="bi bi-eye-slash"></i></div>';
$connected .= '</div>';
$connected .= '<label for="pass-perdu-display" class="pass-perdu-display">Mot de passe perdu</label>';
$connected .= '<a href="#" id="connected" class="bt-connect">Se connecter</a>';
$connected .= '</form>';

/* si on est connecte, afficher le menu */
if($isConnected) {
    $connected = "<ul>";
    $connected .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./pctr_admin\"><img src=\"./pctr_admin/src/img/utilisateur.svg\" alt=\"icon messages\" />Admin</a></li>";
    $connected .= "<li class=\"lien\"><a class=\"click-lien\" href=\"./src/exec/deconnexion_exec.php\"><img src=\"./pctr_admin/src/img/deconnexion.svg\" alt=\"icon messages\" />Déconnexion</a></li>";
    $connected .= "</ul>";
}

/* si l'index n'est pas vide on recupere la page a afficher */
if(!empty($ind)) {
    switch ($ind) {
        case "desc":
            include_once dirname(__FILE__) . '/src/pages/description.php';
            $num_error = $page_desc->getNum_error();
            $msg_error = $page_desc->getMsg_error();
            $css = $page_desc->displayCss();
            $js = $page_desc->displayJs();
            $contenu = $page_desc->getContenu();
            break;
        case "propos":
            include_once dirname(__FILE__) . '/src/pages/a_propos.php';
            $num_error = $page_propos->getNum_error();
            $msg_error = $page_propos->getMsg_error();
            $css = $page_propos->displayCss();
            $js = $page_propos->displayJs();
            $contenu = $page_propos->getContenu();
            break;
        case "cat":
            include_once dirname(__FILE__) . '/src/pages/categories.php';
            $num_error = $page_cat->getNum_error();
            $msg_error = $page_cat->getMsg_error();
            $css = $page_cat->displayCss();
            $js = $page_cat->displayJs();
            $contenu = $page_cat->getContenu();
            break;
        case "comp":
            include_once dirname(__FILE__) . '/src/pages/competences.php';
            $num_error = $page_compet->getNum_error();
            $msg_error = $page_compet->getMsg_error();
            $css = $page_compet->displayCss();
            $js = $page_compet->displayJs();
            $contenu = $page_compet->getContenu();
            break;
        case "parc":
            include_once dirname(__FILE__) . '/src/pages/parcours.php';
            $num_error = $page_parc->getNum_error();
            $msg_error = $page_parc->getMsg_error();
            $css = $page_parc->displayCss();
            $js = $page_parc->displayJs();
            $contenu = $page_parc->getContenu();
            break;
        case "msg":
            include_once dirname(__FILE__) . '/src/pages/message.php';
            $num_error = $page_msg->getNum_error();
            $msg_error = $page_msg->getMsg_error();
            $css = $page_msg->displayCss();
            $js = $page_msg->displayJs();
            $contenu = $page_msg->getContenu();
            break;
        case "legales":
            include_once dirname(__FILE__) . '/src/pages/legals.php';
            $num_error = $page_legal->getNum_error();
            $msg_error = $page_legal->getMsg_error();
            $css = $page_legal->displayCss();
            $js = $page_legal->displayJs();
            $contenu = $page_legal->getContenu();
            break;
        case "mmdp":
            include_once dirname(__FILE__) . '/src/pages/modif_mdp.php';
            $num_error = $page_mmdp->getNum_error();
            $msg_error = $page_mmdp->getMsg_error();
            $css = $page_mmdp->displayCss();
            $js = $page_mmdp->displayJs();
            $contenu = $page_mmdp->getContenu();
            break;
    }
}

/* si on a pas d'erreur */
if($num_error == 0) {

    /* afficher la page */
    /* on place le contenu dans l'index */
    echo str_replace("[##CONTENU_CSS##]", !empty($css) ? "\n".$css : "", 
        str_replace("[##CONTENU_JS##]", !empty($js) ? "\n".$js : "",
        str_replace("[##CONTENU##]", $contenu, 
        str_replace("[##CONNECTED##]", $connected, 
        str_replace("[##CATEGORIES##]", $cats, 
        file_get_contents(dirname(__FILE__) . '/src/templates/menu_footer_header.html', true))))));

} else {
    /* si on n'a pas de message d'erreur personnalise */
    if(empty($msg_error)) {
        $status = "Status: ".$num_error;
        header("Status: 404");
    } else {
        echo $msg_error;
    }
}
<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "propos" && defined("USER_ID") && !empty(USER_ID)) {

        /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';
    
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    /* creation de la page d'affichage de la page */
    $page_propos = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/a_propos.html', true);

    /* creation des variables */
    $description = "";
    $informations = "";
    $cv_downlod = "#";

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE id_user=:id_user");
            $res->execute([":id_user" => USER_ID]);
            $dataForm = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataForm as $valueLine) {
                $description = str_replace("\n", "<br />", $valueLine['description_user']);
            }
            $resCat = $sgbd->prepare("SELECT * FROM loisir WHERE id_user=:id_user AND display_loisir=1");
            $resCat->execute([":id_user" => USER_ID]);
            if($resCat->rowCount() > 0) {
                $informations .= '<h2 class="text_grav">Informations complémentaires</h2>'."\n";
                $informations .= '<ul class="text_grav">'."\n";
                $dataCat = $resCat->fetchAll(PDO::FETCH_ASSOC);
                foreach ($dataCat as $valueLine) {
                    $informations .= '<li>'.str_replace("\n", "<br />", $valueLine['description_loisir']).'</li>';
                }

                $informations .= '</ul>'."\n";
            }

        } catch (Exception $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            //header("Status: 500");
            $page_acc->setNum_error(500);
        }
    } else {
        $page_acc->setNum_error(500);
    }

    /* affiche les valeurs sur la page html */
    $html = str_replace("[##descriptions##]", $description, $html);
    $html = str_replace("[##informations##]", $informations, $html);

    /* recupere le contenu a afficher */
    $page_propos->addCss("./src/css/a_propos.css");
    $page_propos->setContenu($html);

} else {
    header("Status: 403");
}
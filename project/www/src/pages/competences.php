<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "comp" && defined("USER_ID") && !empty(USER_ID)) {

    function addLogo(?string $name, ?string $src):?string {
        return '<figure class="section-logo"><h3 class="text_grav title-logo">'.$name.'</h3><img src="./data/thumb/'.$src.'" alt="logo '.$name.'" /></figure>';
    }

    function addComp(?string $title, ?string $desc):?string {
        return '<figure class="section-comp"><h3 class="text_grav title-logo">'.$title.'</h3><p class="text_grav">'.str_replace("\n", "<br />", $desc).'</p></figure>';
    }

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_compet = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true);

    /* creation des variables */
    $logos = "";
    $comp = "";

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("SELECT * FROM competences_logo INNER JOIN competences_logo_user ON competences_logo.id_competences_logo=competences_logo_user.id_competences_logo WHERE id_user=:id_user");
            $res->execute([":id_user" => USER_ID]);
            $dataForm = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataForm as $valueLine) {
                $logos .= addLogo($valueLine['nom_competences_logo'], $valueLine['src_competences_logo']);
            }
            $res = $sgbd->prepare("SELECT * FROM competences WHERE id_user=:id_user AND display_competences=1 ORDER BY id_competences DESC");
            $res->execute([":id_user" => USER_ID]);
            $dataExp = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataExp as $valueLine) {
                $comp .= addComp($valueLine['title_competence'], $valueLine['description_competences']);
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
    $html = str_replace("[##LOGOS##]", $logos, $html);
    $html = str_replace("[##COMP##]", $comp, $html);

    /* recupere le contenu a afficher */
    $page_compet->addCss("./src/css/style_competences.css");
    $page_compet->setContenu($html);

} else {
    header("Status: 403");
}
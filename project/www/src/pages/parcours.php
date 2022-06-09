<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "parc" && defined("USER_ID") && !empty(USER_ID)) {

    function parcours(?array $array):?string {
        $title_parcours = $array['title_parcours'];
        $entreprise_parcours = $array['entreprise_parcours'];
        $date_debut_parcours = date('m/Y', strtotime($array['date_debut_parcours']));
        $date_fin_parcours = date('m/Y', strtotime($array['date_fin_parcours']));
        $lieu_parcours = $array['lieu_parcours'];
        $description_parcours = $array['description_parcours'];
        $in_progress_parcours = ($array['in_progress_parcours'] == "1");
        $value = '<figure class="date-start">&rarr; '.$date_debut_parcours.'</figure>';
        if($in_progress_parcours) {
            $value = '<figure class="date-start two-colum">&rarr; Depuis le '.$date_debut_parcours.'</figure>';
        } else {
            $value .= '<figure class="date-end">'.$date_fin_parcours.'</figure>';
        }
        $value .= '<figure class="title-parc">'.$title_parcours.' - '.$entreprise_parcours.' - '.$lieu_parcours.'</figure>';
        $value .= '<figure class="desc">'.str_replace("\n", "<br />", $description_parcours).'</figure>';
        return $value;
    }

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    $page_parc = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/parcours.html', true);
    $formation = "";
    $experience = "";
    $cv_downlod = "#";

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        $res = $sgbd->prepare("SELECT * FROM parcours INNER JOIN formations ON parcours.id_parcours=formations.id_parcours WHERE id_user=:id_user AND display_parcours=1 ORDER BY date_debut_parcours DESC");
        $res->execute([":id_user" => USER_ID]);
        $dataForm = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataForm as $valueLine) {
            $formation .= parcours($valueLine);
        }
        $res = $sgbd->prepare("SELECT * FROM parcours INNER JOIN experiences ON parcours.id_parcours=experiences.id_parcours WHERE id_user=:id_user AND display_parcours=1 ORDER BY date_debut_parcours DESC");
        $res->execute([":id_user" => USER_ID]);
        $dataExp = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataExp as $valueLine) {
            $experience .= parcours($valueLine);
        }
        $res = $sgbd->prepare("SELECT * FROM cv WHERE id_user=:id_user AND display_cv=1 ORDER BY id_cv DESC LIMIT 1");
        $res->execute([":id_user" => USER_ID]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $cv_downlod = "./data/file/".$data['src_cv'];
        }
    }

    $html = str_replace("[##formation##]", $formation, $html);
    $html = str_replace("[##experience##]", $experience, $html);
    $html = str_replace("[##cv_download##]", $cv_downlod, $html);

    $page_parc->addCss("./src/css/style_parcours.css");
    $page_parc->setContenu($html);

}
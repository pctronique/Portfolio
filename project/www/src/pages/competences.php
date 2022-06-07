<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "comp" && defined("USER_ID") && !empty(USER_ID)) {

    function addLogo(?string $name, ?string $src):?string {
        return '<figure class="section-logo"><h3 class="text_grav">'.$name.'</h3><img src="./data/img/'.$src.'" alt="logo '.$name.'" /></figure>';
    }

    function addComp(?string $title, ?string $desc):?string {
        return '<figure class="section-comp"><h3 class="text_grav">'.$title.'</h3><p class="text_grav">'.str_replace("\n", "<br />", $desc).'</p></figure>';
    }

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_compet = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/competences.html', true);
    $logos = "";
    $comp = "";

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        $res = $sgbd->prepare("SELECT * FROM competences_logo INNER JOIN competences_logo_user ON competences_logo.id_competences_logo=competences_logo_user.id_competences_logo WHERE id_user=:id_user");
        $res->execute([":id_user" => USER_ID]);
        $dataForm = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataForm as $valueLine) {
            $logos .= addLogo($valueLine['nom_competences_logo'], $valueLine['src_competences_logo']);
        }
        $res = $sgbd->prepare("SELECT * FROM competences WHERE id_user=:id_user ORDER BY id_competences DESC");
        $res->execute([":id_user" => USER_ID]);
        $dataExp = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataExp as $valueLine) {
            $comp .= addComp($valueLine['title_competence'], $valueLine['description_competences']);
        }
    }

    $html = str_replace("[##LOGOS##]", $logos, $html);
    $html = str_replace("[##COMP##]", $comp, $html);

    $page_compet->addCss("./src/css/style_competences.css");
    $page_compet->setContenu($html);

}
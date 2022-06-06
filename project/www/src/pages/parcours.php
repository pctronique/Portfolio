<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "parc" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    $page_parc = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/parcours.html', true);
    $formation = "";
    $experience = "";

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
            $res = $sgbd->prepare("SELECT * FROM parcours INNER JOIN formations ON parcours.id_parcours=formations.id_parcours WHERE id_user=:id_user");
            $res->execute([":id_user" => USER_ID]);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            var_dump($data);
            echo count($data)."<br />";
            for($i = 0; $i < count($data); $i++) {
                echo $data[$i]['title_parcours']."<br />";
                $formation .= $data[$i]['title_parcours']."<br />";
            }
            $res = $sgbd->prepare("SELECT * FROM parcours INNER JOIN experiences ON parcours.id_parcours=experiences.id_parcours WHERE id_user=:id_user");
            $res->execute([":id_user" => USER_ID]);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $experience .= $valueLine['title_parcours']."<br />";
            }
    }

    $html = str_replace("[##formation##]", $formation, $html);
    $html = str_replace("[##experience##]", $experience, $html);

    $page_parc->addCss("./src/css/style_parcours.css");
    $page_parc->setContenu($html);

}
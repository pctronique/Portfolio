<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "cat" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_cat = new Contenu_Page();

    $name_cat = "";

    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    $id_cat = 0;
    if(!empty($_GET) && array_key_exists("cat", $_GET)) {
        $id_cat = $_GET['cat'];
    }

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
        $res = $sgbd->prepare("SELECT * FROM categorie WHERE id_cat=:id_cat");
        $res->execute([":id_cat" => $id_cat]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $name_cat = $data["nom_cat"];
        }
    }

    $html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

    $html = str_replace("[##categorie##]", $name_cat, $html);

    $page_cat->setContenu($html);

}
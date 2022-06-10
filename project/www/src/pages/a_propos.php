<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "propos" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';
    
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    $page_propos = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/a_propos.html', true);
    $description = "";
    $informations = "";
    $cv_downlod = "#";

    $sgbd = connexion_sgbd();
    if(!empty($sgbd)) {
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
    } else {
        $page_acc->setNum_error(501);
    }

    $html = str_replace("[##descriptions##]", $description, $html);
    $html = str_replace("[##informations##]", $informations, $html);

    $page_propos->addCss("./src/css/a_propos.css");
    $page_propos->setContenu($html);

} else {
    header("Status: 403");
}
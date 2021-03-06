<?php

/* verifier qu'on a le droit de venir sur la page */
if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "desc" && defined("USER_ID") && !empty(USER_ID)) {

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_desc = new Contenu_Page();

    /* creation des variables */
    $name_img = "";
    $src_img = "";
    $name_desc = "";
    $lang_framw = "";
    $description = "";
    $logos_src = "";

    $id_desc = 0;
    if(!empty($_GET) && array_key_exists("desc", $_GET)) {
        $id_desc = $_GET['desc'];
    }

    /*Connexion*/
    $sgbd = connexion_sgbd();

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("SELECT * FROM produits INNER JOIN cat_produit ON cat_produit.id_produit=produits.id_produit INNER JOIN categorie ON cat_produit.id_cat=categorie.id_cat WHERE produits.id_produit=:id_produit AND display_produit=1 AND categorie.display_cat=1");
            $res->execute([":id_produit" => $id_desc]);
            if($res->rowCount() > 0) {
                $data = $res->fetch(PDO::FETCH_ASSOC);
                $name_desc = $data["nom_produit"];
                if(!empty($data["src_git_produit"])) {
                    $logos_src .= '<a target="_blank" href="'.$data["src_git_produit"].'"><img src="./src/img/icons8-git-50.svg" alt="icon logo git" title="le lien vers le git du projet"></a>';
                }
                if(!empty($data["src_produit"])) {
                    $logos_src .= '<a target="_blank" href="'.$data["src_produit"].'"><img src="./src/img/icons8-project-64.svg" alt="icon logo projet" title="le lien vers le projet"></a>';
                }

                $resPhoto = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id_produit LIMIT 1");
                $resPhoto->execute([":id_produit" => $id_desc]);
                if($resPhoto->rowCount() > 0) {
                    $dataPhoto = $resPhoto->fetch(PDO::FETCH_ASSOC);
                    $src_img = "./data/thumb/".$dataPhoto['src_photo'];
                }
                $name_img = "image du project ".$data['nom_produit'];
                $description = str_replace("\n", "<br />", $data['description_produit']);

                $resCat = $sgbd->prepare("SELECT * FROM categorie INNER JOIN cat_produit ON categorie.id_cat=cat_produit.id_cat INNER JOIN produits ON produits.id_produit=cat_produit.id_produit WHERE produits.id_produit=:id_produit");
                $resCat->execute([":id_produit" => $id_desc]);
                if($resCat->rowCount() > 0) {
                    $lang_framw .= '<figure class="drop_contenu">'."\n";
                    $lang_framw .= '<figure id="Categories" class="drag_contenu" draggable="true">'."\n";
                    $lang_framw .= '<h2>Catégories</h2>'."\n";
                    $lang_framw .= '<ul>'."\n";
                    $dataCat = $resCat->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dataCat as $valueLine) {
                        $lang_framw .= '<li>'.$valueLine['nom_cat'].'</li>';
                    }

                    $lang_framw .= '</ul>'."\n";
                    $lang_framw .= '</figure>'."\n";
                    $lang_framw .= '</figure>'."\n";
                }

                $resCat = $sgbd->prepare("SELECT * FROM language INNER JOIN language_produit ON language.id_language=language_produit.id_language INNER JOIN produits ON produits.id_produit=language_produit.id_produit WHERE produits.id_produit=:id_produit");
                $resCat->execute([":id_produit" => $id_desc]);
                if($resCat->rowCount() > 0) {
                    $lang_framw .= '<figure class="drop_contenu">'."\n";
                    $lang_framw .= '<figure id="Languages" class="drag_contenu" draggable="true">'."\n";
                    $lang_framw .= '<h2>Languages</h2>'."\n";
                    $lang_framw .= '<ul>'."\n";
                    $dataCat = $resCat->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dataCat as $valueLine) {
                        $lang_framw .= '<li>'.$valueLine['nom_language'].'</li>';
                    }
                    $lang_framw .= '</ul>'."\n";
                    $lang_framw .= '</figure>'."\n";
                    $lang_framw .= '</figure>'."\n";
                }

                $resCat = $sgbd->prepare("SELECT * FROM framework INNER JOIN framework_produit ON framework.id_framework=framework_produit.id_framework INNER JOIN produits ON produits.id_produit=framework_produit.id_produit WHERE produits.id_produit=:id_produit");
                $resCat->execute([":id_produit" => $id_desc]);
                if($resCat->rowCount() > 0) {
                    $lang_framw .= '<figure class="drop_contenu">'."\n";
                    $lang_framw .= '<figure id="FrameWorks" class="drag_contenu" draggable="true">'."\n";
                    $lang_framw .= '<h2>FrameWorks</h2>'."\n";
                    $lang_framw .= '<ul>'."\n";
                    $dataCat = $resCat->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dataCat as $valueLine) {
                        $lang_framw .= '<li>'.$valueLine['nom_framework'].'</li>';
                    }

                    $lang_framw .= '</ul>'."\n";
                    $lang_framw .= '</figure>'."\n";
                    $lang_framw .= '</figure>'."\n";
                }
            } else {
                $id_desc = 0;
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
    
    if($id_desc == 0 || $page_desc->getNum_error() != 0) {
        $page_desc->setNum_error(404);
    }

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/description.html', true);

    /* affiche les valeurs sur la page html */
    $html = str_replace("[##produit##]", $name_desc, $html);
    $html = str_replace("[##logos_lien##]", $logos_src, $html);
    $html = str_replace("[##SRC_IMG##]", $src_img, $html);
    $html = str_replace("[##NAME_IMG##]", $name_img, $html);
    $html = str_replace("[##LANG_FRAMW##]", $lang_framw, $html);
    $html = str_replace("[##DESC##]", $description, $html);

    /* recupere le contenu a afficher */
    $page_desc->addCss("./src/css/style_description.css");
    $page_desc->addJs("./src/js/drag_drop.js");
    $page_desc->setContenu($html);


} else {
    header("Status: 403");
}
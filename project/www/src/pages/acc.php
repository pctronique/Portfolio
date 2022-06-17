<?php

/* verifier qu'on a le droit de venir sur la page */
if(defined("USER_ID") && !empty(USER_ID)) {
    
    function add_produit(?string $id, ?string $name, ?string $src, bool $first = false) {
        if($first) {
            $contenu = '<figure id="img_factice" class="produit carrousel">';
        } else {
            $contenu = '<figure class="produit carrousel">';
        }
        $contenu .= '<figure class="title" id="title_'.$id.'">';
        $contenu .= '<h2>'.$name.'</h2>';
        $contenu .= '</figure>';
        $contenu .= '<figure class="image" id="image_'.$id.'">';
        $contenu .= '<a class="image_a" id="img_a_'.$id.'" href="./?ind=desc&desc='.$id.'">';
        $contenu .= '<img class="img" id="img_'.$id.'" alt="produit '.$name.'" src="./data/thumb/'.$src.'">';
        $contenu .= '</a>';
        $contenu .= '</figure>';
        $contenu .= '</figure>';
        return $contenu;
    }

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_acc = new Contenu_Page();

    /* creation des variables */
    $div_produit = "";

    
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            $res = $sgbd->prepare("SELECT * FROM produits INNER JOIN cat_produit ON cat_produit.id_produit=produits.id_produit ".
                                    "INNER JOIN categorie ON cat_produit.id_cat =categorie.id_cat ".
                                    "WHERE produits.id_user=:id_user AND display_produit=1 AND display_cat=1 ".
                                    "ORDER BY RAND() LIMIT 5");
            $res->execute([":id_user" => USER_ID]);
                    
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            foreach ($data as $valueLine) {
                $resPhoto = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id_produit LIMIT 1");
                $resPhoto->execute([":id_produit" => $valueLine['id_produit']]);
                if($resPhoto->rowCount() > 0) {
                    $dataPhoto = $resPhoto->fetch(PDO::FETCH_ASSOC);
                    $div_produit .= add_produit($valueLine['id_produit'], $valueLine['nom_produit'], $dataPhoto['src_photo'], $i== 0)."\n";
                } else {
                    $div_produit .= add_produit($valueLine['id_produit'], $valueLine['nom_produit'], "", $i==0)."\n";
                }
                $i++;
            }
        
        } catch (Exception $e) {
            /* sauvegarde le message d'erreur dans le fichier "errors.log" */
            $error_log = new Error_Log();
            $error_log->addError($e);
            //header("Status: 500");
            $page_acc->setNum_error(500);
        }
    } else {
        //header("Status: 500");
        $page_acc->setNum_error(500);
    }

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true);

    /* affiche les valeurs sur la page html */
    $html = str_replace("[##div_produits##]", $div_produit, $html);

    /* recupere le contenu a afficher */
    $page_acc->addCss("./src/css/style_acc.css");
    $page_acc->addCss("./src/css/carrousel.css");
    $page_acc->addJs("./src/js/carrousel.js");
    $page_acc->addJs("./src/js/acc.js");
    $page_acc->setContenu($html);

} else {
    header("Status: 403");
}

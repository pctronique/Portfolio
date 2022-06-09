<?php

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
        $contenu .= '<img class="img" id="img_'.$id.'" alt="produit '.$name.'" src="./data/img/'.$src.'">';
        $contenu .= '</a>';
        $contenu .= '</figure>';
        $contenu .= '</figure>';
        return $contenu;
    }

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_acc = new Contenu_Page();

    $div_produit = "";

    
    /*Connexion*/
    include_once dirname(__FILE__) . '/../fonctions/connexion_sgbd.php';

    $res = $sgbd->prepare("SELECT * FROM produits INNER JOIN cat_produit ON cat_produit.id_produit=produits.id_produit WHERE id_user=:id_user LIMIT 5");
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

    $html = file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true);

    
    $html = str_replace("[##div_produits##]", $div_produit, $html);

    $page_acc->addCss("./src/css/style_acc.css");
    $page_acc->addCss("./src/css/carrousel.css");
    $page_acc->addJs("./src/js/carrousel.js");
    $page_acc->addJs("./src/js/acc.js");
    $page_acc->setContenu($html);

}

<?php

include_once dirname(__FILE__) . '/../fonctions/addBox3D.php';

function addDesc(?string $id, ?string $name, ?string $src):?string {
    $desc = '<figure class="desc">'."\n";
    $desc .= '<a href="./?ind=desc&desc='.$id.'">'."\n";
    $desc .= '<h4 class="text_grav">'.$name.'</h4>'."\n";
    $desc .= '</a>'."\n";
    $desc .= '<a href="./?ind=desc&desc='.$id.'">'."\n";

    if(!empty($src)) {
        $desc .= '<img alt="image de '.$name.'" src="./data/img/'.$src.'" />'."\n";
    }
    $desc .= '</a>'."\n";
    $desc .= '</figure>'."\n";
    return addBox3D($desc);
}

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "cat" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_cat = new Contenu_Page();

    $name_cat = "";

    $contenu_cat = "";

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

            $res = $sgbd->prepare("SELECT * FROM produits INNER JOIN cat_produit ON cat_produit.id_produit=produits.id_produit WHERE id_cat=:id_cat AND display_produit=1");
            $res->execute([":id_cat" => $id_cat]);
            
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $resPhoto = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id_produit LIMIT 1");
                $resPhoto->execute([":id_produit" => $valueLine['id_produit']]);
                if($resPhoto->rowCount() > 0) {
                    $dataPhoto = $resPhoto->fetch(PDO::FETCH_ASSOC);
                    $contenu_cat .= addDesc($valueLine['id_produit'], $valueLine['nom_produit'], $dataPhoto['src_photo'])."\n";
                } else {
                    $contenu_cat .= addDesc($valueLine['id_produit'], $valueLine['nom_produit'], "")."\n";
                }
            }
        }
    }

    $html = file_get_contents(dirname(__FILE__) . '/../templates/categories.html', true);

    $html = str_replace("[##categorie##]", $name_cat, $html);
    $html = str_replace("[##CAT_CONTENU##]", $contenu_cat, $html);

    $page_cat->addCss("./src/css/style_categorie.css");
    $page_cat->setContenu($html);

}
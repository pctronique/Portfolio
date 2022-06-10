<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, bool $checked = false) {
        $checkbox = "<input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<label class=\"form-check-label text-light\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label>[##n##]"."\n";
        return $checkbox;
    }

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_prod = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/produits.html', true);

    $id = 0;
    $img = "./src/img/icons8-ajouter-une-image-90.png";
    $display = "checked";
    $name = "";
    $desc = "";
    $src = "";
    $cat = "";
    $langp = "";
    $framW = "";
    $find = "";

    if(!empty($_GET) && array_key_exists("id", $_GET)) {
        $res = $sgbd->prepare("SELECT * FROM produits WHERE id_produit=:id");
        $res->execute([
            ":id" => $_GET['id']
        ]);
        if($res->rowCount() > 0) {
            $data = $res->fetch(PDO::FETCH_ASSOC);
            $id = $_GET['id'];
            $name = $data['nom_produit'];
            $display = $data['display_produit'] == "1" ? "checked" : "";
            $desc = $data['description_produit'];
            $src = $data['src_produit'];
            /*if(!empty($data["avatar_user"])) {
                $img = "./../data/img/".$data["avatar_user"];
            }*/
            $resPhoto = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id");
            $resPhoto->execute([
                ":id" => $_GET['id']
            ]);
            $dataPhoto = $resPhoto->fetchAll(PDO::FETCH_ASSOC);
            foreach ($dataPhoto as $valueLine) {
                $img = "./../data/img/".$valueLine["src_photo"];
            }
        }
    }

    $tab_cat = [];
    $tab_langP = [];
    $tab_framW = [];

    if($id != 0) {
        $res = $sgbd->prepare("SELECT * FROM cat_produit WHERE id_produit=:id_produit");
        $res->execute([":id_produit" => $id]);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $valueLine) {
            array_push($tab_cat, $valueLine["id_cat"]);
        }

        $res = $sgbd->prepare("SELECT * FROM language_produit WHERE id_produit=:id_produit");
        $res->execute([":id_produit" => $id]);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $valueLine) {
            array_push($tab_langP, $valueLine["id_language"]);
        }

        $res = $sgbd->prepare("SELECT * FROM framework_produit WHERE id_produit=:id_produit");
        $res->execute([":id_produit" => $id]);
        $data = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $valueLine) {
            array_push($tab_framW, $valueLine["id_framework"]);
        }
    }

    $res = $sgbd->prepare("SELECT * FROM categorie");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $the_checked = false;
        if (in_array($valueLine["id_cat"], $tab_cat)) {
            $the_checked = true;
        }
        $cat .= addCheckbox("cat", $valueLine["id_cat"], $valueLine["nom_cat"], $valueLine["id_cat"], $the_checked);
    }

    $res = $sgbd->prepare("SELECT * FROM language");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $the_checked = false;
        if (in_array($valueLine["id_language"], $tab_langP)) {
            $the_checked = true;
        }
        $langp .= addCheckbox("langP", $valueLine["id_language"], $valueLine["nom_language"], $valueLine["id_language"], $the_checked);
    }

    $res = $sgbd->prepare("SELECT * FROM framework");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $the_checked = false;
        if (in_array($valueLine["id_framework"], $tab_framW)) {
            $the_checked = true;
        }
        $framW .= addCheckbox("framW", $valueLine["id_framework"], $valueLine["nom_framework"], $valueLine["id_framework"], $the_checked);
    }

    $res = $sgbd->prepare("SELECT * FROM produits");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("cat", $valueLine["id_produit"], $valueLine["nom_produit"], $valueLine['display_produit'] == "1", true);
    }

    $html = str_replace("[##IMG_PROD##]", $img, $html);
    $html = str_replace("[##ID_PROD##]", $id, $html);
    $html = str_replace("[##NAME_PROD##]", $name, $html);
    $html = str_replace("[##DESC_PROD##]", $desc, $html);
    $html = str_replace("[##CAT_PROD##]", $cat, $html);
    $html = str_replace("[##SRC_PROD##]", $src, $html);
    $html = str_replace("[##LANGP_PROD##]", $langp, $html);
    $html = str_replace("[##FRAMW_PROD##]", $framW, $html);
    $html = str_replace("[##FIND_PROD##]", $find, $html);
    $html = str_replace("[##DISPLAY_PROD##]", $display, $html);
    $html = str_replace("[##n##]", "<br />", $html);
    $page_prod->setContenu($html);
    $page_prod->addCss("./src/css/addimg.css");
    $page_prod->addJs("./src/js/addimg.js");
    $page_prod->addJs("./src/js/produits.js");
} else {
    header('Location: ./../../../');
    exit();
}
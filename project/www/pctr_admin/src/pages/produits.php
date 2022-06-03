<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    function add(?string $name, ?string $title, bool $checked = false) {
        $checkbox = "<input class=\"form-check-input\" type=\"checkbox\" value=\"true\" name=\"".$name."\" id=\"flexCheckDefault\"";
        $checkbox .= $checked ? "" : "checked"." >"."\n";
        $checkbox .= "<label class=\"form-check-label text-light\" for=\"flexCheckDefault\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label>"."\n";
        return $checkbox;
    }

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_prod = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/produits.html', true);

    $id = 0;
    $name = "";
    $desc = "";
    $src = "";
    $cat = "";
    $langp = "";
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
            $desc = $data['description_produit'];
            $src = $data['src_produit'];
            /*$cat = $data['id_user'];
            $langp = $data['date_produit'];*/
        }
    }

    $res = $sgbd->prepare("SELECT * FROM produits");
    $res->execute();
    $data = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $valueLine) {
        $find .= add_td_find("cat", $data["id_produit"], $data["nom_produit"]);
    }

    $html = str_replace("[##ID_PROD##]", $id, $html);
    $html = str_replace("[##NAME_PROD##]", $name, $html);
    $html = str_replace("[##DESC_PROD##]", $desc, $html);
    $html = str_replace("[##CAT_PROD##]", $cat, $html);
    $html = str_replace("[##SRC_PROD##]", $src, $html);
    $html = str_replace("[##LANGP_PROD##]", $langp, $html);
    $html = str_replace("[##FIND_PROD##]", $find, $html);
    $page_prod->setContenu($html);
    $page_prod->addJs("./src/js/produits.js");
} else {
    header('Location: ./../../../');
    exit();
}
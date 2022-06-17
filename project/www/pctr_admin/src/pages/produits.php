<?php

/* verifier qu'on a le droit de venir sur la page */
if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

        /* pour ajouter les checkbox dans la page */
    function addCheckbox(?string $type, ?string $name, ?string $title, ?string $id, bool $checked = false) {
        $checkbox = "<li class=\"row-prod list-group-item\"><input class=\"form-check-input\" type=\"checkbox\" value=\"".$id."\" name=\"".$type."_".$name."\" id=\"flexCheck".$type.$name."\"";
        $checkbox .= $checked ? "checked" : "";
        $checkbox .= " >"."\n";
        $checkbox .= "<label class=\"form-check-label text-dark\" for=\"flexCheck".$type.$name."\">"."\n";
        $checkbox .= $title."\n";
        $checkbox .= "</label></li>"."\n";
        return $checkbox;
    }

    /* inclure la classe d'affichage de la page */
    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    /* creation de la page d'affichage de la page */
    $page_prod = new Contenu_Page();

    /* recuperer la page a afficher */
    $html = file_get_contents(dirname(__FILE__) . '/../templates/produits.html', true);

    /* creation des variables */
    $id = 0;
    $img = "./src/img/Add_Image_icon-icons_54218.svg";
    $display = "checked";
    $name = "";
    $desc = "";
    $src = "";
    $srcGit = "";
    $cat = "";
    $langp = "";
    $framW = "";
    $find = "";

    /* vérifier qu'on n'a pas d'erreur de connexion a la base de donnee */
    if(!empty($sgbd)) {
        /* se proteger des erreurs de requete sql (pour ne pas afficher l'erreur a l'ecran) */
        try {
            /* si on a un id recuperer le contnu a afficher */
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
                    $srcGit = $data['src_git_produit'];
                    $resPhoto = $sgbd->prepare("SELECT * FROM photos WHERE id_produit=:id");
                    $resPhoto->execute([
                        ":id" => $_GET['id']
                    ]);
                    $dataPhoto = $resPhoto->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dataPhoto as $valueLine) {
                        $img = "./../data/thumb/".$valueLine["src_photo"];
                    }
                }
            }

            /* tableaux des liens vide */
            $tab_cat = [];
            $tab_langP = [];
            $tab_framW = [];

            /* si l'id est valide */
            if($id != 0) {
                /* remplir les tableaux de lien entre les tables */
                /* les categories actives */
                $res = $sgbd->prepare("SELECT * FROM cat_produit WHERE id_produit=:id_produit");
                $res->execute([":id_produit" => $id]);
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valueLine) {
                    array_push($tab_cat, $valueLine["id_cat"]);
                }

                /* les languages actives */
                $res = $sgbd->prepare("SELECT * FROM language_produit WHERE id_produit=:id_produit");
                $res->execute([":id_produit" => $id]);
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valueLine) {
                    array_push($tab_langP, $valueLine["id_language"]);
                }

                /* les frameworks actives */
                $res = $sgbd->prepare("SELECT * FROM framework_produit WHERE id_produit=:id_produit");
                $res->execute([":id_produit" => $id]);
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $valueLine) {
                    array_push($tab_framW, $valueLine["id_framework"]);
                }
            }

            /* recupere les categories */
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

            /* recupere les languages */
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

            /* recupere les frameworks */
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

            /* pour remplir le tableau de la page */
            $res = $sgbd->prepare("SELECT *, id_produit AS id_produit_main FROM produits");
            $res->execute();

            /* si on a un find dans le lien de la page, on effectu la recherche */
            if(!empty($_GET) && array_key_exists("find", $_GET)) {
                $res = $sgbd->prepare("SELECT *, SUM(produits.id_produit), produits.id_produit AS id_produit_main FROM produits ".
                    "LEFT JOIN cat_produit ON cat_produit.id_produit=produits.id_produit ".
                    "LEFT JOIN categorie ON cat_produit.id_cat=categorie.id_cat ".
                    "LEFT JOIN language_produit ON produits.id_produit=language_produit.id_produit ".
                    "LEFT JOIN language ON language.id_language=language_produit.id_language ".
                    "LEFT JOIN framework_produit ON cat_produit.id_produit=framework_produit.id_produit ".
                    "LEFT JOIN framework ON framework.id_framework=framework.id_framework ".
                    "WHERE (nom_cat LIKE :find OR description_cat LIKE :find OR ".
                    "nom_language LIKE :find OR nom_framework LIKE :find OR ".
                    "nom_produit LIKE :find OR description_produit LIKE :find ".
                    ") GROUP BY produits.id_produit");
                $res->execute([":find" => "%".$_GET["find"]."%"]);
            }

            /* creation des lignes d'affichage du tableau */
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $valueLine) {
                $find .= add_td_find("cat", $valueLine["id_produit_main"], $valueLine["nom_produit"], $valueLine['display_produit'] == "1", true);
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

    /* affiche les valeurs sur la page html */
    $html = str_replace("[##IMG_PROD##]", $img, $html);
    $html = str_replace("[##ID_PROD##]", $id, $html);
    $html = str_replace("[##NAME_PROD##]", $name, $html);
    $html = str_replace("[##DESC_PROD##]", $desc, $html);
    $html = str_replace("[##CAT_PROD##]", $cat, $html);
    $html = str_replace("[##SRC_PROD##]", $src, $html);
    $html = str_replace("[##SRC_GIT_PROD##]", $srcGit, $html);
    $html = str_replace("[##LANGP_PROD##]", $langp, $html);
    $html = str_replace("[##FRAMW_PROD##]", $framW, $html);
    $html = str_replace("[##FIND_PROD##]", $find, $html);
    $html = str_replace("[##DISPLAY_PROD##]", $display, $html);
    $html = str_replace("[##n##]", "<br />", $html);

    /* recupere le contenu */
    $page_prod->setContenu($html);
    $page_prod->addCss("./src/css/addimg.css");
    $page_prod->addCss("./src/css/style_produits.css");
    $page_prod->addJs("./src/js/addimg.js");
    $page_prod->addJs("./src/js/produits.js");
} else {
    header("Status: 403");
}
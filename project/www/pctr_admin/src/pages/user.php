<?php

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

    $page_user = new Contenu_Page();

    $html = file_get_contents(dirname(__FILE__) . '/../templates/user.html', true);

    $img = "./src/img/Add_Image_icon-icons_54218.svg";
    $name = "";
    $first_name = "";
    $login = "";
    $description = "";
    $email = "";

    $res = $sgbd->prepare("SELECT * FROM utilisateur WHERE id_user=:id");
    $res->execute([
        ":id" => $_SESSION['id_user']
    ]);
    if($res->rowCount() > 0) {
        $data = $res->fetch(PDO::FETCH_ASSOC);
        $name = $data["nom_user"];
        $first_name = $data["prenom_user"];
        $login = $data["login_user"];
        $email = $data["email_user"];
        $description = $data["description_user"];
        if(!empty($data["avatar_user"])) {
            $img = "./../data/thumb/".$data["avatar_user"];
        }
    }

    $html = str_replace("[##IMG_USER##]", $img, $html);
    $html = str_replace("[##NAME_USER##]", $name, $html);
    $html = str_replace("[##FIRST_NAME_USER##]", $first_name, $html);
    $html = str_replace("[##LOGIN_USER##]", $login, $html);
    $html = str_replace("[##EMAIL_USER##]", $email, $html);
    $html = str_replace("[##DESC_USER##]", $description, $html);

    $page_user->setContenu($html);
    $page_user->addCss("./src/css/addimg.css");
    $page_user->addCss("./src/css/style_add_logo.css");
    $page_user->addJs("./src/js/addimg.js");
    $page_user->addJs("./src/js/user.js");

} else {
    header("Status: 403");
}
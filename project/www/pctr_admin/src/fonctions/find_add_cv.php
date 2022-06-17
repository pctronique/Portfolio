<?php
/**
 * Pour supprimer les fichiers du serveur. A supprimer, pas utilise.
 */

if (!empty($_SESSION) && array_key_exists('id_user', $_SESSION) && 
    array_key_exists('id_admin', $_SESSION) && array_key_exists('nom', $_SESSION) &&   
    array_key_exists('prenom', $_SESSION) && array_key_exists('login', $_SESSION) && 
    array_key_exists('email', $_SESSION)) {

    // verifier qu'on n'a pas deja creer la fonction
    if (!function_exists('find_add_cv')) {

        /*Connexion*/
        include_once dirname(__FILE__) . '/../../../src/fonctions/connexion_sgbd.php';

        function find_add_cv($post = null) {
            $sgbd = connexion_sgbd();
            if(!empty($sgbd)) {

                /*Create_tab*/
                include_once dirname(__FILE__) . '/add_td_find.php';

                $find = [];

                $res = $sgbd->prepare("SELECT * FROM cv");

                if(!empty($_POST) && array_key_exists("find", $_POST)) {
                    $res = $sgbd->prepare("SELECT * FROM cv WHERE (title_cv LIKE :find OR nom_cv LIKE :find OR src_cv LIKE :find)");
                }
                
                $res->execute();
                $data = $res->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($data as $valueLine) {
                    $array = add_td_find_line_js("cv", $valueLine["id_cv"], $valueLine["title_cv"], $valueLine['display_cv'] == "1", true);
                    array_push($find, $array);
                }
                
                return json_encode($find);
            }
        }
    }
} else {
    header("Status: 403");
}
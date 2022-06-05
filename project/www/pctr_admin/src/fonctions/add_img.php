<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_img')) {

    // fonction pour faire la connexion a la base de donnes
    function add_img(?string $file_tmp, ?string $name) {
        return move_uploaded_file($file_tmp, dirname(__FILE__) . '/../../../data/img/'.$name);
    }
}
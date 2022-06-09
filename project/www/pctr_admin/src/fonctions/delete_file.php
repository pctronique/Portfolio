<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('delete_file')) {

    // fonction pour faire la connexion a la base de donnes
    function delete_file(?string $name): bool {
        if(empty($name)) {
            return false;
        }
        $file = dirname(__FILE__) . '/../../../data/file/'.$name;
        if(file_exists($file)) {
            unlink($file);
        }
        $file = dirname(__FILE__) . '/../../../data/img/'.$name;
        if(file_exists($file)) {
            unlink($file);
        }
        return true;
    }
}
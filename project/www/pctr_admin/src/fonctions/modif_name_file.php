<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('modif_name_file')) {

    // fonction pour faire la connexion a la base de donnes
    function modif_name_file(?string $name): ?string {
        if(empty($name)) {
            return $name;
        }
        $explode = explode(".", $name);
        $ext = $explode[count($explode)-1];
        return $explode[0]."_".uniqid().".".$ext;
    }
}

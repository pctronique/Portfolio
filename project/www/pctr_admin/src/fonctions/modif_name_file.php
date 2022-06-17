<?php
/**
 * Pour modifier le nom d'un fichier.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('modif_name_file')) {

    // fonction pour faire la connexion a la base de donnes
    function modif_name_file(?string $name): ?string {
        // si le nom est vide ou n'existe pas.
        if(empty($name)) {
            return $name;
        }
        // recuperer le nom avant le point
        $explode = explode(".", $name);
        // 
        $ext = $explode[count($explode)-1];
        return $explode[0]."_".uniqid().".".$ext;
    }
}

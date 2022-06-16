<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_img')) {

    include_once dirname(__FILE__) . '/../class/enum_type.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';

    // fonction pour faire la connexion a la base de donnes
    function add_img(?string $file_tmp, ?string $name, int $type) {
        if($type == Enum_Type::PRODUITS) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 1020, 577, true, true);
        }
        if($type == Enum_Type::CATEGORIE) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 64, 64, true, false);
        }
        if($type == Enum_Type::LOGO || $type == Enum_Type::USER) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 512, 512, true, false);
        }
        return move_uploaded_file($file_tmp, dirname(__FILE__) . '/../../../data/img/'.$name);
    }
}
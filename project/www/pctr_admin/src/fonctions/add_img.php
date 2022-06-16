<?php
/**
 * Pour ajouter des images avec la bonne taille.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_img')) {

    /* inclure des fonctionnalites à la page */
    include_once dirname(__FILE__) . '/../class/enum_type.php';
    include_once dirname(__FILE__) . '/../../../src/fonctions/modifier_images.php';

    /**
     * Pour ajouter une image avec la bonne taille dans "thumb".
     *
     * @param string|null $file_tmp le fichier temporaire
     * @param string|null $name le nom de l'image
     * @param integer $type le type correspondent a l'image (enum_type).
     * @return bool return true si c'est bon.
     */
    function add_img(?string $file_tmp, ?string $name, int $type):bool {
        if($type == Enum_Type::PRODUITS) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 1020, 577, true, true);
        } else if($type == Enum_Type::CATEGORIE) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 64, 64, true, false);
        } else if($type == Enum_Type::LOGO || $type == Enum_Type::USER) {
            modifier_image($file_tmp, dirname(__FILE__) . '/../../../data/thumb/', $name, 512, 512, true, false);
        }
        return move_uploaded_file($file_tmp, dirname(__FILE__) . '/../../../data/img/'.$name);
    }
}
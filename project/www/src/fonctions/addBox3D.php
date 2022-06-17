<?php
/**
 * pour la creation d'un box 3d
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('addBox3D')) {
    // inculre la classe qui va creer le fichier "errors.log" en cas d'erreur.
    include_once dirname(__FILE__) . '/../class/Error_Log.php';

    // fonction pour creer le box 3d
    function addBox3D(?string $contenu):?string {
        $addBox = '<figure class="box-3D box-3D-mov">'."\n";
        $addBox .= '<figure class="object-3D">'."\n";
        $addBox .= '<figure class="box-3D-front box-3D-default box-3D-color-glass box-3D-size">'."\n";
        $addBox .= '<div class="logo-info-3d">'."\n";
        $addBox .= '<img class="box-3D-logo-mov box-3D-logo" src="./src/img/360-degrees_3.svg" alt="mouvement 3D" />'."\n";
        $addBox .= '<img class="box-3D-logo" src="./src/img/Shiny-3d.svg" alt="objet 3D" />'."\n";
        $addBox .= '</div>'."\n";
        $addBox .= '<figure class="contenu-on-cat">'.$contenu.'</figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '</figure>'."\n";
        return $addBox;
    }
}

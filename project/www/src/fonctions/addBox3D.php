<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('addBox3D')) {
    // inculre la classe qui va creer le fichier "errors.log" en cas d'erreur.
    include_once dirname(__FILE__) . '/../class/Error_Log.php';

    // fonction pour faire la connexion a la base de donnes
    function addBox3D(?string $contenu):?string {
        $addBox = '<figure class="wrap-object-3D">'."\n";
        $addBox .= '<figure class="box-3D">'."\n";
        $addBox .= '<figure class="object-3D">'."\n";
        $addBox .= '<figure class="box-3D-front box-3D-default box-3D-color-glass">'."\n";
        $addBox .= '<figure class="contenu-on-cat">'.$contenu.'</figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '<figure class="box-3D-bottom box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-back box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-top box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-left box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-right box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="border-3D-left-top">'."\n";
        $addBox .= '<figure class="box-3D-border box-3D-border-1 box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-border box-3D-border-2 box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-border box-3D-border-3 box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '<figure class="box-3D-border box-3D-border-4 box-3D-default box-3D-color-glass"></figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '<figure class="border-3D-right-top"></figure>'."\n";
        $addBox .= '<figure class="border-3D-left-bottom"></figure>'."\n";
        $addBox .= '<figure class="border-3D-right-bottom"></figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '</figure>'."\n";
        $addBox .= '</figure>'."\n";
        return $addBox;
    }
}

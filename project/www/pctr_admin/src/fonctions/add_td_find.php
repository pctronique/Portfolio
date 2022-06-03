<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_td_find')) {

    // fonction pour faire la connexion a la base de donnes
    function add_td_find(?string $name_id, ?string $id, ?string $name) {
        $td = "<tr id=\"".$name_id."_".$id."\">";
        $td .= "<td>";
        $td .= "<a href=\"#\"><img class=\"delete_row\" id=\"delete_".$id."\" src=\"./../img/icons8-supprimer-pour-toujours-90.svg\" /></a>";
        $td .= "</td>";
        $td .= "<td>";
        $td .= "<a href=\"#\"><img class=\"modif_row\" id=\"modif_".$id."\" src=\"./../img/icons8-modifier.svg\" /></a>";
        $td .= "</td>";
        $td .= "<td class=\"name\">";
        $td .= $name;
        $td .= "</td>";
        $td .= "</tr>";
    }
}
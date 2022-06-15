<?php
/**
 * Pour se connecter a la base de donner a partir du fichier "sgbd_config.php".
 * Pouvoir avoir une connexion a la base de donnees differentes.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_td_find')) {

    // fonction pour faire la connexion a la base de donnes
    function add_td_find(?string $name_id, ?string $id, ?string $name, bool $display = false, bool $check_display = false): ?string {
        $td = "<tr id=\"".$name_id."_".$id."\">";
        $td .= "<td>";
        $td .= "<a href=\"#\"><img class=\"delete_row\" id=\"delete_".$id."\" src=\"./src/img/icons8-supprimer-pour-toujours-90.svg\" /></a>";
        $td .= "</td>";
        $td .= "<td>";
        $td .= "<a href=\"#\"><img class=\"modif_row\" id=\"modif_".$id."\" src=\"./src/img/icons8-modifier.svg\" /></a>";
        $td .= "</td>";
        if($check_display) {
            $td .= "<td>";
            $td .= "<div class=\"form-check form-switch\">";
            $td .= "<input class=\"form-check-input display_row custom-control-display colum_display\" type=\"checkbox\" name=\"display\" value=\"true\" id=\"checkDisplay_".$id."\" ".($display?"checked":"").">";
            $td .= "</div>";
            $td .= "</td>";
        }
        $td .= "<td class=\"name\">";
        $td .= $name;
        $td .= "</td>";
        $td .= "</tr>";
        return $td;
    }
}

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_td_find_line_js')) {
    function add_td_find_line_js(?string $name_id, ?string $id, ?string $name, bool $display = false, bool $check_display = false): ?array {
        return [
            "name_id" => $name_id,
            "id" => $id,
            "name" => $name,
            "display" => $display,
            "check_display" => $check_display,
        ];
    }
}
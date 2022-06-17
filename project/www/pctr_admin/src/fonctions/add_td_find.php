<?php
/**
 * Pour ajouter des valeurs dans le tableau admin.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('add_td_find')) {

    /**
     * Pour creer des lignes html du tableau a afficher.
     *
     * @param string|null $name_id recupere le debut du nom pour l'id de la ligne
     * @param string|null $id recupere l'id (valeur numerique)
     * @param string|null $name recupere le nom ou le titre
     * @param boolean $display s'il est afficher ou non sur la page
     * @param boolean $check_display a un mode d'affichage
     * @return string|null ligne html a ajouter au code
     */
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
    /**
     * Recuperer les valeurs sur un tableau a format unique.
     *
     * @param string|null $name_id recupere le debut du nom pour l'id de la ligne
     * @param string|null $id recupere l'id (valeur numerique)
     * @param string|null $name recupere le nom ou le titre
     * @param boolean $display s'il est afficher ou non sur la page
     * @param boolean $check_display a un mode d'affichage
     * @return array|null recupere un tableau unique pour tout les choix
     */
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
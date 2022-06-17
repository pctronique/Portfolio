<?php
/**
 * Pour supprimer les fichiers du serveur.
 */

// verifier qu'on n'a pas deja creer la fonction
if (!function_exists('delete_file')) {

    /**
     * Undocumented function
     *
     * @param string|null $name
     * @return boolean
     */
    function delete_file(?string $name): bool {
        // verifier qu'on a un non de fichier a supprimer.
        if(empty($name)) {
            return false;
        }
        // supprimer le fichier partout.
        $file = dirname(__FILE__) . '/../../../data/file/'.$name;
        if(file_exists($file)) {
            unlink($file);
        }
        $file = dirname(__FILE__) . '/../../../data/img/'.$name;
        if(file_exists($file)) {
            unlink($file);
        }
        $file = dirname(__FILE__) . '/../../../data/thumb/'.$name;
        if(file_exists($file)) {
            unlink($file);
        }
        return true;
    }
}
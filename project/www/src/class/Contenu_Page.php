<?php
/**
 * Pour la creation d'un fichier "errors.log" avec les messages d'erreurs rencontres.
 */
if (!class_exists('Contenu_Page')) {

    /**
     * Pour les contenir tous les logs rencontres dans les pages.
     */
    class Contenu_Page {

        // les variable de la classe
        private $tab_css;
        private $tab_js;
        private $contenu;

        /**
         * constructeur par defaut.
         */
        public function __construct() {
            $this->tab_css = array();
            $this->tab_js = array();
            $this->contenu = "";
        }

        public function addCss(?string $lien): void {
            array_push($this->tab_css, $lien);
        }

        public function addJs(?string $lien): void {
            array_push($this->tab_js, $lien);
        }

        public function setContenu(?string $contenu): void {
            $this->contenu = $contenu;
        }

        public function getContenu(): ?string {
            return $this->contenu;
        }

        public function displayCss(): ?string {
            $display = "";
            foreach ($this->tab_css as $value) {
                $display .= "<link rel=\"stylesheet\" href=\"".$value."\" />"."\n";
            }
            return $display;
        }

        public function displayJs(): ?string {
            $display = "";
            foreach ($this->tab_js as $value) {
                $display .= "<script src=\"".$value."\"></script>"."\n";
            }
            return $display;
        }


    }
}

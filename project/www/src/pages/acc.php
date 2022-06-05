<?php

if(defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_acc = new Contenu_Page();

    $name_cat = "jjj";//print_r($_SESSION);

    $html = file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true);

    $html = str_replace("[##categorie##]", $name_cat, $html);

    $page_acc->setContenu($html);

}

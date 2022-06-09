<?php

if(!empty($_GET) && array_key_exists('ind', $_GET) && $_GET['ind'] == "msg" && defined("USER_ID") && !empty(USER_ID)) {

    include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

    $page_msg = new Contenu_Page();

    $page_msg->addCss("./src/css/style_message.css");
    $page_msg->addJs("./src/js/message.js");
    $page_msg->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/message.html', true));

}
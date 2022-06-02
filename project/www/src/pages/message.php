<?php

include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

$page_msg = new Contenu_Page();

$page_msg->addCss("./src/css/style_message.css");
$page_msg->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/message.html', true));
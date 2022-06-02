<?php

include_once dirname(__FILE__) . '/../class/Contenu_Page.php';

$page_acc = new Contenu_Page();

$page_acc->setContenu(file_get_contents(dirname(__FILE__) . '/../templates/acc.html', true));
<?php

include_once dirname(__FILE__) . '/../../../src/class/Contenu_Page.php';

$page_user = new Contenu_Page();

$html = file_get_contents(dirname(__FILE__) . '/../templates/user.html', true);

$name = "";
$first_name = "";
$login = "";
$email = "";

$html = str_replace("[##NAME_USER##]", $name, $html);
$html = str_replace("[##FIRST_NAME_USER##]", $first_name, $html);
$html = str_replace("[##LOGIN_USER##]", $login, $html);
$html = str_replace("[##EMAIL_USER##]", $email, $html);

$page_user->setContenu($html);
$page_user->addCss("./src/js/user.js");
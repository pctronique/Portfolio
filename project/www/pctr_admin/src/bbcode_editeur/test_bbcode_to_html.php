<?php

if(!empty($_POST) && array_key_exists("test", $_POST)) {
    include_once dirname(__FILE__) . '/bbcode_to_html.php';
    
    $html = recup_bbcode($_POST["test"]);
    echo "true"."[##HTML##]".$_POST["test"]."[##HTML##]".$html;
} else {
    echo "error";
}
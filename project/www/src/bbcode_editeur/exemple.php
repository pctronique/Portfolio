<?php
include_once './conversion_bbcode.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-bbcode.css" />
    <title>Document</title>
</head>
<body>

<textarea class="editor_bbcode" readonly>[center][size=3][strong]BBCode SCEditor[/strong][/size][/center]

Give it a try! :)

[color=#ff00]Red text! [/color][color=#3399ff]Blue?[/color]

[ul][li]A simple list[/li][li]list item 2[/li][/ul]

Just type [strong]:[/strong]) and it should be converted into :) as you type.</textarea>

<button id="btn-test-58"></button>

<textarea class="editor_bbcode"></textarea>


<div id="test021"></div>

<script src="./bbcode.js"></script>
<script src="./js_test_bbcode.js"></script>
<script>
</script>

<p><?php echo conversion_bbcode("[title]Titre[/title] \n test 021 [b]strong[/b]."); ?></p>
    
</body>
</html>
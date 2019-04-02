<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$display->saveContent($_POST["name"], $_POST["content"]);

?>

<html lang="en">
<body>
<p><?=$_POST["name"]?> was saved</p>
<button type="button" onclick="window.location.href='index.php'">Back To Start</button>
</body>
</html>
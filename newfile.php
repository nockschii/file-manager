<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

var_dump($_POST["name"]);
$display = new Display(new FileHandler());
$display->createFile($_POST["name"]);

?>

<html lang="en">
<body>
<p><?=$_POST["name"]?> was created.</p>
<button type="button" onclick="window.location.href='index.php'">Back To Start</button>
</body>
</html>
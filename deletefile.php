<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;
var_dump($_GET["name"]);
$display = new Display(new FileHandler());
$display->deleteFile($_GET["name"]);

?>

<html lang="en">
<body>
<p><?=$_GET["name"]?> was deleted.</p>
<button type="button" onclick="window.location.href='index.php'">Back To Start</button>
</body>
</html>
<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$display->renameFile($_POST["oldName"], $_POST["newName"]);

?>

<html lang="en">
<body>
<p>File renamed to <?=$_POST["newName"]?></p>
    <button type="button" onclick="window.location.href='index.php'">Back To Start</button>
</body>
</html>
<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$display->rename($_POST["oldName"], $_POST["newName"]);

?>

<html lang="en">
<body>
<p>File renamed to <?=$_POST["newName"]?></p>
    <form action="http://file-manager.bru/">
        <button type="submit">Back To Start</button>
    </form>
</body>
</html>
<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$display->deleteFile($_GET["name"]);

?>

<html lang="en">
    <body>
        <p><?=$_GET["name"]?> was deleted.</p>
        <form action="http://file-manager.bru/">
            <button type="submit">Back To Start</button>
        </form>
    </body>
</html>
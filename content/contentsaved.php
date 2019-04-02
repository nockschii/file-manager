<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$display->saveContent($_POST["name"], $_POST["content"]);

?>

<html lang="en">
    <body>
        <p><?=$_POST["name"]?> was saved.</p>
        <form action="http://file-manager.bru/">
            <button type="submit">Back To Start</button>
        </form>
    </body>
</html>
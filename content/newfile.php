<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());

try {
    $display->createFile($_POST["name"]);
     echo '<p>'.$_POST["name"].' was created.</p>';
} catch (Exception $e) {
    echo "<p>File is already exists.</p>";
}

?>

<html lang="en">
    <body>

        <form action="http://file-manager.bru/">
            <button type="submit">Back To Start</button>
        </form>
    </body>
</html>
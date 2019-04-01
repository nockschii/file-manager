<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler);
?>

<html lang="en">
    <body>
        <form action="content.php" method="post" id="contentform">
            <textarea rows="30" cols="70" form="contentform" name="content">
                <?php echo $display->displayFileContent($_GET["name"]); ?>
            </textarea>
        </form>
        <button type="button" onclick="window.location.href='index.php'">Back To Start</button>
        <button type="submit" onclick={$display->saveContent($_POST["name"], $_POST["content"])}>Save</button>
        <button type="button">Cancel</button>
    </body>
</html>

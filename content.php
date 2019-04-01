<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());

 ?>

<html lang="en">
    <body>
        <form action="contentsaved.php" method="post">
            <textarea name="content" rows="30" cols="70">
                <?php echo $display->displayFileContent($_GET["name"]); ?>
            </textarea>
            <button type="button" onclick="window.location.href='index.php'">Back To Start</button>
            <input name="name" type="hidden" value="<?=$_GET["name"]?>">
            <button type="submit">Save</button>
            <button type="button" onclick="window.location.reload();">Cancel</button>
        </form>
    </body>
</html>
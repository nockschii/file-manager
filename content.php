<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());

 ?>

<html lang="en">
    <body>
        <form action="renamed.php" method="post">
            <input name="oldName" type="hidden" value="<?=$_GET["name"]?>">
            <p><input name="newName" type="text" value="<?=$_GET["name"]?>"><button type="submit">Rename File</button></p>
        </form>
        <form action="contentsaved.php" method="post">
            <textarea name="content" rows="30" cols="70">
                <?php echo $display->fileContent($_GET["name"]); ?>
            </textarea>
            <br>
            <button type="button" onclick="window.location.href='index.php'">Back To Start</button>
            <input name="name" type="hidden" value="<?=$_GET["name"]?>">
            <button type="submit">Save</button>
            <button type="button" onclick="window.location.reload();">Cancel</button>
        </form>
    </body>
</html>
<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
?>

<html lang="en">
<body>
<!-- Rename -->
<form action="actiondone.php?method=rename" method="post">
    <input name="oldName" type="hidden" value="<?=$_GET["name"]?>">
    <p><input name="newName" type="text" value="<?=$_GET["name"]?>"><button type="submit">Rename File</button></p>
</form>
<!-- Save -->
<form action="actiondone.php?method=save" method="post">
            <textarea name="content" rows="30" cols="70">
                <?php echo $display->fileContent($_GET["name"]); ?>
            </textarea>
    <br>
    <input name="name" type="hidden" value="<?=$_GET["name"]?>">
    <button type="submit">Save</button>
    <button type="button" onclick="window.location.reload();">Cancel</button>
</form>
<form action="http://file-manager.bru/">
    <button type="submit">Back To Start</button>
</form>
</body>
</html>
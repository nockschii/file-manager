<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

function saveContent() {
    if (isset($_POST["content"])) {
        $display = new Display(new FileHandler());
        $display->saveContent($_POST["name"], $_POST["content"]);
    }
}

function displayContent() {
    $display = new Display(new FileHandler());
    if (isset($_GET["name"])) {
        echo $display->displayFileContent($_GET["name"]);
    } elseif (isset($_POST["name"])) {
        echo $display->displayFileContent($_POST["name"]);
    }
}

function getName() {
    $_GET['name'] = $_POST['name'];
}

?>

<html lang="en">
    <body>
        <form action="content.php" method="post">
            <textarea name="content" rows="30" cols="70">
                <?php displayContent(); ?>
            </textarea>
            <button type="button" onclick="window.location.href='index.php'">Back To Start</button>
            <input name="name" type="hidden" value="<?=$_POST["name"]?>">
            <button type="submit" onclick="<?php saveContent();?>">Save</button>
            <button type="button" onclick="window.location.reload();">Refresh</button>
            <button type="button">Cancel</button>
        </form>
    </body>
</html>
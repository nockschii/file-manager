<?php

require_once("../vendor/autoload.php");

use FileManager\ContentController;
use FileManager\FileHandler;

$controller = new ContentController(new FileHandler());
$browserMessage = "";

if ($_GET["method"] === "rename") {
    $controller->rename($_POST["oldName"], $_POST["newName"]);
    $browserMessage = "{$_POST['oldName']} was renamed to {$_POST['newName']}.";
} elseif ($_GET["method"] === "save") {
    $controller->saveContent($_POST["name"], $_POST["content"]);
    $browserMessage = "{$_POST['name']} was saved.";
} elseif ($_GET["method"] === "create") {
    try {
        $controller->createFile($_POST["name"]);
        $browserMessage = "{$_POST['name']} was created.";
    } catch (Exception $e) {
        $browserMessage = "already exists";
    }
} elseif ($_GET["method"] === "delete") {
    $controller->deleteFile($_GET["name"]);
    $browserMessage = "{$_GET["name"]} was deleted.";
} else {
    echo "You should not be here";
}

?>

<html lang="en">
    <body>
        <p>File: <?=$browserMessage?></p>
        <form action="http://file-manager.bru/">
            <button type="submit">Back To Start</button>
        </form>
    </body>
</html>


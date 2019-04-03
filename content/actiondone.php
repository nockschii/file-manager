<?php

require_once("../vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler());
$actionName = "";

if ($_GET["method"] === "rename") {
    $display->rename($_POST["oldName"], $_POST["newName"]);
    $actionName = "{$_POST['oldName']} was renamed to {$_POST['newName']}.";
} elseif ($_GET["method"] === "save") {
    $display->saveContent($_POST["name"], $_POST["content"]);
    $actionName = "{$_POST['name']} was saved.";
} elseif ($_GET["method"] === "create") {
    try {
        $display->createFile($_POST["name"]);
        $actionName = "{$_POST['name']} was created.";
    } catch (Exception $e) {
        $actionName = "already exists";
    }
} elseif ($_GET["method"] === "delete") {
    $display->deleteFile($_GET["name"]);
    $actionName = "{$_GET["name"]} was deleted.";
} else {
    echo "You should not be here";
}

?>

<html lang="en">
    <body>
        <p>File <?=$actionName?></p>
        <form action="http://file-manager.bru/">
            <button type="submit">Back To Start</button>
        </form>
    </body>
</html>


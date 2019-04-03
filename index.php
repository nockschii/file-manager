<?php

require_once("vendor/autoload.php");

use FileManager\ContentController;
use FileManager\FileHandler;

$controller = new ContentController(new FileHandler);

?>

<html lang="en">
    <body>
        <p>All Files: </p>
        <?php echo $controller->displayAllFiles(); ?>
        <hr size="1">
        <p>New File (TextFileName.ext): </p>
        <form action="content/actiondone.php?method=create" method="post">
            <button type="submit" style="margin-right: 1em">create</button><input name="name" type="text" placeholder="TextFileName.ext">
        </form>
    </body>
</html>


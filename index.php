<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler);

?>

<html lang="en">
    <body>
        <p>All Files: </p>
        <?php echo $display->allFiles(); ?>
        <hr size="1">
        <p>New File: </p>
        <form action="newfile.php" method="post">
            <input name="name" type="text" placeholder="TextFileName.ext"><button type="submit">Create</button>
        </form>
    </body>
</html>


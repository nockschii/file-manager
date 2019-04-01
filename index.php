<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler);

?>

<html lang="en">
    <body>
        <?php echo $display->allFiles(); ?>
    </body>
</html>


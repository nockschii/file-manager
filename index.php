<?php

require_once("vendor/autoload.php");

use FileManager\Display;
use FileManager\FileHandler;

$display = new Display(new FileHandler);

?>

<html>
    <body>
        <?php echo $display->allFiles();
        ?>
    </body>
</html>


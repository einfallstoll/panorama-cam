<?php

include "include/configurations.php"; //Load Configs //Todo: ad persmission-file location

//Initialization


//Request Control
file_put_contents($path, $_REQUEST('UUID'), FILE_APPEND);

//

?>
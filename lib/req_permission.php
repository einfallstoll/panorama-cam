<?php
include "include/constants.php";
include "include/configurations.php";
include "include/update_permissions.php";

//Request Control
file_put_contents($path, $_REQUEST('uuid'), FILE_APPEND);
?>
<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//Request Control for future use
$permissions = json_decode(file_get_contents($pFile));
array_push($permissions,$_REQUEST['uuid']);
file_put_contents($pFile, json_encode($permissions));
echo('1');
?>
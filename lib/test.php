<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//this returns the status of the permission request for a uuid

//Initialization 
$permissions = file($pFile,FILE_IGNORE_NEW_LINES);
$current = date_create();
$current = date_timestamp_get($current);

echo($_REQUEST['uuid']);
var_dump($permissions);

?>
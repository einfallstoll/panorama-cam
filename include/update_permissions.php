<?php
include "include/constants.php";
include "include/configurations.php";

//This file updates the permission File

//Initialization
$permissions = file($pFile);
$current = date_create();
$current = date_timestamp_get($current);

//If more requests clear the first after $permission_free_after
if ($current - $permissions[0] >= $permission_free_after && count($permissions) > 2 ) {
	unset($permissions[1]);
	$permissions[0] = $current;
	file_put_contents($pFile, $permission);
}
?>
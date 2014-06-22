<?php
include "constants.php";
include "configurations.php";

//This file updates the permission File

//Initialization
$current = date_create();
$current = date_timestamp_get($current);
if (!file_exists($pFile)) {
	file_put_contents($pFile, json_encode([$current]));
}
$permissions = json_decode(file_get_contents($pFile));

//If more requests clear the first after $permission_free_after
if ($current - $permissions[0] >= $permission_free_after && count($permissions) > 2 ) {
	unset($permissions[1]);
	$permissions[0] = $current; //this works, however it is not perfect: if should be while and it should be a two dimensional array: each entry both contains the request timestamp and the uuid
	$permissions = array_values($permissions);
	file_put_contents($pFile, json_encode($permissions));
}
?>
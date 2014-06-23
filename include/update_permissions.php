<?php
include "constants.php";
include "configurations.php";

//This file updates the permission File

if (file_exists($pFile)) {
	//Initialization
	$current = date_create();
	$current = date_timestamp_get($current);
	$permissions = json_decode(file_get_contents($pFile));
	//while more requests clear the first after $permission_free_after
	while (count($permissions) > 1 && $current - $permissions[0][0] >= $permission_free_after) {
		unset($permissions[0]);
		$permissions = array_values($permissions);
		file_put_contents($pFile, json_encode($permissions));
	}
}


?>
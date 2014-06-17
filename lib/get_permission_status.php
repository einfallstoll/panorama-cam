<?php
include "include/constants.php";
include "include/configurations.php";
include "include/update_permissions.php";

//Initialization 
$permissions = file($pFile);
$current = date_create();
$current = date_timestamp_get($current);
$found = false;
$counter = 0;

foreach($permissions as $permission) {
	if ($permission == $_REQUEST('uuid')) {
		if ($counter = 1) {
			echo($permission_free_after $permissions[0] - $current)
		}
		$found = false;
	}
	$counter = $counter + 1;
}
//If more requests clear the first after $permission_free_after
if ($current - $permissions[0] >= $permission_free_after && count($permissions) > 2 ) {
	unset($permissions[1]);
	$permissions[0] = $current;
	file_put_contents($pFile, $permission);
}

?>
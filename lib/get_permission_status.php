<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//this returns the status of the permission request for a uuid

//Initialization 
$permissions = json_decode(file_get_contents($pFile));
$current = date_create();
$current = date_timestamp_get($current);

//no respones if not in permission-que
if (in_array($_REQUEST['uuid'], $permissions)) {
	if (count($permissions)==2){
		echo('0'); //means uuid has currently controll for a unlimited ammount of time
	} else {
		$i = $permission_free_after - ($current-$permissions[0]);
		if ($permissions[1]===$_REQUEST['uuid']) {
			echo($i);
		} else {
			$i = $i + (array_search($_REQUEST['uuid'],$permissions)-2)*$permission_free_after;
			echo('-'.$i);
		}
	}
}
?>
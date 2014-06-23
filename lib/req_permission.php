<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//Request Control for future use

//Initialization 
$current = date_create();
$current = date_timestamp_get($current);
$permissions = [];
$afterLast = 0;

//Fetch existing Data
if (file_exists($pFile)) {
	$permissions = json_decode(file_get_contents($pFile));
	if (count($permissions) > 0) {
		$afterLast = end($permissions)[0] + $permission_free_after;
	}
}

//Create request for permission
$toPush = [$current,$_REQUEST['uuid']];
if ($afterLast > $current) {
	$toPush[0] = $afterLast;
}

//Push&Save
array_push($permissions,$toPush);
file_put_contents($pFile, json_encode($permissions));
?>

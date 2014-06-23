<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//this returns the status of the permission request for a uuid

if (file_exists($pFile)) {

	//Initialization 
	$current = date_create();
	$current = date_timestamp_get($current);
	$permissions = json_decode(file_get_contents($pFile));
	
	//no respones if not in permission-que
	if (in_array_r($_REQUEST['uuid'], $permissions)) {
        $int = $permission_free_after - ($current-$permissions[0][0]);			
        if ($permissions[0][1]===$_REQUEST['uuid']) {
            if ($int < 0) {
                echo('0'); //means uuid has currently controll for a unlimited ammount of time
            } else {
                echo($int); //has controll for this amount of time left
            }
        } else {
            for ($i = 1; $i < count($permissions) - 1; $i++) {
                // the first takes not a full time
                // the last is the requesting client
                if ($permissions[$i][1] == $_REQUEST['uuid']) {
                    $int = $int + $i*$permission_free_after;
                    break;
                }
            }
            echo('-'.$int); //gains control in this amount of time
        }
	}
}

//in_array for multidimensional arrays:
function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}
?>
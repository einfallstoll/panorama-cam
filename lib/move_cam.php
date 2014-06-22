<?php
include "../include/constants.php";
include "../include/configurations.php";
include "../include/update_permissions.php";

//this moves the cam if permission matches uuid

//Initialization 
$permissions = json_decode(file_get_contents($pFile));

//no respones if not in permission-que
if ($permissions[1] === $_REQUEST['uuid'] && isset($_REQUEST['direction'])) {
	$curl = curl_init($url_beginning . $cam_adr . $url_middle . $url_comm_rotate . $_REQUEST('direction'));
    curl_exec($curl);
	echo('1');
} else {
	echo('0')
}
?>
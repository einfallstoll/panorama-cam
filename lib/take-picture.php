<?php

include "include/configurations.php"; //Load Configs
include "include/constants.php"; //Load Constants

//Initialization
chdir(dirname(__FILE__));
ini_set('max_execution_time', $max_execution_time);
$current = date_create(); //Will be reused since assembling the panorama takes > 60 secs
$pic_targetFolder = $pic_folder_root . date_format($current, $pic_folder_format);
if (!is_dir($pic_targetFolder)) { //Create folder if necessary
	mkdir($pic_targetFolder, 0777, true);
}
rotateHome();

//Picture-Taking

setPanSpeed(5);
rotateCamera(6); //go to the left as far as possible
sleep(5); //to ensure the camera has stopped moving

setpanspeed($pan_speed );
for ($i = 0; $i < $pic_count; $i++) {
    takePicture($i);
    rotateCamera(-1);
	sleep(1); //to ensure the camera has stopped moving
}

//Panorama-Generating
$panorama = imagecreatetruecolor($pic_sliceWidth * $pic_count, 480-($pic_heightAdjustment*$pic_count));
for ($i = 0; $i < $pic_count; $i++) {
   $picName =  date_format($current, 'i') . '-' . $i . '.jpg';
   $picPath = $pic_targetFolder . '/' . $picName;
   $picToCopy = imagecreatefromjpeg($picPath);
   imagecopy($panorama, $picToCopy, $pic_sliceWidth * $i, -$pic_heightAdjustment * $i, 0, ($pic_heightAdjustment*$i), $pic_sliceWidth, 480-($pic_heightAdjustment*$i));
}
imagejpeg($panorama, $pic_targetFolder . '/' . date_format($current, 'i') . '-panorama.jpg');

//Finalization
rotateHome();

//Functions

//Calls command-urls
function executeCommandURL($theCommandURL) {
	print($theCommandURL); //Still included since, this file isn't supposed to be called by humans - if it is, this information is wanted
    $curl = curl_init($theCommandURL);
    curl_exec($curl);
} 

//Set current Cam-Pan-Speed (5 - -5)
function setPanSpeed($panSpeed) {
	global $url_beginning, $cam_adr, $url_middle, $url_comm_panspeed; //PHP has weird scopes...
	executeCommandURL($url_beginning . $cam_adr . $url_middle . $url_comm_panspeed . $panSpeed);
}

//Rotates the camera $rotation times. negative $rotation directs the movement to the right instead of left
function rotateCamera($rotation) {
    global $url_beginning, $cam_adr, $url_middle, $url_comm_rotate; 
	//Decide direction
	if ($rotation > 0) {
        $dir = 'left';
    } else {
		$dir = 'right';
	}
	//Rotate
    for ($i = 0; $i < abs($rotation) * 2; $i++) {
		executeCommandURL($url_beginning . $cam_adr . $url_middle . $url_comm_rotate . $dir);
    }
}

//Takes a picture and stores it with $num appended
function takePicture($num) {   
    global $url_beginning, $cam_adr, $url_middle, $url_comm_pic, $current, $pic_targetFolder; 
	$picURL = $url_beginning . $cam_adr . $url_middle . $url_comm_pic;
    $imgName = $pic_targetFolder . '/' . date_format($current, 'i') . '-' . $num . '.jpg';
	//Save the image
    file_put_contents($imgName, file_get_contents($picURL));
}

//Rotates the camera back to its home-position
function rotateHome() {
	global $url_beginning, $cam_adr, $url_middle, $url_comm_rotate;
	executeCommandURL($url_beginning . $cam_adr . $url_middle . $url_comm_rotate . 'home');
}

//Utility
function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

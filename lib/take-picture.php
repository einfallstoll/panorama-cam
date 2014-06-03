<?php

//Configuration
$max_execution_time = 999; //time the camera has to take and assemble it's picture, has to be <= time to next request
$cam_adr = "10.142.126.249"; //address over which the camera (it's pictures and controls) can be reached 

$pic_count = 68; //how many pictures are used per panorama. the more, the higher quality the panorama can be  
$pan_speed = '-5'; //which speed pre set is used while taking pictures. interacts with pic_count and generally lower means higher quality panorama

//Initialization
date_default_timezone_set('Europe/Zurich'); //Not configurable because it just sets the default
ini_set('max_execution_time', $max_execution_time);
$current = date_create();
$url_beginning = 'http://';
$url_middle = '/cgi-bin/';
$url_comm_panspeed = 'camctrl.cgi?speedpan=';
$url_comm_rotate = 'camctrl.cgi?move=';
rotatehome();

//Picture-Taking

setPanSpeed(5);
rotateCamera(6); //go to the left as far as possible
sleep(5); //to ensure the camera has stopped moving

setpanspeed($pan_speed );
for ($i = 0; $i < $pic_count; $i++) {
    takePicture($current, $i);
    rotateCamera(-1);
	sleep(1); //to ensure the camera has stopped moving
}

//Panorama-Generating

//Finalization
rotatehome();

$folder = '../pics/' . date_format($current, 'Y/m/d/H/i');
$dirhandle = opendir($folder);
$count = 0;
$slicewidth = 65;
$heightadjustment = 3;

$image = imagecreatetruecolor($slicewidth * $config['picture-count'], 480-($heightadjustment*$count));
while (($file = readdir($dirhandle))) {
	print(date_format($current, 'i') . '-' . $count . '.');
    if (startsWith($file, date_format($current, 'i') . '-' . $count . '.')) {
        $imgtocopy = imagecreatefromjpeg($folder . '/' . $file);
		imagecopy($image, $imgtocopy, $slicewidth * $count, -$heightadjustment * $count, 0, ($heightadjustment*$count), $slicewidth, 480-($heightadjustment*$count));
		$count++;
    }
}
imagejpeg($image, $folder . '/' . date_format($current, 'i') . '-panorama.jpg');

//Functions

//Calls command-urls
function executeCommandURL($theCommandURL) {
	print($theCommandURL); //Still included since, this file isn't supposed to be called by humans - if it is this information is wanted
    $curl = curl_init($theCommandURL);
    curl_exec($curl);
} 

//Set current Cam-Pan-Speed (5 - -5)
function setPanSpeed($panSpeed) {
	executeCommandURL($url_beginning . $cam_adr . $url_middle . $url_comm_panspeed . $panSpeed);
}

//Rotates the camera $rotation times. negative $rotation directs the movement to the right instead of left
function rotateCamera($rotation) {
    if ($rotation > 0) {
        $dir = 'left';
    } else {
		$dir = 'right';
	}
    for ($i = 0; $i < abs($rotation) * 2; $i++) {
		executeCommandURL($url_beginning . $cam_adr . $url_middle . $url_comm_rotate . $dir);
    }
}

function takePicture($stamp, $num) {    
    $url = 'http://' . $config['ip'] . '/cgi-bin/video.jpg';
    $folder = '../pics/' . date_format($stamp, 'Y/m/d/H/i');
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }
    $img = $folder . '/' . date_format($stamp, 'i') . '-' . $num . '.jpg';
    file_put_contents($img, file_get_contents($url));
}

function rotatehome() {
    global $config;
    
    $url = 'http://' . $config['ip'] . '/cgi-bin/camctrl.cgi?move=home';
    $curl = curl_init($url);
	print($url);
    curl_exec($curl);
}

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}
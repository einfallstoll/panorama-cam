<?php

ini_set('max_execution_time', 59);

$config = json_decode(file_get_contents('../config.json'), 1);

function setpanspeed($panspeed) {
    global $config;
    
    $url = 'http://' . $config['ip'] . '/cgi-bin/camctrl.cgi?speedpan=' + $panspeed;
    $curl = curl_init($url);
    curl_exec($curl);
}

function takepicture($stamp, $num) {
    global $config;
    
    $url = 'http://' . $config['ip'] . '/cgi-bin/video.jpg';
    $folder = '../pics/' . date_format($stamp, 'Y/m/d/H');
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
    curl_exec($curl);
    
    sleep(5);
}

function rotatecamera($direction) {
    global $config;
    
    $dir = 'right';
    if ($direction > 0) {
        $dir = 'left';
    }
    
    for ($i = 0; $i < abs($direction) * 2; $i++) {
        $url = 'http://' . $config['ip'] . '/cgi-bin/camctrl.cgi?move=' . $dir;
        $curl = curl_init($url);
        curl_exec($curl);
    }
    
    sleep(abs($direction));
}

function startsWith($haystack, $needle) {
    return $needle === "" || strpos($haystack, $needle) === 0;
}

date_default_timezone_set('Europe/Zurich');

$current = date_create();

setpanspeed(-5);
rotatehome();
rotatecamera($config['picture-count']/2);
for ($i = 0; $i < $config['picture-count']; $i++) {
    takepicture($current, $i);
    rotatecamera(-1);
    sleep(1);
}
rotatehome();

$folder = '../pics/' . date_format($current, 'Y/m/d/H');
$dirhandle = opendir($folder);
$count = 0;
$slicewidth = 408;
$heightadjustment = 3;

$image = imagecreate($slicewidth * $config['picture-count'], 480-$heightadjustment);
while (($file = readdir($dirhandle))) {
    if (startsWith($file, date_format($current, 'i') . '-')) {
        $imgtocopy = imagecreatefromjpeg($folder . '/' . $file);
        if ($count == 0) {
			imagecopy($image, $imgtocopy, $slicewidth * $count, 0, 0, 0, $slicewidth, 480-$heightadjustment);
		} else {
			imagecopy($image, $imgtocopy, $slicewidth * $count, $heightadjustment, 0, 0, $slicewidth, 480);
		}
		$count++;
    }
}
imagejpeg($image, $folder . '/' . date_format($current, 'i') . '-panorama.jpg');

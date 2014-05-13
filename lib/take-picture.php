<?php

$config = json_decode(file_get_contents('../config.json'), 1);

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

date_default_timezone_set('Europe/Zurich');

$current = date_create();

rotatehome();
rotatecamera(6);
for ($i = 1; $i < 7; $i++) {
    takepicture($current, $i);
    rotatecamera(-1);
    sleep(1);
}
rotatehome();

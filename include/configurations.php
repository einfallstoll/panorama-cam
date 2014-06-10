<?php

//global centralized Configuration

//General
$cam_adr = "192.168.2.19"; //address over which the camera can be reached 

$pic_folder_root = '../pics/'; //defines root folder for picture archiv
$pic_folder_format = 'Y/m/d/H/i'; //defines archiv-structure for pictures

//Panorama-Generating
$max_execution_time = 500; //max time to assemble panorama. has to be <= time to next request

$pan_speed = '-5'; //which speed pre-set is used while taking pictures to move the camera
$pic_count = 68; //how many pictures are used per panorama. the more, the better the quality
$pic_sliceWidth = 65; //how much is used from each picture
$pic_heightAdjustment = 0; //how far has the panorama to be corected between each pic
?>
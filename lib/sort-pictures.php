<?php

// order for the structuring levels
$order = array('y', 'm', 'd', 'h', 'i');

// here will the sorted levels be
$content = array('y' => array(), 'm' => array(), 'd' => array(), 'h' => array(), 'i' => array());

// months-names
$months = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');

// sort the directory
function sortDir($dir, $level = 0) {
    global $order, $content;
    $dirhandle = opendir($dir);
    while (($file = readdir($dirhandle))) {
        
        // still not agreeing that this is necessary
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        // if it's a directory let's move on an sort it into the structure above
        if (is_dir($dir . '/' . $file)) {
            
            // if it's not already an array then create one
            if (!in_array($file, $content[$order[$level]])) {
                $content[$order[$level]][] = $file;
            }
            
            // recursion!
            sortDir($dir . '/' . $file, $level + 1);
        }
    }
}

// entry point for pics-folder
sortDir('pics');

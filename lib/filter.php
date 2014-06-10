<?php

// folder-structure order 
$order = array('y', 'm', 'd', 'h', 'i');

// here will be the final pics
$pics = array();

// checkif haystack ends with needle
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    
    // if the needle-length is equals to zero it's always a match
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

// filter directory
function filterDir($dir, $level = 0) {
    global $order, $pics;
    $dirhandle = opendir($dir);
    while (($file = readdir($dirhandle))) {
        
        // why the fuck would anyone want the current or parent directory?! I can't understand why I should do this fix... stupid PHP... 
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        // if it's a directory and either no filter is set for this level or the filter matches it will go on searching
        if (is_dir($dir . '/' . $file) && (!isset($_POST[$order[$level]]) || in_array($file, $_POST[$order[$level]]))) {
            filterDir($dir . '/' . $file, $level + 1);
        } else if (endsWith($file, 'panorama.jpg')) {
            // if it's a panorama-pic add it, the pre-filtering matched everything... hooray
            $pics[] = $dir . '/' . $file;
        }
    }
}

// start filtering the folder 'pics'
filterDir('../pics');

// go on and print the pics
foreach ($pics as $pic) {
    $pic_date = substr($pic, strpos($pic, '/') + 1);
    $pic_date = substr($pic_date, 0, strrpos($pic_date, '/'));
?>
<h5><?php echo date_format(date_create_from_format('Y/m/d/H/i', $pic_date), 'd.m.Y H:i') ?></h5>
<img src="<?php echo $pic ?>" class="thumbnail" />
<?php
}

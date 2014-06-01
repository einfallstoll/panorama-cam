<?php

$order = array('y', 'm', 'd', 'h');
$pics = array();

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function filterDir($dir, $level = 0) {
    global $order, $pics;
    $dirhandle = opendir($dir);
    while (($file = readdir($dirhandle))) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        if (is_dir($dir . '/' . $file) && (!isset($_POST[$order[$level]]) || in_array($file, $_POST[$order[$level]]))) {
            filterDir($dir . '/' . $file, $level + 1);
        } else if (endsWith($file, 'panorama.jpg')) {
            $pics[] = $dir . '/' . $file;
        }
    }
}

filterDir('pics');

foreach ($pics as $pic) {
?>
<img src="<?php echo $pic ?>" class="thumbnail" />
<?php
}

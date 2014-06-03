<?php
	include "include/header.php" 
?>

<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<?php
        
    function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    function printDir($dir) {
        $dirhandle = opendir($dir);
        while (($file = readdir($dirhandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($dir . '/' . $file)) {
                printDir($dir . '/' . $file);
            } else if (endsWith($file, 'panorama.jpg')) {
?>
    <a href="<?php echo $dir . '/' . $file; ?>">
        <img src="<?php echo $dir . '/' . $file; ?>" class="thumbnail">
    </a>
<?php
            }
        }
    }
?>

<div id="links">
    <?php printDir('./pics'); ?>
</div>

<?php
	include "include/footer.php" 
?>

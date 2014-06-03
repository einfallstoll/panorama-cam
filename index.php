<?php
	include "include/header.php" 
?>

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

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="tag-chooser">
                <div id="tag-chooser-chosen">
                    <h4>Filter</h4>
                    <button class="btn btn-primary" data-tag-key="y" data-tag-value="<?php echo date('Y') ?>"><?php echo date('Y') ?> <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="m" data-tag-value="<?php echo date('m') ?>"><?php echo $months[date('m') - 1] ?> <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="d" data-tag-value="<?php echo date('d') ?>"><?php echo date('d') ?>. <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="h" data-tag-value="<?php echo date('H') ?>"><?php echo date('H') ?> Std. <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="i" data-tag-value="<?php echo date('i') ?>"><?php echo date('i') ?> Min. <i class="glyphicon glyphicon-remove"></i></button>
                </div>
                <div id="tag-chooser-tags">
                    <hr />
                    <div class="tag-chooser-group">
                        <h4>Jahr</h4>
                        <?php
                        sort($content['y']);
                        foreach($content['y'] as $year) {
                        ?>
                        <button class="btn btn-primary" data-tag-key="y" data-tag-value="<?php echo $year ?>"><?php echo $year ?></button>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tag-chooser-group">
                        <h4>Monat</h4>
                        <?php
                        sort($content['m']);
                        foreach($content['m'] as $month) {
                        ?>
                        <button class="btn btn-primary" data-tag-key="m" data-tag-value="<?php echo $month ?>"><?php echo $months[$month - 1] ?></button>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tag-chooser-group">
                        <h4>Tag</h4>
                        <?php
                        sort($content['d']);
                        foreach($content['d'] as $day) {
                        ?>
                        <button class="btn btn-primary" data-tag-key="d" data-tag-value="<?php echo $day ?>"><?php echo $day ?>.</button>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tag-chooser-group">
                        <h4>Stunde</h4>
                        <?php
                        sort($content['h']);
                        foreach($content['h'] as $hour) {
                        ?>
                        <button class="btn btn-primary" data-tag-key="h" data-tag-value="<?php echo $hour ?>"><?php echo $hour ?> Std.</button>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="tag-chooser-group">
                        <h4>Minute</h4>
                        <?php
                        sort($content['i']);
                        foreach($content['i'] as $minute) {
                        ?>
                        <button class="btn btn-primary" data-tag-key="i" data-tag-value="<?php echo $minute ?>"><?php echo $minute ?> Min.</button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="tag-chooser-results-container">
                    <hr />
                    <h4>Gefundene Bilder</h4>
                    <div id="tag-chooser-results"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
	include "include/footer.php" 
?>

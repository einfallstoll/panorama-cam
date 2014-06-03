<?php
	include "include/header.php" 
?>

<script>
$(function() {
    var tagChooser = $('#tag-chooser')
    , tagChooserChosen = tagChooser.find('#tag-chooser-chosen')
    , tagChooserTags = tagChooser.find('#tag-chooser-tags')
    , tagChooserResults = tagChooser.find('#tag-chooser-results')
    
    // this will update the search results
    var tagUpdate = function() {
        var data = {}
        
        $(tagChooserChosen.find('button')).each(function() {
            if (typeof data[$(this).data('tag-key')] === 'undefined') {
                data[$(this).data('tag-key')] = []
            }
            
            data[$(this).data('tag-key')].push($(this).data('tag-value'))
        })
        
        $.post('filter.php', data).done(function(data) {
            if (data.length === 0) {
                tagChooserResults.html('<i>Keine Resultate gefunden.</i>')
            } else {
                tagChooserResults.html(data)
            }
        })
    }
    
    // this will append a new filter and disabled the clicked one
    var tagChoose = function() {    
        if (tagChooserChosen.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']').length === 0) {
            $(this).clone().append(' <i class="glyphicon glyphicon-remove"></i>').appendTo(tagChooserChosen.append(' '))
        }
        
        $(this).addClass('disabled')
        
        tagUpdate()
    }
    
    tagChooserTags.on('click', 'button', tagChoose)
    
    // this will remove the filter and enable the previously disabled
    var tagUnchoose = function() {
        $(tagChooserTags.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']')).removeClass('disabled')
        $(this).remove()
        
        tagUpdate()
    }
    
    tagChooserChosen.on('click', 'button', tagUnchoose)
    
    // click all the pre-selected
    tagChooserChosen.find('button').each(function() {
        var chosenTag = tagChooserTags.find('button[data-tag-key=' + $(this).data('tag-key') + '][data-tag-value=' + $(this).data('tag-value') + ']')
        
        if (chosenTag.length > 0) {
            $(chosenTag).trigger('click')
        }
    })
})
</script>

<?php

// order for the structuring levels
$order = array('y', 'm', 'd', 'h');

// here will the sorted levels be
$content = array('y' => array(), 'm' => array(), 'd' => array(), 'h' => array());

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
                    <button class="btn btn-primary" data-tag-key="h" data-tag-value="<?php echo date('H') ?>"><?php echo date('H') ?> <i class="glyphicon glyphicon-remove"></i></button>
                </div>
                <div id="tag-chooser-tags">
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
                        <button class="btn btn-primary" data-tag-key="h" data-tag-value="<?php echo $hour ?>"><?php echo $hour ?></button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div id="tag-chooser-results-container">
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

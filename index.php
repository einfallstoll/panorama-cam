<?php
    //header.php contains pure html...
	include "include/header.php";
    include "lib/sort-pictures.php";
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="tag-chooser">
                <div id="tag-chooser-chosen" style="display: none">
                    <h4>Filter</h4>
                    <button class="btn btn-primary" data-tag-key="y" data-tag-value="<?php echo date('Y') ?>"><?php echo date('Y') ?> <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="m" data-tag-value="<?php echo date('m') ?>"><?php echo $months[date('m') - 1] ?> <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="d" data-tag-value="<?php echo date('d') ?>"><?php echo date('d') ?>. <i class="glyphicon glyphicon-remove"></i></button>
                    <button class="btn btn-primary" data-tag-key="h" data-tag-value="<?php echo date('H') ?>"><?php echo date('H') ?> Std. <i class="glyphicon glyphicon-remove"></i></button>
                </div>
                <div id="tag-chooser-tags" style="display: none">
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
                    <div id="tag-chooser-results"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    //footer.php contains pure html...
	include "include/footer.php" 
?>

<?php
    //header.php contains pure html...
    include "include/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
			<button class="btn btn-primary btn-block">Steuerung anfordern</button>
		</div>
	</div>
	<div class="row">
        <div class="col-xs-12">
			<hr />
		</div>
	</div>
	<div class="row">
        <div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled"><i class="glyphicon glyphicon-arrow-left"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled"><i class="glyphicon glyphicon-arrow-up"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled"><i class="glyphicon glyphicon-arrow-down"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled"><i class="glyphicon glyphicon-arrow-right"></i></button>
		</div>
	</div>
	<div class="row">
        <div class="col-xs-12">
			<hr />
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" width="480" height="320" target="rtsp://<?php echo isset($_REQUEST['ip']) ? $_REQUEST['ip'] : 'default' ?>/live.sdp" />
			<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab"></object>
        </div>
    </div>
</div>

<?php
    //footer.php contains pure html...
	include "include/footer.php" 
?>

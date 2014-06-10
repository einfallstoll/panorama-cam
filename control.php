<?php
    //header.php contains pure html...
    include "include/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" width="480" height="320" target="rtsp://<?php echo isset($_REQUEST['ip']) ? $_REQUEST['ip'] : 'default' ?>/live.sdp" />
			<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab"></object>
        </div>
    </div>
</div>

<?php
    //footer.php contains pure html...
	include "include/footer.php" 
?>

<?php
    //header.php contains pure html...
    include "include/header.php";
?>

<script>
    function uuid() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
        });
    }
    
    var my_uuid = uuid()
    
    $(function() {
        
        var failed = function() {
            $('#status').text('Verbindung verloren... Es wird versucht sie wiederherzustellen.')
        }
        
        setInterval(function() {
            $.post('/lib/get_permission_status.php', {
                uuid: my_uuid
            })
            .done(function(time) {
                if (time.length === 0) {
                    $('#status').text('Sie müssen die Steuerung zuerst anfordern.')
                    
                    $('#permission').removeClass('disabled')
                    $('button[data-direction]').addClass('disabled')
                } else if (time < 0) {
                    $('#status').text('Sie bekommen in ca. ' + time + ' Sek. die Steuerung der Kamera.')
                    
                    $('#permission').addClass('disabled')
                    $('button[data-direction]').removeClass('disabled')
                } else if (time > 0) {
                    $('#status').text('Sie haben noch ca. ' + time + ' Sek. Zeit, um die Kamera zu steuern.')
                    
                    $('#permission').addClass('disabled')
                    $('button[data-direction]').removeClass('disabled')
                } else if (time == 0) {
                    $('#status').text('Ihre Kamerazeit ist abgelaufen, aber kein anderen Benutzer hat eine Anfrage gestellt. Sie können weiterhin die Kamera steuern.')
                    
                    $('#permission').addClass('disabled')
                    $('button[data-direction]').removeClass('disabled')
                }
            })
            .fail(failed)
            
            $('#permission').click(function() {
                $.post('/lib/get_permission.php', {
                    uuid: my_uuid
                })
                .fail(failed)
            })
            
            $('button[data-direction]').click(function() {
                $.post('/lib/move_cam.php', {
                    uuid: my_uuid,
                    direction: $(this).data('direction')
                })
                .fail(failed)
            })
        }, 500)
    })
</script>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
			<button class="btn btn-primary btn-block disabled" id="permission">Steuerung anfordern</button>
		</div>
	</div>
	<div class="row">
        <div class="col-xs-12">
			<hr />
		</div>
	</div>
	<div class="row">
        <div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled" data-direction="left"><i class="glyphicon glyphicon-arrow-left"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled" data-direction="up"><i class="glyphicon glyphicon-arrow-up"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled" data-direction="down"><i class="glyphicon glyphicon-arrow-down"></i></button>
		</div>
		<div class="col-xs-3">
			<button class="btn btn-primary btn-block disabled" data-direction="right"><i class="glyphicon glyphicon-arrow-right"></i></button>
		</div>
	</div>
    <div class="row">
        <div class="col-xs-12">
			<hr />
		</div>
	</div>
    <div class="row">
        <div class="col-xs-12 text-center" id="status" style="color: #BBB">
            Verbindung wird hergestellt...
        </div>
    </div>
	<div class="row">
        <div class="col-xs-12 text-center">
			<hr />
            <embed type="application/x-vlc-plugin" pluginspage="http://www.videolan.org" width="480" height="320" target="rtsp://<?php echo isset($_REQUEST['ip']) ? $_REQUEST['ip'] : 'default' ?>/live.sdp" /><br>
			<object classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921" codebase="http://download.videolan.org/pub/videolan/vlc/last/win32/axvlc.cab"></object>
        </div>
    </div>
</div>

<?php
    //footer.php contains pure html...
	include "include/footer.php" 
?>

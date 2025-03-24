<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM subeler_bayiler_19541956  WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=bayiler");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Bayi Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=bayi_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="lokasyon" class="col-sm-3 control-label">Lokasyon</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="lokasyon" name="lokasyon" value="<?=$snc->lokasyon;?>" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="adres" class="col-sm-3 control-label">Adres</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="adres" name="adres" value="<?=$snc->adres;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="telefon" class="col-sm-3 control-label">Telefon</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="telefon" name="telefon" value="<?=$snc->telefon;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="gsm" class="col-sm-3 control-label">GSM</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="gsm" name="gsm" value="<?=$snc->gsm;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="email" class="col-sm-3 control-label">E-Posta</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="email" name="email" value="<?=$snc->email;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="google_maps" class="col-sm-3 control-label">Google Haritası Ekle</label>
                                            <div class="col-sm-9">
											<script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key=AIzaSyAwyu2l9Pq7A0iBRv-jsbTCe6y2DTzkavM" type="text/javascript"></script>
	<script type="text/javascript">
		function initialize() {
			if (GBrowserIsCompatible()) {
				var hrt = new GMap2(document.getElementById("hrt"));
				hrt.addControl(new GMapTypeControl(1));
				hrt.addControl(new GLargeMapControl());
				hrt.enableContinuousZoom();
				hrt.enableDoubleClickZoom();
				var coords = new GLatLng(<?=$snc->maps;?>);
				hrt.setCenter(coords, 15);
				var im = new GMarker(coords, {draggable: true});
				GEvent.addListener(im, "drag", function(){
				document.getElementById("coords").value = im.getPoint().toUrlValue();
				});
				hrt.addOverlay(im);
			}
		}
		window.onload = function(){initialize();}
	</script> 

    <div id="hrt" style="width: 100%; height: 300px"></div>
	<input type="text" id="coords" name="google_maps" value="<?=$snc->google_maps;?>" style="display:none;" />
                                        </div>
                                        </div>
										
										
										
                                        
									<div align="right">
                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('forms','form_status');">Kaydet</button>
                                    </div>
									
									</form>
									
									
									
                                </div>
                            </div>
                        </div>
						<!-- Col1 end -->
						
						</div><!-- row end -->
						
                        
						 
						
					
                    
                    
                    
                    
                    
                </div>
            </div>

        </div>

    </div>
    <script>
        var resizefunc = [];
    </script>
	<script src="assets/js/admin.min.js"></script>
	<link href="assets/plugins/notifications/notification.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css">
    <link href="assets/vendor/summernote/dist/summernote.css" rel="stylesheet">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script src="assets/vendor/summernote/dist/summernote.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            $('.wysihtml5').wysihtml5();

            $('.summernote').summernote({
                height: 200, // set editor height

                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor

                focus: true // set focus to editable area after initializing summernote
            });

        });
    </script>
	
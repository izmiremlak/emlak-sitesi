<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM abloklar WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=abloklar");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Servis Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=ablok_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        
										
										<div class="form-group">
                                            <label for="baslik" class="col-sm-3 control-label">Başlık:</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="baslik" name="baslik" value="<?=$snc->baslik;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra:</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="url" class="col-sm-3 control-label">Var ise URL Adresi:</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="url" name="url" value="<?=$snc->url;?>" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                         <label for="icon" class="col-sm-3 control-label">Font Avesome / Ion Icons Icons Kodu:</label>
                                         <div class="col-sm-9">
										 <textarea class="form-control" rows="1" id="icon" name="icon"><?=$snc->icon;?></textarea>
                                         </div>
                                         </div>
										 
										 <div class="form-group">
                                            <label for="resim" class="col-sm-3 control-label">Veya Görsel Icon:</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="">
											<? echo ($snc->resim != '') ? '<img src="../uploads/thumb/'.$snc->resim.'" id="resim_src" width="150" />' : ''; ?>
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['abloklar']['orjin_x']; ?> x <?=$gorsel_boyutlari['abloklar']['orjin_y']; ?> px olmalıdır.</p>
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                         <label for="aciklama" class="col-sm-3 control-label">Açıklama:</label>
                                         <div class="col-sm-9">
										 <textarea class="form-control" rows="3" id="aciklama" name="aciklama"><?=$snc->aciklama;?></textarea>
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
	
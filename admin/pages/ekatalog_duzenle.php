<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM ekatalog WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=ekatalog");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Katalog Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=ekatalog_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="baslik" class="col-sm-3 control-label">Başlık</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="baslik" name="baslik" value="<?=$snc->baslik;?>" placeholder="Slayt Başlığı Yazın">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra Nosu</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="Slayt Sıra Nosu Yazın">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="resim" class="col-sm-3 control-label">Listeleme Görseli</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="">
											<? echo ($snc->resim != '') ? '<img src="../uploads/thumb/'.$snc->resim.'" id="resim_src" width="150" />' : ''; ?>
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['ekatalog']['thumb_x']; ?> x <?=$gorsel_boyutlari['ekatalog']['thumb_y']; ?> px olmalıdır.</p>
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="dosya" class="col-sm-3 control-label">Dosya</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="dosya" name="dosya" value="" >
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Dosyayı indirmek için <a href="../<?=$snc->link;?>">tıklayın.</a></p>
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
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
	
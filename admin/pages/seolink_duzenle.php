<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM referanslar_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=seolinkler");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Seo Link Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=seolink_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="adi" class="col-sm-3 control-label">Başlık</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="adi" name="adi" value="<?=$snc->adi;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group" style="display:none">
                                            <label for="kategori_id" class="col-sm-3 control-label">Kategori</label>
                                            
											<div class="col-sm-9">
											
											<select class="form-control" name="kategori_id" id="kategori_id">
											<option value="">Yok</option>
											<?php
											$kats		= $db->query("SELECT * FROM kategoriler_19541956 WHERE tipi=3 AND dil='".$dil."' ORDER BY sira ASC");
											while($kat	= $kats->fetch(PDO::FETCH_OBJ)){
											?>
											<option value="<?=$kat->id;?>" <?=($kat->id == $snc->kategori_id) ? 'selected' : ''; ?>><?=$kat->baslik;?></option>
											<?
											}
											?>
											</select>
											</div>
											
                                        </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra No</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="website" class="col-sm-3 control-label">Link</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="website" name="website" value="<?=$snc->website;?>" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group" style="display:none">
                                            <label for="resim" class="col-sm-3 control-label">Resim</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="">
											<? echo ($snc->resim != '') ? '<img src="../uploads/thumb/'.$snc->resim.'" id="resim_src" width="150" />' : ''; ?>
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['referanslar']['thumb_x']; ?> x <?=$gorsel_boyutlari['referanslar']['thumb_y']; ?> px olmalıdır.</p>
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
	
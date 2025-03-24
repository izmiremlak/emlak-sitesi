            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Yeni Video Galeri Ekle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=video_galeri_ekle" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="baslik" class="col-sm-3 control-label">Başlık</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="baslik" name="baslik" value="" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="kategori_id" class="col-sm-3 control-label">Kategori</label>
                                            
											<div class="col-sm-9">
											
											<select class="form-control" name="kategori_id" id="kategori_id">
											<option value="">Yok</option>
											<?php
											$kats		= $db->query("SELECT * FROM kategoriler_19541956 WHERE tipi=2 AND dil='".$dil."' ORDER BY sira ASC");
											while($kat	= $kats->fetch(PDO::FETCH_OBJ)){
											?>
											<option value="<?=$kat->id;?>"><?=$kat->baslik;?></option>
											<?
											}
											?>
											</select>
											</div>
											
                                        </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="youtube" class="col-sm-3 control-label">Youtube Video URL</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="youtube" name="youtube" value="" placeholder="Örn: https://www.youtube.com/watch?v=EO_vhggvUCE">
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
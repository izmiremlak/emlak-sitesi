            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Yeni Şehir Ekle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=sehir_ekle" onsubmit="return false;" enctype="multipart/form-data">
                                        
										
										<?php
										$ulkeler	= $db->query("SELECT * FROM ulkeler_19541956 ORDER BY id ASC");
										$ulkelerc	= $ulkeler->rowCount();
										if($ulkelerc>1){
										?>
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Ülke <span style="color:red">*</span></label>
                                            <div class="col-sm-9">
										<select id="ulke_id" name="ulke_id" class="form-control"  onchange="ajaxHere('ajax.php?p=il_getir&ulke_id='+this.options[this.selectedIndex].value,'il');yazdir();">
										<option value="">Seçiniz</option>
										<?php
										while($row	= $ulkeler->fetch(PDO::FETCH_OBJ)){
										?><option value="<?=$row->id;?>"><?=$row->ulke_adi;?></option><?
										}
										?>
										</select>
                                        </div>
                                        </div>
										<?}?>
										
										
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">İl</label>
                                            <div class="col-sm-9">
										<select name="il" id="il" class="form-control"  onchange="ajaxHere('ajax.php?p=ilce_getir&il_id='+this.options[this.selectedIndex].value,'ilce');">
										<option value="">Seçiniz</option>
										<?php
										if($ulkelerc<2){
										$ulke		= $ulkeler->fetch(PDO::FETCH_OBJ);
										$sql		= $db->query("SELECT id,il_adi FROM il WHERE ulke_id=".$ulke->id." ORDER BY id ASC");
										while($row	= $sql->fetch(PDO::FETCH_OBJ)){
										?><option value="<?=$row->id;?>"><?=$row->il_adi;?></option><?
										}
										}
										?>
										</select>
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-sm-3 control-label">İlçe</label>
                                            <div class="col-sm-9">
										<select name="ilce" id="ilce" class="form-control"  onchange="ajaxHere('ajax.php?p=mahalle_getir&ilce_id='+this.options[this.selectedIndex].value,'mahalle');">
										<option value="">Seçiniz</option>
										<?php
										if($snc->il_id != ''){
										$sql		= $db->query("SELECT id,ilce_adi FROM ilce WHERE il_id=".$ilan->il_id." ORDER BY id ASC");
										while($row	= $sql->fetch(PDO::FETCH_OBJ)){
										?><option value="<?=$row->id;?>" <?=($row->id == $ilan->ilce_id) ? 'selected' : '';?>><?=$row->ilce_adi;?></option><?
										}
										}
										?>
										</select>
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Mahalle</label>
                                            <div class="col-sm-9">
										<select name="mahalle" id="mahalle" class="form-control">
										<option value="">Seçiniz</option>
										</select>
                                        </div>
                                        </div>
										
									
									
									<div class="form-group">
                                         <label for="permalink" class="col-sm-3 control-label">Emlak Durumu</label>
                                         <div class="col-sm-9">
										 
										 <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio3" value="satilik" name="emlak_durum">
                                        <label for="inlineRadio3">Satılık</label>
										</div>
										<div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio4" value="kiralik" name="emlak_durum" >
                                        <label for="inlineRadio4">Kiralık</label>
										</div>
										<div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio5" value="gunluk_kiralik" name="emlak_durum" >
                                        <label for="inlineRadio5">Günlük Kiralık</label>
										</div>
                                         </div>
                                    </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra No</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="" placeholder="">
                                        </div>
                                        </div>
										
										
										
										
										<div class="form-group">
                                            <label for="resim" class="col-sm-3 control-label">Arkaplan Görsel</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="" >
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['sehirler']['orjin_x']; ?> x <?=$gorsel_boyutlari['sehirler']['orjin_y']; ?> px olmalıdır.</p>
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
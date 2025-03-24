<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM sehirler_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=sehirler");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Şehir Blok Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=sehir_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        
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
										?><option value="<?=$row->id;?>" <?=($snc->ulke_id == $row->id) ? 'selected' : '';?>><?=$row->ulke_adi;?></option><?
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
										}else{
										$sql		= $db->query("SELECT id,il_adi FROM il WHERE ulke_id=".$snc->ulke_id." ORDER BY id ASC");
										}
										while($row	= $sql->fetch(PDO::FETCH_OBJ)){
										if($row->id == $snc->il){
										$il_adi		= $row->il_adi;
										}
										?><option value="<?=$row->id;?>" <?=($row->id == $snc->il) ? 'selected' : '';?>><?=$row->il_adi;?></option><?
										}
										?>
										</select>
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-sm-3 control-label">İlçe</label>
                                            <div class="col-sm-9">
										<select name="ilce" id="ilce" class="form-control" onchange="ajaxHere('ajax.php?p=mahalle_getir&ilce_id='+this.options[this.selectedIndex].value,'mahalle');">
										<option value="">Seçiniz</option>
										<?php
										if($snc->il != 0){
										$sql		= $db->query("SELECT id,ilce_adi FROM ilce WHERE il_id=".$snc->il." ORDER BY id ASC");
										while($row	= $sql->fetch(PDO::FETCH_OBJ)){
										?><option value="<?=$row->id;?>" <?=($row->id == $snc->ilce) ? 'selected' : '';?>><?=$row->ilce_adi;?></option><?
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
										<?php
										if($snc->mahalle != 0 || $snc->ilce != 0){
										
										if($snc->ilce==0 && $snc->mahalle != 0){
										$ilcene		= $db->query("SELECT ilce_id,id FROM mahalle_koy WHERE id=".$snc->mahalle);
										if($ilcene->rowCount()>0){
										$ilcene		= $ilcene->fetch(PDO::FETCH_OBJ)->ilce_id;
										}
										}elseif($snc->ilce !=0){
										$ilcene	= $snc->ilce;
										}else{
										$ilcene	= 0;
										}
										
										if($ilcene != 0){
										$semtler	= $db->query("SELECT * FROM semt WHERE ilce_id=".$ilcene);
										if($semtler->rowCount()>0){
										while($srow	= $semtler->fetch(PDO::FETCH_OBJ)){
										$mahalleler	= $db->query("SELECT * FROM mahalle_koy WHERE semt_id=".$srow->id." AND ilce_id=".$ilcene." ORDER BY mahalle_adi ASC");
										if($mahalleler->rowCount()>0){
										?><optgroup label="<?=$srow->semt_adi;?>"><?
										while($row	= $mahalleler->fetch(PDO::FETCH_OBJ)){
										if($snc->mahalle == $row->id){
										$mahalle_adi = $row->mahalle_adi;
										}
										?><option value="<?=$row->id;?>" <?=($snc->mahalle == $row->id) ? 'selected' : '';?>><?=$row->mahalle_adi;?></option><?
										}
										}
										?></optgroup><?
										}
										}else{
										$mahalleler	= $db->query("SELECT * FROM mahalle_koy WHERE ilce_id=".$ilcene." ORDER BY mahalle_adi ASC");
										while($row	= $mahalleler->fetch(PDO::FETCH_OBJ)){
										if($snc->mahalle == $row->id){
										$mahalle_adi = $row->mahalle_adi;
										}
										?><option value="<?=$row->id;?>" <?=($snc->mahalle == $row->id) ? 'selected' : '';?>><?=$row->mahalle_adi;?></option><?
										}
										}
										}
										}
										?>
										</select>
                                        </div>
                                        </div>
										
									
									
									<div class="form-group">
                                         <label for="permalink" class="col-sm-3 control-label">Emlak Durumu</label>
                                         <div class="col-sm-9">
										 
										 <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio3" value="satilik" name="emlak_durum" <?=($snc->emlak_durum == 'satilik') ? 'checked' : '';?>>
                                        <label for="inlineRadio3">Satılık</label>
										</div>
										<div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio4" value="kiralik" name="emlak_durum" <?=($snc->emlak_durum == 'kiralik') ? 'checked' : '';?>>
                                        <label for="inlineRadio4">Kiralık</label>
										</div>
										<div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio5" value="gunluk_kiralik" name="emlak_durum" <?=($snc->emlak_durum == 'gunluk_kiralik') ? 'checked' : '';?>>
                                        <label for="inlineRadio5">Günlük Kiralık</label>
										</div>
                                         </div>
                                    </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra No</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="">
                                        </div>
                                        </div>
										
										
										
										
										<div class="form-group">
                                            <label for="resim" class="col-sm-3 control-label">Arkaplan Görsel</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="" >
											<? echo ($snc->resim != '') ? '<img src="../uploads/'.$snc->resim.'" id="resim_src" weight="'.$gorsel_boyutlari['sehirler']['orjin_y'].'" height="'.$gorsel_boyutlari['sehirler']['orjin_x'].'" />' : ''; ?>
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
	
<?php
$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM uyelik_paketleri_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
header("Location:index.php?p=uyelik_paketleri");
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Paket Düzenle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=uyelikp_duzenle&id=<?=$snc->id;?>" onsubmit="return false;" enctype="multipart/form-data">
                                    
									<div class="form-group">
									<label for="baslik" class="col-sm-3 control-label">Başlık</label>
									<div class="col-sm-9">
									<input type="text" class="form-control" id="baslik" name="baslik" value="<?=$snc->baslik;?>" placeholder="">
									</div>
									</div>
									
									<div class="form-group">
									<label for="sira" class="col-sm-3 control-label">Sıra No</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" id="sira" name="sira" value="<?=$snc->sira;?>" placeholder="">
									</div>
									</div>
									
									<div class="form-group">
									<label for="renk" class="col-sm-3 control-label">Renk</label>
									<div class="col-sm-2">
									
										<div class="cp2 input-group colorpicker-component">
										<input name="renk" type="text" value="<?=$snc->renk;?>" class="form-control" />
										<span class="input-group-addon"><i></i></span></div>
	
									</div>
									</div>
									
									<div class="form-group">
                                            <label class="col-sm-3 control-label">Listeden Gizle</label>
                                            <div class="col-sm-9">
											<div class="checkbox checkbox-success">
                                            <input id="gizle" type="checkbox" name="gizle" value="1"<?=($snc->gizle==1) ? " checked" : '';?>>
                                            <label for="gizle"><STRONG>Gizle</STRONG> </label> <span style="font-size:14px;"> </span>
                                        </div>
                                       
                                        </div>
									</div>
									
									<div class="form-group" id="gizle_con" <?=($snc->gizle==0) ? 'style="display:none"' : '';?>>
									<label  class="col-sm-3 control-label">Satın Alma Linki</label>
									<div class="col-sm-9">
									<span style="display:block;margin-top:7px;"><?=SITE_URL."uyelik-paketi-satinal?id=".$snc->id."&periyod=0";?></span>
									</div>
									</div>
									
									
									<div class="form-group">
									<label for="aylik_ilan_limit" class="col-sm-3 control-label">Aylık İlan Ekleme Limiti</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" id="aylik_ilan_limit" name="aylik_ilan_limit" value="<?=$snc->aylik_ilan_limit;?>" placeholder="">
                                    </div><span style="font-size:14px;">Sınırsız/Limitsiz için 0 yazınız.</span>
									</div>
									
									<div class="form-group">
									<label for="ilan_resim_limit" class="col-sm-3 control-label">İlana Resim Ekleme Limiti</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" id="ilan_resim_limit" name="ilan_resim_limit" value="<?=$snc->ilan_resim_limit;?>" placeholder="">
									</div><span style="font-size:14px;">Sınırsız/Limitsiz için 0 yazınız.</span>
									</div>
									
									<div class="form-group">
									<label for="danisman_limit" class="col-sm-3 control-label">Danışman Ekleme Limiti</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" id="danisman_limit" name="danisman_limit" value="<?=$snc->danisman_limit;?>" placeholder="">
									</div><span style="font-size:14px;">Sınırsız/Limitsiz için 0 yazınız.</span>
									</div>
									
									<div class="form-group">
                                            <label class="col-sm-3 control-label">Anasayfa Danışman Hediyesi</label>
                                            <div class="col-sm-9">
											<div class="checkbox checkbox-success">
                                            <input id="danisman_onecikar" type="checkbox" name="danisman_onecikar" value="1"<?=($snc->danisman_onecikar == 1) ? " checked" : '';?>>
                                            <label for="danisman_onecikar"><STRONG>Evet</STRONG> </label> <span style="font-size:14px;"> </span>
                                        </div>
                                       
                                        </div>
									</div>
									
									<div class="form-group" id="danisman_onecikar_con" <?=($snc->danisman_onecikar==0) ? 'style="display:none"' : '';?>>
									<label class="col-sm-3 control-label">Anasayfada Gösterme Süresi</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" id="danisman_onecikar_sure" name="danisman_onecikar_sure" value="<?=$snc->danisman_onecikar_sure;?>" placeholder="">
									</div>
									<div class="col-sm-2">
									<select class="form-control" name="danisman_onecikar_periyod">
									<?php
									foreach($periyod AS $k=>$v){
									?><option value="<?=$k;?>"<?=($snc->danisman_onecikar_periyod == $k) ? " selected" : '';?>><?=$v;?></option><?
									}
									?>
									</select>
									</div>
									</div>
									
									
									<div class="form-group">
									<label class="col-sm-3 control-label">İlan Yayında Kalma Süresi</label>
									<div class="col-sm-1">
									<input type="text" class="form-control" name="ilan_yayin_sure" value="<?=$snc->ilan_yayin_sure;?>" placeholder="">
									</div>
									<div class="col-sm-2">
									<select class="form-control" name="ilan_yayin_periyod">
									<?php
									foreach($periyod AS $k=>$v){
									?><option value="<?=$k;?>"<?=($snc->ilan_yayin_periyod == $k) ? " selected" : '';?>><?=$v;?></option><?
									}
									?>
									</select>
									</div>
									</div>
									
									<div class="form-group">
									<label class="col-sm-3 control-label">Ücretlendirme Periyodu</label>
									<div class="col-sm-9">
									
									<div id="kapsayici">
									<?php
									if($snc->ucretler != ''){
									$ucretler	= json_decode($snc->ucretler,true);
									foreach($ucretler as $periyode){
									?>
									<div class="row ucret"><div class="col-sm-2"><input type="text" class="form-control" name="sure[]" value="<?=$periyode["sure"];?>" placeholder="Süre"></div><div class="col-sm-2"><select class="form-control" name="periyod[]"><?php foreach($periyod AS $k=>$v){?><option value="<?=$k;?>"<?=($periyode["periyod"] == $k) ? " selected" : '';?>><?=$v;?></option><?}?></select></div><div class="col-sm-2"><input type="text" name="tutar[]" value="<?=$gvn->para_str($periyode["tutar"]);?>" class="form-control" placeholder="Tutar"></div><div class="col-sm-1"><button type="button" class="ucret_sil btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div><!--row end -->
									<?}}?>
									
									</div><!--kapsayici end -->
									
									
									<div align="left" style="margin-top:5px;">
									<button type="button" class="btn btn-success waves-effect waves-light" onclick="UcretEkle();"><i class="fa fa-plus"></i> Periyod Ekle</button>
									</div>
									
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
    <link href="assets/vendor/summernote/dist/summernote.css" rel="stylesheet">
	<link href="assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
    <style>
    .colorpicker-2x .colorpicker-saturation {
        width: 200px;
        height: 200px;
    }
    
    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }
    
    .colorpicker-2x .colorpicker-color,
    .colorpicker-2x .colorpicker-color div {
        height: 30px;
    }
</style>
	<script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
    <script src="assets/vendor/summernote/dist/summernote.min.js"></script>
    <script src="assets/js/inputmask.js"></script>
	<script type="text/javascript" src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
    <script>
        jQuery(document).ready(function() {
            $('.summernote').summernote({
                height: 200, // set editor height

                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor

                focus: true, // set focus to editable area after initializing summernote
				onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);}
            });

        });
		
		//colorpicker start
		$(function() {
        $('.cp2').colorpicker({
            customClass: 'colorpicker-2x',
            sliders: {
                saturation: {
                    maxLeft: 200,
                    maxTop: 200
                },
                hue: {
                    maxTop: 200
                },
                alpha: {
                    maxTop: 200
                }
            }
        });
    });
	
	function UcretEkle(){
	$("#kapsayici").append('<div class="row ucret"><div class="col-sm-2"><input type="text" class="form-control" name="sure[]" value="" placeholder="Süre"></div><div class="col-sm-2"><select class="form-control" name="periyod[]"><?php foreach($periyod AS $k=>$v){?><option value="<?=$k;?>"><?=$v;?></option><?}?></select></div><div class="col-sm-2"><input type="text" name="tutar[]" value="" class="form-control" placeholder="Tutar"></div><div class="col-sm-1"><button type="button" class="ucret_sil btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fa fa-trash" aria-hidden="true"></i></button></div></div>');
	}
	
	$(document).ready(function(){
	
	$("#kapsayici").on('click','.ucret_sil',function(){
	var parent = $(this).parents(".ucret");
	parent.remove();
	});
	
	});
	
	$(document).ready(function(){
	
	$("#danisman_onecikar").change(function(){
	var durum = $(this).prop("checked");
	if(durum){
	$("#danisman_onecikar_con").slideDown(400);
	$("#danisman_onecikar_sure").focus();
	}else{
	$("#danisman_onecikar_con").slideUp(400);
	}
	});
	
	$("#gizle").change(function(){
	var durum = $(this).prop("checked");
	if(durum){
	$("#gizle_con").slideDown(400);
	}else{
	$("#gizle_con").slideUp(400);
	}
	});
	
	});
    </script>
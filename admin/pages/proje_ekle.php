            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Yeni Proje Ekle</h4>

                        </div>
                    </div>



							
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=proje_ekle" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="baslik" class="col-sm-3 control-label">Başlık</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="baslik" name="baslik" value="" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Danışman</label>
                                            <div class="col-sm-9">
											<select class="form-control" name="danisman_id">
											<option value="0">Yok</option>
											<?php
											$sql		= $db->query("SELECT id,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND tipi=0 AND turu=2 ORDER BY id DESC");
											while($row	= $sql->fetch(PDO::FETCH_OBJ)){
											?><option value="<?=$row->id;?>"><?=$row->adsoyad;?></option><?
											}
											
											$sql		= $db->query("SELECT * FROM danismanlar_19541956 ORDER BY id ASC");
											while($row	= $sql->fetch(PDO::FETCH_OBJ)){
											?><option value="<?=$row->id;?>"><?=$row->adsoyad;?></option><?
											}
											?>
											</select>
                                        </div>
                                        </div>
										
										
										<div class="form-group" style="display:none">
                                            <label for="kisa_icerik" class="col-sm-3 control-label">Kısa Açıklama</label>
                                            <div class="col-sm-9">
                                            <textarea rows="5" class="form-control" id="kisa_icerik" name="kisa_icerik"></textarea>
                                        </div>
                                        </div>
										
										<div class="form-group" style="display:none">
                                            <label class="col-sm-3 control-label">Türü</label>
                                            <div class="col-sm-9">
											<select class="form-control" name="turu">
											<option value="0">Devam Eden Projeler</option>
											<option value="1">Tamamlanan Projeler</option>
											</select>
                                        </div>
                                        </div>
										
										
										<div class="form-group" style="display:none">
                                         <label for="permalink" class="col-sm-3 control-label">Öne Çıkan Proje:</label>
                                         <div class="col-sm-9">
										 
										 <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="1" name="onecikan">
                                        <label for="inlineRadio1">Evet</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio2" value="0" name="onecikan" >
                                        <label for="inlineRadio2">Hayır</label>
                                    </div>
									
										
                                         </div>
                                    </div>
									
									
									
									
										<div class="form-group">
                                            <label for="resim" class="col-sm-3 control-label">Listeleme Görseli</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim" name="resim" value="" >
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['projeler']['resim1']['thumb_x']; ?> x <?=$gorsel_boyutlari['projeler']['resim1']['thumb_y']; ?> px olmalıdır.</p>
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="resim2" class="col-sm-3 control-label">Arkaplan Görseli</label>
                                            <div class="col-sm-9">
											<input type="file" class="form-control" id="resim2" name="resim2" value="">
											<p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['projeler']['resim2']['orjin_x']; ?> x <?=$gorsel_boyutlari['projeler']['resim2']['orjin_y']; ?> px olmalıdır.</p>
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="icerik" class="col-sm-1 control-label">İçerik</label>
                                            <div class="col-sm-11">
											<textarea class="summernote form-control" rows="9" id="icerik" name="icerik"></textarea>
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="maps" class="col-sm-3 control-label">Google Maps Harita Url</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="maps" name="maps" value="" >
                                        </div>
                                        </div>
										
										
										
										<?=$fonk->bilgi(" Google'da rekabeti düşük kelimelerde organik olarak ilk sayfaya yükselmek için mutlaka aşağıdaki bilgileri doldurunuz. Sadece sayfa içeriği ile alakalı bilgiler girmelisiniz. Aksi halde spam cezası alabilirsiniz."); ?>	

										
										
										<div class="form-group">
                                            <label for="title" class="col-sm-3 control-label">SEO Başlık (Title)</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="title" name="title" value="" >
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="keywords" class="col-sm-3 control-label">SEO Kelimeler (Keywords)</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="keywords" name="keywords" value="" >
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                         <label for="description" class="col-sm-3 control-label">SEO Açıklama (Description)</label>
                                         <div class="col-sm-9">
										 <textarea class="form-control" rows="5" id="description" name="description"></textarea>
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
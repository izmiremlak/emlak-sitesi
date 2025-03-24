<?php
$ua			= $fonk->UyelikAyarlar();
$bireysel	= $ua["bireysel_uyelik"];
$kurumsal	= $ua["kurumsal_uyelik"];
?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Standart Üyelik Ayarları</h4>

                        </div>
                    </div>
					
                    <div class="row">
                    
                    <style>
                    .standartuyeliktable tr td {padding:10px;border-bottom:1px solid #eee;border-right:1px solid #eee;}
                    .standartuyeliktable tr th {padding:10px;border-bottom:1px solid #eee;border-right:1px solid #eee;}
                    .standartuyeliktable input {width:100px;float:left;}
                    .standartuyeliktable select {width:100px;float:left;margin-left:5px;}
                    </style>
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                
                                <div class="alert alert-info" role="alert">Ücretsiz üyeler için olması gereken standart limitleri tanımlayabilirsiniz. Bu limitleri dolduran üyeler, hiçbir şekilde kullanım yapmaya devam edemezler. Limitlerini dolduran kullanıcılar için uyarı mesajı verilecek daha yüksek bir üyelik paketine geçmesi gerektiği mesajı gösterilir.</div>
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=uyelik_ayarlari" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <table class="standartuyeliktable" width="100%" border="0" cellpadding="0" cellspacing="0">
										<thead>
										<tr>
										<th></th>
										<th>Bireysel Üyelik</th>
										<th>Kurumsal Üyelik</th>
										</tr>
										</thead>
										
										<tbody>
										<tr>
										<th>Aylık İlan Ekleme Limiti</th>
										<td><input type="text" class="form-control" name="bireysel_uyelik[aylik_ilan_limit]" value="<?=$bireysel["aylik_ilan_limit"];?>"></td>
										<td><input type="text" class="form-control" name="kurumsal_uyelik[aylik_ilan_limit]" value="<?=$kurumsal["aylik_ilan_limit"];?>"></td>
										</tr>
										
										<tr>
										<th>İlana Resim Ekleme Limiti</th>
										<td><input type="text" class="form-control" name="bireysel_uyelik[ilan_resim_limit]" value="<?=$bireysel["ilan_resim_limit"];?>"></td>
										<td><input type="text" class="form-control" name="kurumsal_uyelik[ilan_resim_limit]" value="<?=$kurumsal["ilan_resim_limit"];?>"></td>
										</tr>
										
										<tr>
										<th>İlan Yayında Kalma Süresi</th>
										<td>
										<input type="text" class="form-control" name="bireysel_uyelik[ilan_yayin_sure]" value="<?=$bireysel["ilan_yayin_sure"];?>">
										<select class="form-control" name="bireysel_uyelik[ilan_yayin_periyod]">
										<?php
										foreach($periyod as $k=>$v){
										?><option value="<?=$k;?>"<?=($bireysel["ilan_yayin_periyod"] == $k) ? " selected" : '';?>><?=$v;?></option><?
										}
										?>
										</select>
										</td>
										<td>
										<input type="text" class="form-control" name="kurumsal_uyelik[ilan_yayin_sure]" value="<?=$kurumsal["ilan_yayin_sure"];?>">
										<select class="form-control" name="kurumsal_uyelik[ilan_yayin_periyod]">
										<?php
										foreach($periyod as $k=>$v){
										?><option value="<?=$k;?>"<?=($kurumsal["ilan_yayin_periyod"] == $k) ? " selected" : '';?>><?=$v;?></option><?
										}
										?>
										</select>
										</td>
										</tr>
										
										<tr>
										<th>Danışman Ekleme Limiti</th>
										<td>Danışman Ekleyemez.</td>
										<td><input type="text" class="form-control" name="kurumsal_uyelik[danisman_limit]" value="<?=$kurumsal["danisman_limit"];?>"></td>
										</tr>
										
										
										</tbody>
										</table>
										
                                        
										
										<br>
										
									<div align="right">
                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('forms','form_status');">Güncelle</button>
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

                focus: true, // set focus to editable area after initializing summernote
				onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);}
            });

        });
    </script>
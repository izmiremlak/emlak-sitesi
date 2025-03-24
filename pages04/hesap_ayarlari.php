            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Hesap Ayarları</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Yönetici Hesap Bilgileri<br>( Nasıl dolduracağınız kutucukların içinde yazılıdır )</h3></div>
                                <div class="panel-body">
                                

<?if($hesap->email == 'info@izmirtr.com' AND $hesap->parola == '!izmirTR5678izmirTR?'){?>
<div class="panel panel-border panel-danger">
                                    <div class="panel-heading">
                                        <h3 style="height:30px;" class="panel-title"><span id="yanip-sonen"><i class="fa fa-exclamation" aria-hidden="true"></i> Lütfen Yönetici Bilgilerinizi Değiştiriniz <i class="fa fa-exclamation" aria-hidden="true"></i></span></h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <p>Kötü niyetli kişilerin admin panelinize erişerek sitenize zarar vermemesi için, standart olarak tanımlı gelen admin e-posta ve parola bilgilerinizi değiştirmeniz gerekmektedir. Bu işlem, sizin menfatinizi korumak amacıyla zorunlu tutulmuştur.</p> 
                                    </div> 
                                </div>
<?}?>


									<div id="hesap_status"></div>
                                    <form role="form" class="form-horizontal"  id="hesap_bilgi_form" method="POST" action="ajax.php?p=hesap_bilgileri" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="adi" class="col-sm-3 control-label">Firma Adı veya Adınız</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="adi" name="adi" value="<?=$hesap->adi;?>" placeholder="Buraya sayfamım sol üstünde logo nun yanında gözükecek İsmi yazınız - Firma Adınız veya Ad Soyadı ">
                                        </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label for="soyadi" class="col-sm-3 control-label">Soyadınız</label>
											<div class="col-sm-9">
                                            <input type="text" class="form-control" id="soyadi" name="soyadi" value="<?=$hesap->soyadi;?>" placeholder="İsminizi yazacaksanızı buraya Soyadınızı Yazın - Firma adı yazacaksanız boş bırakın">
                                        </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label for="email" class="col-sm-3 control-label">E-Posta</label>
											<div class="col-sm-9">
                                            <input type="text" class="form-control" id="email" name="email" value="<?=$hesap->email;?>" placeholder="Sitede kullandığınız E-postanızı Yazın">
                                        </div>
                                        </div>
                                        
                                      
                                      
                                        <div class="form-group">
                                            <label for="mparola" class="col-sm-3 control-label">Mevcut Parolanız</label>
                                           <div class="col-sm-9">
                                                <input type="password" class="form-control" id="mparola" name="mparola" placeholder="Parola yazılı değilse, İşlem yapmak için mevcut parolanızı yazmalısınız.">
                                           
                                        </div>
                                        </div>
										
                                        <div class="form-group m-l-10">
                                            <label for="yparola" class="col-sm-3 control-label">Yeni Parola Belirleyin</label>
											<div class="col-sm-9">
                                                <input type="password" class="form-control" id="yparola" name="yparola" placeholder="Parolanızı değiştirmek istiyorsanız yazınız. İstemiyorsanız Boş bırakın">
                                          
                                        </div>
                                        </div>
										
                                        <div class="form-group m-l-10">
                                            <label for="ytparola" class="col-sm-3 control-label">Yeni Parolayı Tekrar Girin</label>
                                          <div class="col-sm-9">
                                                <input type="password" class="form-control" id="ytparola" name="ytparola" placeholder="Yeni Parolanızı Tekrar Yazınız.">
                                         
                                        </div>
                                        </div>
                                      

                                        <div class="form-group">
                                            <label for="avatar" class="col-sm-3 control-label">Profil Fotoğrafı</label>
											<div class="col-sm-9">
                                            <input type="file" class="form-control" id="avatar" name="avatar">
                                            <span>(Aynı zamanda firma logosu olarak da kullanılabilir.)</span>
                                        </div>
                                        </div>
										
                                        

                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('hesap_bilgi_form','hesap_status');">Güncelle</button>
                                    </form>
									
									
									
                                </div>
                            </div>
                        </div>
						<!-- Col1 end -->
                        
						 
						<!-- col2 start 
                        <div class="col-md-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Parola Değiştir</h3></div>
                                <div class="panel-body">
                                    
                                    
									<div id="sifredegis_status"></div>
									
                                    <form role="form" class="form-horizontal" id="sifredegis_form" method="POST" action="ajax.php?p=sifredegis" onsubmit="return false;">
									
                                        <div class="form-group">
                                            <label for="mparola" class="col-sm-3 control-label">Mevcut Parola</label>
                                           <div class="col-sm-9">
                                                <input type="password" class="form-control" id="mparola" name="mparola" placeholder="Mevcut Parolanızı Yazın">
                                           
                                        </div>
                                        </div>
										
                                        <div class="form-group m-l-10">
                                            <label for="yparola" class="col-sm-3 control-label">Yeni Parola</label>
											<div class="col-sm-9">
                                                <input type="password" class="form-control" id="yparola" name="yparola" placeholder="Yeni Parolanızı Yazın">
                                          
                                        </div>
                                        </div>
										
                                        <div class="form-group m-l-10">
                                            <label for="ytparola" class="col-sm-3 control-label">Yeni Parola Tekrar</label>
                                          <div class="col-sm-9">
                                                <input type="password" class="form-control" id="ytparola" name="ytparola" placeholder="Yeni Parolanızı Tekrar Yazın">
                                         
                                        </div>
                                        </div>
                                        
										
										
                                        
                                                <button type="submit" class="btn btn-info waves-effect waves-light" onclick=" AjaxFormS('sifredegis_form','sifredegis_status');">Değiştir</button>
												
										
										
                                    </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <!-- col2 end -->
                        
                        
                        
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
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
	
    
    <script>
$(document).ready(function(){
  setInterval(function(){
	$("#yanip-sonen").fadeToggle(500);
  },700); //700 milisaniyede bir yanıp sönecek
});
</script>
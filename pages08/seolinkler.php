            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Seo Linkler</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                
                                
                                
                                
                                <div class="panel-group" id="accordion-test-2"> 
                    <div class="panel panel-pink panel-color"> 
                                        <div class="panel-heading"> 
                                            <h4 class="panel-title"> 
                                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="true" class="collapsed">
                                                    Açıklamalar ve Talimatlar
                                                </a> 
                                            </h4> 
                                        </div> 
                                        <div id="collapseOne-2" class="panel-collapse collapse" aria-expanded="true"> 
                                            <div class="panel-body">
                                            Google'da daha iyi pozisyonlarda bulunmak ve aramalarda ön sıralarda yer almak için, aşağıdaki alanlardan istediğiniz şekilde seo link ekleme yapabilirsiniz. Buraya ekleyeceğiniz linkler aynı zamanda <strong>sitemap.xml</strong>'ye de eklenmektedir. Url adresini elde etmek için, site tarafında bulunan, gelişmiş arama seçenekleri ile farklı varyasyonlar kullanarak adres satırındaki url yi kopyalabilirsiniz.<br><br>Silme işlemi için kutucukları boş bırakmanız yeterlidir.
                                            </div> 
                                        </div> 
                                    </div>
                     </div> 
                                
                                
                                
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=seolinkler" onsubmit="return false;" enctype="multipart/form-data">


<div id="lokasyonlar_list1">
<?php
$sql	 	= $db->query("SELECT * FROM referanslar_19541956 WHERE dil='".$dil."' ORDER BY sira ASC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?>
<input type="text" class="form-control" name="baslik[]" value="<?=$row->adi;?>" placeholder="Başlık" style="float:left;width:19%;margin-right:5px;margin-bottom:5px;">
<input type="text" class="form-control" name="link[]" value="<?=$row->website;?>" placeholder="URL Adresi" style="float:left;width:19%;margin-right:5px;margin-bottom:5px;">
<input type="text" class="form-control" name="sira[]" value="<?=$row->sira;?>" placeholder="Sıra" style="float:left;width:5%;margin-right:5px;margin-bottom:5px;">
<div style="clear:both;"></div>
<? } ?>
</div>




<script type="text/javascript">
function lokasyon_ekle1(){
$("#lokasyonlar_list1").append('<input type="text" class="form-control" name="baslik[]" value="" placeholder="Başlık" style="float:left;width:19%;margin-right:5px;margin-bottom:5px;"><input type="text" class="form-control" name="link[]" value="" placeholder="URL Adresi" style="float:left;width:19%;margin-right:5px;margin-bottom:5px;"><input type="text" class="form-control" name="sira[]" value="" placeholder="Sıra" style="float:left;width:5%;margin-right:5px;margin-bottom:5px;"><div style="clear:both;"></div>');
}
</script>


<button type="button" onclick="lokasyon_ekle1();" class="btn btn-default waves-effect m-b-5">+ Alan Ekle</button>

<div style="clear:both;"></div>


<br>






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

                focus: true, // set focus to editable area after initializing summernote
				onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);}
            });

        });
    </script>
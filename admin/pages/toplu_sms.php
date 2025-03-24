            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Toplu SMS Gönder</h4>

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
                                             Sitenizin en alt(footer) kısmında yer alan bülten alanından, eklenen GSM Numaralarını bu alanda görebilir ve Toplu SMS gönderebilirsiniz. Ayrıca "Gönderilecek Gsm Listesi" alanından kendinizde manuel olarak gsm numaraları ekleyebilirsiniz. (Fakat unutmayınız ki izinsiz sms göndermek suçtur ve herkesi rahatsız eder.)<br><br>

Toplu sms servisinin çalışabilmesi için "<B>Genel Ayarlar / SMS Ayarları</B>" sekmesinden gerekli yapılandırmaları yapmanız gerekmektedir. Ek olarak bu modülün çalışabilmesi için sisteme entegre edilmiş bir SMS Paketine ihtiyaç vardır. Aksi halde gönderim yapılamaz. Detaylı bilgi için sistem yönetinizle irtibat sağlayınız.                                        </div> 
                                        </div> 
                                    </div>
                     </div> 
                                

								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=toplu_sms" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                    	
									<div class="form-group">
                                         <label for="gonderilenler" class="col-sm-3 control-label">Gönderilecek GSM Listesi</label>
                                         <div class="col-sm-9">
										 <textarea class="form-control" rows="5" id="gonderilenler" name="gonderilenler"><?php
										 
										 $data1 	= $gayarlar->bulten_gsm;
										 $data1		= explode(",",$data1);
										 $data2		= array();
										 $data2ler	= $db->query("SELECT telefon FROM hesaplar WHERE site_id_555=999 AND tipi=0 AND sms_izin=1 AND telefon!='' ");
										 while($row	= $data2ler->fetch(PDO::FETCH_OBJ)){
										 $data2[]	= $row->telefon;
										 }
										 $datalar	= array_merge($data1,$data2);
										 $datalar	= array_unique($datalar);
										 $silinsin=array(""," ");
										 $datalar=array_diff($datalar,$silinsin);
										 $datatxt	= NULL;
										 $toplam	= count($datalar);
										 foreach($datalar as $data){
										 $datatxt	.= $data."\n";
										 }
										 echo rtrim($datatxt,"\n");
										 
										 ?></textarea>
										 <br />
										 <button type="button" class="btn btn-primary waves-effect waves-light" onclick="DataKaydet();">Datayı Güncelle</button>
                                         </div>
                                         </div>
										
										
									<div class="form-group">
                                            <label for="mesaj" class="col-sm-1 control-label">İçerik</label>
                                            <div class="col-sm-11">
											<textarea class="form-control" rows="9" id="mesaj" name="mesaj"></textarea>
                                        </div>
                                        </div>
										
										
										
										<div class="form-group">
										<div class="col-sm-11">
                                            Sisteme kayıtlı toplam <b><?=$toplam;?></b> adet GSM bulunmaktadır.
                                        </div>
                                        </div>
										
                                        
									<div align="right">
                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick="TopluMailGonder();">Toplu SMS Gönder</button>
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

                focus: true // set focus to editable area after initializing summernote
            });

        });
    </script>
	<script type="text/javascript">
	function DataKaydet(){
	$("#forms").attr("action","ajax.php?p=gsmler");
	AjaxFormS('forms','form_status');
	}
	
	function TopluMailGonder(){
	$("#forms").attr("action","ajax.php?p=toplu_sms");
	AjaxFormS('forms','form_status');
	}
	</script>
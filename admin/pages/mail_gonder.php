<?php
$konu		= $gvn->html_temizle($_GET["konu"]);
$kime		= $gvn->html_temizle($_GET["kime"]);
$mesaj		= $_GET["mesaj"];

?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Mail Gönder</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=mail_gonder" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
<label for="konu" class="col-sm-1 control-label">Konu</label>
<div class="col-sm-11">
<input type="text" class="form-control" id="konu" name="konu" value="<?=$konu;?>" placeholder="">
</div>
</div>

<div class="form-group">
<label for="kime" class="col-sm-1 control-label">Alıcı</label>
<div class="col-sm-11">
<input type="text" class="form-control" id="kime" name="kime" value="<?=$kime;?>" placeholder="">
</div>
</div>

<div class="form-group">
<div class="col-sm-12">
<label class="control-label">Mesajınız</label>
<textarea class="summernote form-control" id="mesaj" name="mesaj"><?=$mesaj;?></textarea>
</div>
</div>
										
                                        
									<div align="right">
                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('forms','form_status');"><i class="fa fa-paper-plane" aria-hidden="true"></i> Mesajı Gönder</button>
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
                height: 400, // set editor height

                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor

                focus: true, // set focus to editable area after initializing summernote
				onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);}
            });

        });
    </script>
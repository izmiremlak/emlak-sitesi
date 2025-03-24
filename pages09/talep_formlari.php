<?php
$db->query("UPDATE mail_19541956 SET durumb='1' WHERE tipi=2 AND durumb=0");
?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Talep Formları</h4>

                        </div>
                    </div>
					
                    




					
			
<div class="row">
                        
    
                        <div class="col-lg-12 col-md-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="btn-toolbar" role="toolbar">
									
                                        
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Seçilenlere Uygula <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onclick="TumuOkundu();">Okundu</a></li>
                                                <li><a href="#" onclick="TumuSil();">Seçilenleri Sil</a></li>
                                            </ul>
                                        </div>
										
										
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default m-t-20">
                                <div class="panel-body">
								
<?php
if($hesap->tipi != 2){
$okundu			= $gvn->rakam($_GET["okundu"]);
$okunmadi		= $gvn->rakam($_GET["okunmadi"]);
$sil			= $gvn->rakam($_GET["sil"]);
if($okundu != ""){
$db->query("UPDATE mail_19541956 SET durum='1' WHERE id=".$okundu." ");
header("Location:index.php?p=talep_formlari");
}elseif($okunmadi != ""){
$db->query("UPDATE mail_19541956 SET durum='0' WHERE id=".$okunmadi." ");
header("Location:index.php?p=talep_formlari");
}elseif($sil != ""){
$db->query("DELETE FROM mail_19541956 WHERE id=".$sil." ");
header("Location:index.php?p=talep_formlari");
}

if($_POST){
$idler		= $_POST["id"];
$action		= $_POST["action"];

if(count($idler) > 0){
foreach($idler as $id){
$id			= $gvn->rakam($id);
if($action == 'okundu'){
$db->query("UPDATE mail_19541956 SET durum='1' WHERE id=".$id);
}elseif($action == 'okunmadi'){
$db->query("UPDATE mail_19541956 SET durum='0' WHERE id=".$id);
}elseif($action == 'sil'){
$db->query("DELETE FROM mail_19541956 WHERE id=".$id);
}
} // FOREACH END
} // eğer varsa

header("Location:index.php?p=talep_formlari");

}



} // tipi 0 değilse
?>
<form action="" method="POST" id="SelectForm">
<input type="hidden" name="action" value="" id="action_hidden">	
                                        <table class="table table-hover mails datatable">
										<thead>
										<tr>
										<th>Seç</th>
										<th>Adı Soyadı</th>
										<th>E-Posta</th>
										<th>Telefon</th>
										<th>Tarih</th>
										<th>Kontroller</th>
										
										</tr>
										</thead>
                                        
										<tbody>
										<?php
										$sorgu		= $db->query("SELECT * FROM mail_19541956 WHERE tipi=2 ORDER BY durum ASC, id DESC LIMIT 0,500");
										while($msg	= $sorgu->fetch(PDO::FETCH_OBJ)){
										$custom		= json_decode($msg->customs,true);
										?>
										<tr <?=($msg->durum == 0) ? 'style="background-color:#fde1e1"' : ''; ?>>
										
										<td class="mail-select">
										<div class="checkbox checkbox-primary">
										<input id="checkbox<?=$msg->id;?>" type="checkbox" name="id[]" value="<?=$msg->id;?>">
										<label for="checkbox<?=$msg->id;?>"></label>
										</div>
                                         </td>
										 
										 <td><?=$msg->adsoyad;?></td>
										 <td><?=$msg->email;?></td>
										 <td><?=$msg->telefon;?></td>
										 <td><?=date("d.m.Y H:i",strtotime($msg->tarih));?></td>
										 <td>
										 
<div id="myModal<?=$msg->id;?>" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Talep Detaylar</h4>
</div>
<div class="modal-body">
<p>IP Adresi: <strong><?=$msg->ip;?></strong></p>
<?php
foreach($custom as $k=>$v){
if($k != "acid"){
?><p><?=$k;?>: <strong><?=$v;?></strong></p><?
}
}
?>
<p>Talebi ile ilgili detaylar;<br />
<strong><?=$msg->mesaj;?></strong></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
</div>
</div>

</div>
</div>

										 
										 <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">İşlemler</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" data-toggle="modal" data-target="#myModal<?=$msg->id;?>">Detaylar</a></li>
                                            <li><a href="index.php?p=talep_formlari&okundu=<?=$msg->id;?>">Okundu</a></li>
                                            <li><a href="index.php?p=talep_formlari&sil=<?=$msg->id;?>">Sil</a></li>
                                        </ul>
                                    </div>
									
										 
										 </td>
													
										
										</tr>
										<?
										}
										?>
										</tbody>
										   
                                        </table>
</form>
									
									
                                </div>
                            </div>
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
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
	<link href="assets/vendor/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
	<link href="assets/vendor/summernote/dist/summernote.css" rel="stylesheet">
	<style type="text/css">

	</style>
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/vendor/sweetalert/dist/sweetalert.min.js"></script>
	<script src="assets/vendor/summernote/dist/summernote.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
	$('.datatable').dataTable();
	});
	
	function TumuOkundu() {
	$("#action_hidden").val("okundu");
	       swal({   
            title: "Seçilenleri Okundu Olarak İşaretleme",   
            text: "Bu işlemi gerçekten yapmak istiyor musunuz ?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Evet, Hemen!",   
            closeOnConfirm: false 
        }, function(){   
         //  swal("Deleted!", "İşlem Başarıyla Gerçekleşti.", "success"); 
			$("#SelectForm").submit();
        });
	}
	
	
	function TumuOkunmadi() {
	$("#action_hidden").val("okunmadi");
	       swal({   
            title: "Seçilenleri Okunmadı Olarak İşaretle",   
            text: "Bu işlemi gerçekten yapmak istiyor musunuz ?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Evet, Hemen!",   
            closeOnConfirm: false 
        }, function(){   
         //  swal("Deleted!", "İşlem Başarıyla Gerçekleşti.", "success"); 
			$("#SelectForm").submit();
        });
	}
	
	
	function TumuSil() {
	$("#action_hidden").val("sil");
	       swal({   
            title: "Seçilenleri Sil",   
            text: "Bu işlemi gerçekten yapmak istiyor musunuz ?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Evet, Hemen!",   
            closeOnConfirm: false 
        }, function(){   
         //  swal("Deleted!", "İşlem Başarıyla Gerçekleşti.", "success"); 
			$("#SelectForm").submit();
        });
	}
	
	</script>
	
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
    </script>
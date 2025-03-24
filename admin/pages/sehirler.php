            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">İl ve İlçe Blokları (Anasayfa)</h4>

                        </div>
                    </div>
                    
                    
                    
                    
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
                                             Sitenizin anasayfasında il ve ilçelerin daha çok dikkat çekebilmesi için eklenmiş olan il ve ilçe bloklarını bu alanda yönetebilirsiniz.
                                             Faaliyet gösterdiğiniz illeri veya ilçeleri, bunlara ait ne kadar ilan adedinin bulunduğununu, satılık mı kiralık mı yoksa günlük kiralık mı olduğunu tanımlayabilirsiniz. Tarafınızdan bazı alanların seçimi ile sistem otomatik olarak çalışmaktadır.
                                            </div> 
                                        </div> 
                                    </div>
                     </div> 
					
                    
					
<form action="" method="POST" id="SelectForm">
<input type="hidden" name="action" value="" id="action_hidden">				
<div class="row">
                        
    
                        <div class="col-lg-12 col-md-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="btn-toolbar" role="toolbar">
									
                                        
                                        <div class="btn-group">
										<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=sehir_ekle';"> <i class="fa fa-plus"></i> Yeni Ekle</button>
										
										</div>
										
										<div class="btn-group">
										
                                            <button type="button" class="btn btn-primary waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Seçilenlere Uygula <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
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
$sil			= $gvn->rakam($_GET["sil"]);
if($sil != ""){
$db->query("DELETE FROM sehirler_19541956 WHERE id=".$sil." ");
header("Location:index.php?p=sehirler");
}

if($_POST){
$idler		= $_POST["id"];
$action		= $_POST["action"];

if(count($idler) > 0){
foreach($idler as $id){
$id			= $gvn->rakam($id);
if($action == 'sil'){
$db->query("DELETE FROM sehirler_19541956 WHERE id=".$id);
}
} // FOREACH END
} // eğer varsa

header("Location:index.php?p=sehirler");

}



} // tipi 0 değilse
?>
                                    
                                        <table class="table table-hover mails datatable">
										<thead>
										<tr>
										<th>Seç</th>
										<th>Lokasyon</th>
										<th>Emlak Durum</th>
										<th>Sıra</th>
										<th>Kontroller</th>
										
										</tr>
										</thead>
                                        
										<tbody>
										<?php
										$sorgu		= $db->query("SELECT * FROM sehirler_19541956 WHERE dil='".$dil."' ORDER BY id DESC LIMIT 0,500");
										while($row	= $sorgu->fetch(PDO::FETCH_OBJ)){
										$il			= $db->query("SELECT il_adi FROM il WHERE id=".$row->il)->fetch(PDO::FETCH_OBJ);
										if($row->ilce != 0){
										$ilce		= $db->query("SELECT ilce_adi FROM ilce WHERE id=".$row->ilce)->fetch(PDO::FETCH_OBJ);
										}
										?>
										<tr>
										
										<td class="mail-select">
										<div class="checkbox checkbox-primary">
										<input id="checkbox<?=$row->id;?>" type="checkbox" name="id[]" value="<?=$row->id;?>">
										<label for="checkbox<?=$row->id;?>"></label>
										</div>
                                         </td>
										 
										 <td><?=($row->ilce == 0) ? $il->il_adi : $ilce->ilce_adi;?></td>
										 <td><?=$row->emlak_durum;?></td>
										 <td><?=$row->sira;?></td>
										 <td>

										 
										 <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">İşlemler</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="index.php?p=sehir_duzenle&id=<?=$row->id;?>">Düzenle</a></li>
                                            <li><a href="index.php?p=sehirler&sil=<?=$row->id;?>">Sil</a></li>
                                        </ul>
                                    </div>
									
										 
										 </td>
													
										
										</tr>
										<?
										}
										?>
										</tbody>
										   
                                        </table>
                                    
									
									
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
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/vendor/sweetalert/dist/sweetalert.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function() {
	$('.datatable').dataTable();
	});
	

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
	
<?php

$db->query("UPDATE upaketler_19541956 SET durumb='1' WHERE durumb=0");

?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Satılan Mağaza Paketleri</h4>

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
										
                                            <button type="button" class="btn btn-primary waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Seçilenlere Uygula <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" onclick="TumuOnayla();">Seçilenleri Onayla</a></li>
                                                <li><a href="#" onclick="TumuSil();">Seçilenleri Sil</a></li>
                                            </ul>
                                        </div>
                                        
                                        <div class="btn-group">
										<button type="button" onclick="window.location.href='index.php?p=uyelik_paketleri';" class="btn btn-danger waves-effect waves-light"><i class="fa fa-cog"></i> Üyelik Paket Özellik ve Ücretleri</button>
										</div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default m-t-20">
                                <div class="panel-body">
								
<?php
if($hesap->tipi != 2){
$sil			= $gvn->rakam($_GET["sil"]);
$onayla			= $gvn->rakam($_GET["onayla"]);
if($sil != ""){
$db->query("DELETE FROM upaketler_19541956 WHERE id=".$sil." ");
header("Location:index.php?p=upaketler");
}

if($onayla != ""){

$paket			= $db->query("SELECT * FROM upaketler_19541956 WHERE id=".$onayla)->fetch(PDO::FETCH_OBJ);
$hesapp			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$paket->acid)->fetch(PDO::FETCH_OBJ);


$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $paket->adi." ".dil("PAY_NAME2");


$fiyat			= $gvn->para_str($paket->tutar)." ".dil("UYELIKP_PBIRIMI");
$neresi			= "paketlerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparis_onaylandi",$hesapp->email,$hesapp->telefon);

$db->query("UPDATE upaketler_19541956 SET durum='1' WHERE id=".$onayla);
header("Location:index.php?p=upaketler");
}


if($_POST){
$idler		= $_POST["id"];
$action		= $_POST["action"];

if(count($idler) > 0){
foreach($idler as $id){
$id			= $gvn->rakam($id);
if($action == 'sil'){
$db->query("DELETE FROM upaketler_19541956 WHERE id=".$id);
}elseif($action == 'onayla'){

$paket			= $db->query("SELECT * FROM upaketler_19541956 WHERE id=".$id)->fetch(PDO::FETCH_OBJ);
$hesapp			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$paket->acid)->fetch(PDO::FETCH_OBJ);


$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $paket->adi." ".dil("PAY_NAME2");


$fiyat			= $gvn->para_str($paket->tutar)." ".dil("UYELIKP_PBIRIMI");
$neresi			= "paketlerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparis_onaylandi",$hesapp->email,$hesapp->telefon);

$db->query("UPDATE upaketler_19541956 SET durum='1' WHERE id=".$id);
}
} // FOREACH END
} // eğer varsa

header("Location:index.php?p=upaketler");

}



} // tipi 0 değilse
?>
                                    
                                        <table class="table table-hover mails datatable">
										<thead>
										<tr>
										<th width="6%">Seç</th>
										<th width="10%">Üye</th>
										<th>Paket</th>
										<th>Alış Tarihi</th>
										<th>Tutar</th>
										<th>Ödeme Yöntemi</th>
										<th>Durum</th>
										<th width="15%">Kontroller</th>
										</tr>
										</thead>
                                        
										<tbody>
										<?php
										$sorgu		= $db->query("SELECT * FROM upaketler_19541956 ORDER BY durum ASC,id DESC LIMIT 0,500");
										while($row	= $sorgu->fetch(PDO::FETCH_OBJ)){
										$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
										$uye->execute(array($row->acid));
										if($uye->rowCount()>0){
										$uye		= $uye->fetch(PDO::FETCH_OBJ);
										$name		= ($uye->unvan == '') ? $uye->adsoyad : $uye->unvan;
										}
										?>
										<tr>
										<td class="mail-select">
										<div class="checkbox checkbox-primary">
										<input id="checkbox<?=$row->id;?>" type="checkbox" name="id[]" value="<?=$row->id;?>">
										<label for="checkbox<?=$row->id;?>"></label>
										</div>
                                        </td>
										 
										 <td><a href="index.php?p=uye_duzenle&id=<?=$uye->id;?>" target="_blank"><?=$name;?></a></td>
										 <td><?=$row->adi;?></td>
										 <td><?=date("d.m.Y H:i",strtotime($row->tarih));?></td>
										 <td><strong title="<?=$row->sure." ".$periyod[$row->periyod];?>"><?=$gvn->para_str($row->tutar);?> <?=dil("UYELIKP_PBIRIMI");?></strong></td>
										 
										 <td><?=$row->odeme_yontemi;?></td>
										 <td id="upaket<?=$row->id;?>_durum"><?php
										 echo ($row->durum == 0) ? '<strong style="color:red">Onay Bekleniyor</strong>' : ''; 
										 echo ($row->durum == 1) ? '<strong style="color:green">Onaylandı</strong>' : ''; 
										 echo ($row->durum == 2) ? '<strong style="color:black">İptal Edildi</strong>' : ''; 
										 ?></td>
										 
										 <td>
										 <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">İşlemler</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="index.php?p=upaket_duzenle&id=<?=$row->id;?>">Düzenle</a></li>
                                            <li><a href="javascript:if(confirm('Gerçekten onaylamak istiyor musunuz?')){ajaxHere('ajax.php?p=upaketler&onayla=<?=$row->id;?>','hidden_result');};">Onayla</a></li>
                                            <li><a href="index.php?p=upaketler&sil=<?=$row->id;?>">Sil</a></li>
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
	
	function TumuOnayla() {
	$("#action_hidden").val("onayla");
	       swal({   
            title: "Seçilenleri Onayla",   
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
	<div id="hidden_result" style="display:none"></div>
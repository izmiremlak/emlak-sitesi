<?php
$turler		= explode(",",dil("UYELIK_TURLERI"));
$turu		= $_GET["turu"];
$xturu		= $gvn->rakam($turu);

if($turu == 0 && $turu != ''){
$turu		= $turler[$turu]." ";
$turun		= " AND turu=0";
}elseif($turu == 1){
$turu		= $turler[$turu]." ";
$turun		= " AND turu=1";
}elseif($turu == 2){
$turu		= $turler[$turu]." ";
$turun		= " AND turu=2";
}else{
$turu		= '';
$turun		= '';
}


?>            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title"><?=$turu;?>Üyeler</h4>

                        </div>
                    </div>
					

					
<form action="" method="POST" id="SelectForm">
<input type="hidden" name="action" value="" id="action_hidden">				
<div class="row">
                        
	
                        <div class="col-lg-12 col-md-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="btn-toolbar" role="toolbar">
									
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default m-t-20">
                                <div class="panel-body">

<button type="button" class="btn btn-success waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=uye_ekle';"> 
<i class="fa fa-plus" aria-hidden="true"></i> <strong> Üye Ekle</strong></button>

<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=uyeler';"> 
<i class="fa fa-angle-right" aria-hidden="true"></i> <strong> Tüm Üyeler</strong></button>

<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=uyeler&turu=0';"> 
<i class="fa fa-angle-right" aria-hidden="true"></i> <strong> Bireysel Üyeler</strong></button>

<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=uyeler&turu=1';"> 
<i class="fa fa-angle-right" aria-hidden="true"></i> <strong> Kurumsal Üyeler</strong></button>

<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=uyeler&turu=2';"> 
<i class="fa fa-angle-right" aria-hidden="true"></i> <strong> Danışmanlar</strong></button>

<br><br>

<?php
if($hesap->tipi != 2){
$sil			= $gvn->rakam($_GET["sil"]);
if($sil != ""){
$snc			= $db->query("SELECT tipi FROM hesaplar WHERE site_id_555=999 AND id=".$sil)->fetch(PDO::FETCH_OBJ);
if($snc->tipi != 1){
$db->query("DELETE FROM hesaplar WHERE site_id_555=000 AND id=".$sil." OR kid=".$sil);
$db->query("DELETE FROM sayfalar WHERE site_id_555=000 AND acid=".$sil);
$db->query("DELETE FROM dopingler_19541956 WHERE acid=".$sil);
$db->query("DELETE FROM dopingler_group_19541956 WHERE acid=".$sil);
$db->query("DELETE FROM mesajlar_19541956 WHERE kimden=".$sil." OR kime=".$sil);
$db->query("DELETE FROM mesaj_iletiler_19541956 WHERE gid=".$sil);
$db->query("DELETE FROM onecikan_danismanlar_19541956 WHERE acid=".$sil);
$db->query("DELETE FROM upaketler_19541956 WHERE acid=".$sil);
$db->query("DELETE FROM engelli_kisiler_19541956 WHERE kim=".$sil." OR kimi=".$sil);
$db->query("DELETE FROM favoriler_19541956 WHERE acid=".$sil);
header("Location:index.php?p=uyeler&turu=".$xturu);
}
}
} // tipi 0 değilse
?>
                                        <table class="table table-hover mails datatable">
										<thead>
										<tr>
										<th  style="display:none">Seç</th>
										<th>Üyelik Türü</th>
										<th>Adı Soyadı</th>
										<th>E-Posta</th>
										<th>Telefon</th>
										<th>Oluşturma Tarihi</th>
										<th>Kontroller</th>
										</tr>
										</thead>
                                        
										<tbody>
										<?php
										$sorgu		= $db->query("SELECT id,kid,tipi,turu,unvan,email,telefon,olusturma_tarih,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=000 AND tipi!=2".$turun." ORDER BY id DESC LIMIT 0,500");
										while($row	= $sorgu->fetch(PDO::FETCH_OBJ)){
										if($row->turu==2){
										$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
										$uye->execute(array($row->kid));
										if($uye->rowCount()>0){
										$uye		= $uye->fetch(PDO::FETCH_OBJ);
										$name		= ($uye->unvan == '') ? $uye->adsoyad : $uye->unvan;
										}
										}elseif($row->turu ==1){
										$name		= ($row->unvan == '') ? $row->adsoyad : $row->unvan;
										}else{
										$uye		= '';
										$name		= '';
										}
										?>
										<tr>
										
										<td style="display:none" class="mail-select">
										<div class="checkbox checkbox-primary">
										<input id="checkbox<?=$row->id;?>" type="checkbox" name="id[]" value="<?=$row->id;?>">
										<label for="checkbox<?=$row->id;?>"></label>
										</div>
                                         </td>
										 <td><b><?=$turler[$row->turu];?></b></td>
										 <td><b><a href="index.php?p=uye_duzenle&id=<?=$row->id;?>"><?=$row->adsoyad;?></a></b><?=($name!='') ? '<br>'.$name : '';?></td>
										 <td><?=($row->tipi==1) ? '---' : $row->email;?></td>
										 <td><?=$row->telefon;?></td>
										 <td><?=date("d.m.Y H:i",strtotime($row->olusturma_tarih));?></td>
										 <td>

										 
										 <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">İşlemler</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="index.php?p=uye_duzenle&id=<?=$row->id;?>">Görüntüle</a></li>
                                            <?if($row->tipi==0){?><li><a href="index.php?p=uyeler&turu=<?=$xturu;?>&sil=<?=$row->id;?>">Sil</a></li><?}?>
                                        </ul>
                                    </div>
									
										 
										 </td>
													
										
										</tr>
										<?
										}
										?>
										
										<?php
										if($xturu == 2){
										$sorgu		= $db->query("SELECT * FROM danismanlar_19541956 ORDER BY id DESC LIMIT 0,500");
										while($row	= $sorgu->fetch(PDO::FETCH_OBJ)){
										?>
										<tr id="danisman<?=$row->id;?>">
										
										<td class="mail-select" style="display:none">
										<div class="checkbox checkbox-primary">
										<input id="checkboxx<?=$row->id;?>" type="checkbox" name="idx[]" value="<?=$row->id;?>">
										<label for="checkboxx<?=$row->id;?>"></label>
										</div>
                                         </td>
										 
										 <td>Danışman</td>
										 <td><?=$row->adsoyad;?></td>
										 <td><?=$row->email;?></td>
										 <td><?=$row->gsm;?></td>
										 <td><?=date("d.m.Y H:i",strtotime($row->tarih));?></td>
										 <td>

										 
										 <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">İşlemler</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="index.php?p=danisman_duzenle&id=<?=$row->id;?>">Düzenle</a></li>
                                            <li><a href="javascript:;" onclick="if(confirm('Gerçekten silmek istiyor musunuz?')){ajaxHere('ajax.php?p=danismanlar&sil=<?=$row->id;?>','hidden_result');}">Sil</a></li>
                                        </ul>
                                    </div>
									
										 
										 </td>
													
										
										</tr>
										<?
										}}
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
	$('.datatable').dataTable({
    responsive: true
});
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
	
	
	function HatSil() {
	$("#action_hidden").val("hatsil");
	       swal({   
            title: "Seçilen Üyelerin Hatırlatmalarını Sil",   
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
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM ekatalog_19541956 WHERE site_id_555=888 AND id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);

if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];


if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['ekatalog']['thumb_x'],$gorsel_boyutlari['ekatalog']['thumb_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE ekatalog SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","/../uploads/thumb/<?=$resim;?>");
});
</script><?
}
}



$resim1tmp		= $_FILES['dosya']["tmp_name"];
$resim1nm		= $_FILES['dosya']["name"];
if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
@move_uploaded_file($resim1tmp,"../uploads/kataloglar/".$randnm);
$avgn			= $db->prepare("UPDATE ekatalog SET link=:link WHERE id=:id");
$avgn->execute(array('link' => 'uploads/kataloglar/'.$randnm, 'id' => $snc->id));
}


$updt			= $db->prepare("UPDATE ekatalog SET baslik=:baslik,sira=:sira WHERE id=:ids");
$updt->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'ids' => $snc->id
));

if($updt){
$fonk->ajax_tamam("Katalog Güncellendi.");
}


}
}
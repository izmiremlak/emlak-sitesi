<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM danismanlar_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




$adsoyad		= $gvn->html_temizle($_POST["adsoyad"]);
$gsm			= $gvn->html_temizle($_POST["gsm"]);
$telefon		= $gvn->html_temizle($_POST["telefon"]);
$email			= $gvn->html_temizle($_POST["email"]);


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($fonk->bosluk_kontrol($adsoyad) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['danismanlar']['thumb_x'],$gorsel_boyutlari['danismanlar']['thumb_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE danismanlar_19541956 SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?=$resim;?>");
});
</script><?
}
}


$updt			= $db->prepare("UPDATE danismanlar_19541956 SET adsoyad=?,gsm=?,telefon=?,email=? WHERE id=".$snc->id);
$updt->execute(array($adsoyad,$gsm,$telefon,$email));


if($updt){
$fonk->ajax_tamam("Başarıyla Güncellendi.");
}


}
}
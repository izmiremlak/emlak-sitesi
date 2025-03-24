<?php
if($hesap->id == ''){ 
die();
}

$id			= $gvn->rakam($_GET["ilan_id"]);

$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);

$ilan_aktifet	= ($hesap->tipi==1) ? 1 : $hesap->ilan_aktifet;
$acc			= $db->query("SELECT id,kid,ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$kid			= $acc->kid;
if($snc->acid != $hesap->id AND $hesap->id != $kid){
die();
}
$kurumsal		= $db->prepare("SELECT ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=?");
$kurumsal->execute(array($kid));
if($kurumsal->rowCount()>0){
$ilan_aktifet	= ($kurumsal->ilan_aktifet == 0) ? $ilan_aktifet : $kurumsal->ilan_aktifet;
}


if($snc->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$snc->video;
if(file_exists($nirde)){
unlink($nirde);
}
}

$db->query("UPDATE sayfalar SET video='' WHERE site_id_555=000 AND id=".$id);

?><script type="text/javascript">
$("#VideoVarContent").slideUp(300,function(){
$("#galeri_video_ekle").slideDown(300);
});
$('html, body').animate({scrollTop: 250}, 500);
</script><?
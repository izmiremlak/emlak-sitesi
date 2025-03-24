<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM subeler_bayiler_19541956  WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}

$lokasyon		= $gvn->html_temizle($_POST["lokasyon"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$adres			= $gvn->html_temizle($_POST["adres"]);
$telefon		= $gvn->html_temizle($_POST["telefon"]);
$gsm			= $gvn->html_temizle($_POST["gsm"]);
$email			= $gvn->html_temizle($_POST["email"]);
$google_maps	= $gvn->html_temizle($_POST["google_maps"]);



if($fonk->bosluk_kontrol($lokasyon) == true){
die($fonk->ajax_hata("Lütfen tüm alanları eksiksiz doldurun."));
}


try {

$ekle			= $db->prepare("UPDATE subeler_bayiler_19541956 SET lokasyon=?,sira=?,adres=?,telefon=?,gsm=?,email=?,google_maps=? WHERE id=".$id);
$ekle->execute(array($lokasyon,$sira,$adres,$telefon,$gsm,$email,$google_maps));
$fonk->ajax_tamam("Şube Güncellendi.");
}catch(PDOException $e) {
$fonk->ajax_hata($e->getMessage());
}




}
}
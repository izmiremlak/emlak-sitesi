<?php
if($hesap->id != "" AND $hesap->tipi != 0){
if($_POST){

$son_dil	= $db->query("SELECT kisa_adi FROM diller_19541956 WHERE kisa_adi='".$dil."' ORDER BY id DESC")->fetch(PDO::FETCH_OBJ);
$dili		= $son_dil->kisa_adi;


$adi			= $gvn->html_temizle($_POST["adi"]);
$kisa_adi		= $gvn->html_temizle($_POST["kisa_adi"]);
$kisa_adi		= strtolower($kisa_adi);
$gosterim_adi	= $gvn->html_temizle($_POST["gosterim_adi"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$degiskenler	= stripslashes($_POST["degiskenler"]);
$durum    		= $gvn->zrakam($_POST["durum"]);
$kopyala  		= $gvn->zrakam($_POST["kopyala"]);


$kontrolet		= $db->prepare("SELECT id FROM diller_19541956 WHERE adi=? OR kisa_adi=?");
$kontrolet->execute(array($adi,$kisa_adi));

if($kontrolet->rowCount()>0){
die($fonk->ajax_hata("Böyle bir dil zaten mevcut!"));
}


if($fonk->bosluk_kontrol($adi) == true OR $fonk->bosluk_kontrol($kisa_adi) == true OR $fonk->bosluk_kontrol($degiskenler) == true){
die($fonk->ajax_hata("Lütfen tüm alanları eksiksiz doldurun."));
}

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',false,false);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',false,false);
}



$ayarlar_aktar		= $fonk->dil_aktar("ayarlar",$dili,$kisa_adi);
if(!$ayarlar_aktar){die($fonk->ajax_hata("Bir hata oluştu. Veriler Aktarılamıyor. #1"));}


$sablonlar_aktar	= $fonk->dil_aktar("mail_sablonlar_19541956 SET",$dili,$kisa_adi);
if(!$sablonlar_aktar){
die($fonk->ajax_hata("Bir hata oluştu. Veriler Aktarılamıyor. #2"));
}
if($kopyala == 1){
$aktar6 = $fonk->dil_aktar("kategoriler",$dili,$kisa_adi);
$aktar10 = $fonk->dil_aktar("sayfalar",$dili,$kisa_adi);
$aktar8 = $fonk->dil_aktar("menuler",$dili,$kisa_adi,array($aktar6,$aktar10));
$aktar11 = $fonk->dil_aktar("galeri_foto",$dili,$kisa_adi,array(array(),$aktar10));
$aktar13 = $fonk->dil_aktar("slider",$dili,$kisa_adi);
$aktar14 = $fonk->dil_aktar("subeler_bayiler",$dili,$kisa_adi);
$aktar16 = $fonk->dil_aktar("referanslar",$dili,$kisa_adi);
$aktar17 = $fonk->dil_aktar("sehirler",$dili,$kisa_adi);
}


try {
$ekle			= $db->prepare("INSERT INTO diller_19541956 SET adi=?,kisa_adi=?,resim=?,gosterim_adi=?,sira=?,durum=?");
$ekle->execute(array($adi,$kisa_adi,$resim,$gosterim_adi,$sira,$durum));
touch("../".THEME_DIR."diller/".$kisa_adi.".txt");
file_put_contents("../".THEME_DIR."diller/".$kisa_adi.".txt",$degiskenler);

setcookie("dil",$kisa_adi,time()+60*60*24*30);
$fonk->ajax_tamam("Dil eklendi.");
$fonk->yonlendir("index.php",1500);
}catch(PDOException $e) {
die($e->getMessage());
}


}
}

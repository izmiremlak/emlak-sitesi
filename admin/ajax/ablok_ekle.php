<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$sira			= $gvn->zrakam($_POST["sira"]);
$icon			= $_POST["icon"];
$aciklama		= $_POST["aciklama"];
$baslik			= $gvn->html_temizle($_POST["baslik"]);
$url			= $gvn->html_temizle($_POST["url"]);

if($fonk->bosluk_kontrol($baslik) == true OR $fonk->bosluk_kontrol($aciklama) == true OR $fonk->bosluk_kontrol($sira) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['abloklar']['orjin_x'],$gorsel_boyutlari['abloklar']['orjin_y']);
}



$ekle			= $db->prepare("INSERT INTO abloklar SET dil=?,sira=?,icon=?,resim=?,baslik=?,aciklama=?,url=? ");
$ekle->execute(array($dil,$sira,$icon,$resim,$baslik,$aciklama,$url));

if($ekle){
$fonk->ajax_tamam("Anasayfa Blok Eklendi.");
$fonk->yonlendir("index.php?p=abloklar",3000);
}


}
}
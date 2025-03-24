<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$adsoyad		= $gvn->html_temizle($_POST["adsoyad"]);
$firma			= $gvn->html_temizle($_POST["firma"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$mesaj			= $_POST["mesaj"];
$tarih			= $fonk->datetime();

if($fonk->bosluk_kontrol($adsoyad) == true OR $mesaj == ''){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['musteri_yorumlar']['thumb_x'],$gorsel_boyutlari['musteri_yorumlar']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['musteri_yorumlar']['orjin_x'],$gorsel_boyutlari['musteri_yorumlar']['orjin_y']);
}



$ekle			= $db->prepare("INSERT INTO musteri_yorumlar SET adsoyad=?,mesaj=?,sira=?,dil=?,tarih=?,resim=?,firma=?");
$ekle->execute(array($adsoyad,$mesaj,$sira,$dil,$tarih,$resim,$firma));

if($ekle){
$fonk->ajax_tamam("İşlem Tamamlandı.");
$fonk->yonlendir("index.php?p=musteri_yorumlar",3000);
}


}
}
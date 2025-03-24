<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$adsoyad		= $gvn->html_temizle($_POST["adsoyad"]);
$gsm			= $gvn->html_temizle($_POST["gsm"]);
$telefon		= $gvn->html_temizle($_POST["telefon"]);
$email			= $gvn->html_temizle($_POST["email"]);


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($fonk->bosluk_kontrol($adsoyad) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

$resim2tmp		= $_FILES['resim2']["tmp_name"];
$resim2nm		= $_FILES['resim2']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/',$gorsel_boyutlari['danismanlar']['thumb_x'],$gorsel_boyutlari['danismanlar']['thumb_y']);
}else{
$resim			= "default_danisman_resim.png";
}


$ekle			= $db->prepare("INSERT INTO danismanlar_19541956 SET adsoyad=?,gsm=?,telefon=?,email=?,resim=?,tarih=? ");
$ekle->execute(array($adsoyad,$gsm,$telefon,$email,$resim,$fonk->datetime()));

if($ekle){
$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=danismanlar",3000);
}


}
}
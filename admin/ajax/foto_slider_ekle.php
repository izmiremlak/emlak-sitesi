<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$aciklama	= $gvn->html_temizle($_POST["aciklama"]);
$link		= $gvn->html_temizle($_POST["link"]);

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1nm == ''){
die($fonk->ajax_uyari("Lütfen görsel seçiniz!"));
}


if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['slider']['thumb_x'],$gorsel_boyutlari['slider']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['slider']['orjin_x'],$gorsel_boyutlari['slider']['orjin_y']);
}

$ekle			= $db->prepare("INSERT INTO slider_19541956 SET baslik=:baslik,sira=:sira,resim=:resim,tarih=:bugun,dil=:dil,aciklama=:aciklamax,link=:linkx ");
$ekle->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'resim' => $resim,
'bugun' => $fonk->datetime(),
'dil' => $dil,
'aciklamax' => $aciklama,
'linkx' => $link,
));

if($ekle){
$fonk->ajax_tamam("Slayt Eklendi.");
$fonk->yonlendir("index.php?p=foto_slider",3000);
}


}
}
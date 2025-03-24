<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);

$dosya1tmp		= $_FILES['dosya']["tmp_name"];
$dosya1nm		= $_FILES['dosya']["name"];

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['ekatalog']['thumb_x'],$gorsel_boyutlari['ekatalog']['thumb_y']);
}



if($dosya1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($dosya1nm);
@move_uploaded_file($dosya1tmp,"../uploads/kataloglar/".$randnm);
$dosya			= $randnm;
}

$ekle			= $db->prepare("INSERT INTO ekatalog SET baslik=:baslik,sira=:sira,link=:link,resim=:resim,dil=:dil ");
$ekle->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'link' => "uploads/kataloglar/".$dosya,
'resim' => $resim,
'dil' => $dil
));

if($ekle){
$fonk->ajax_tamam("Katalog Eklendi.");
$fonk->yonlendir("index.php?p=ekatalog",3000);
}


}
}
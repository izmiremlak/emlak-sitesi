<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);

$resim1tmp		= $_FILES['dosya']["tmp_name"];
$resim1nm		= $_FILES['dosya']["name"];

if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
@move_uploaded_file($resim1tmp,"../uploads/belgeler/".$randnm);
}

$ekle			= $db->prepare("INSERT INTO belgeler SET baslik=:baslik,sira=:sira,link=:link,dil=:dil ");
$ekle->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'link' => "uploads/belgeler/".$randnm,
'dil' => $dil
));

if($ekle){
$fonk->ajax_tamam("Belge Eklendi.");
$fonk->yonlendir("index.php?p=belgeler",3000);
}


}
}
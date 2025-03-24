<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM belgeler WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




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
$avgn			= $db->prepare("UPDATE belgeler SET link=:link WHERE id=:id");
$avgn->execute(array('link' => 'uploads/belgeler/'.$randnm, 'id' => $snc->id));
}


$updt			= $db->prepare("UPDATE belgeler SET baslik=:baslik,sira=:sira WHERE id=:ids");
$updt->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'ids' => $snc->id
));

if($updt){
$fonk->ajax_tamam("Belge Güncellendi.");
}


}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$ilce_id		= $gvn->rakam($_GET["ilce_id"]);
$adi			= $gvn->html_temizle($_POST["adi"]);


if($fonk->bosluk_kontrol($ilce_id)==true){
die($fonk->ajax_uyari("Lütfen ilçe seçiniz."));
}

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$snc		= $db->prepare("SELECT * FROM ilce WHERE id=:ids");
$snc->execute(array('ids' => $ilce_id));
if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$slug			= $gvn->PermaLink($adi);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
$ekle			= $db->prepare("INSERT INTO semt SET il_id=?,ilce_id=?,ulke_id=?,semt_adi=? ");
$ekle->execute(array($snc->il_id,$snc->id,$snc->ulke_id,$adi));
}catch(PDOException $e){
die($e->getMessage());
}


$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=bolgeler_ilce&id=".$ilce_id,1000);


}
}
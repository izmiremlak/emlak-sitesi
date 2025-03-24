<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$il_id			= $gvn->rakam($_GET["il_id"]);
$adi			= $gvn->html_temizle($_POST["adi"]);


if($fonk->bosluk_kontrol($il_id)==true){
die($fonk->ajax_uyari("Lütfen il seçiniz."));
}

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$snc		= $db->prepare("SELECT * FROM il WHERE id=:ids");
$snc->execute(array('ids' => $il_id));
if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$slug			= $gvn->PermaLink($adi);
$il_slug		= $snc->slug;
$slug2			= $il_slug."-".$slug;


$ekle			= $db->prepare("INSERT INTO ilce SET il_id=?,ulke_id=?,ilce_adi=?,slug=? ");
$ekle->execute(array($il_id,$snc->ulke_id,$adi,$slug));

if($ekle){
$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=bolgeler_il&id=".$il_id,1000);
}


}
}
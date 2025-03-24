<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM dopingler_group_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$durum						= $gvn->zrakam($_POST["durum"]);
$odeme_yontemi				= $gvn->html_temizle($_POST["odeme_yontemi"]);
$xtutar						= $gvn->prakam($_POST["xtutar"]);
$xtutar						= $gvn->para_int($xtutar);
$ids						= $_POST["ids"];
$sure						= $_POST["sure"];
$periyod					= $_POST["periyod"];
$tutar						= $_POST["tutar"];
$btarih						= $_POST["btarih"];

foreach($ids as $d){
$dis			= $db->prepare("SELECT id,sure,periyod,tarih,btarih FROM dopingler_19541956 WHERE id=?");
$dis->execute(array($d));
if($dis->rowCount()>0){
$dis			= $dis->fetch(PDO::FETCH_OBJ);
$dsure			= $gvn->zrakam($sure[$d]);
$dperiyod		= $gvn->harf_rakam($periyod[$d]);
$dtutar			= $gvn->prakam($tutar[$d]);
$dbtarih		= $gvn->html_temizle($btarih[$d]);
$dbtarih			= ($dbtarih == '') ? date("Y-m-d")." 23:59:59" : date("Y-m-d",strtotime($dbtarih))." 23:59:59";

if($dbtarih == $dis->btarih && ($dsure != $dis->sure || $dperiyod != $dis->periyod)){
$expiry			= $dis->tarih." +".$dsure;
$expiry			.= ($dperiyod == "gunluk") ? ' day' : '';
$expiry			.= ($dperiyod == "aylik") ? ' month' : '';
$expiry			.= ($dperiyod == "yillik") ? ' year' : '';
$dbtarih			= date("Y-m-d",strtotime($expiry))." 23:59:59";
}
try{
$query				= $db->prepare("UPDATE dopingler_19541956 SET sure=?,periyod=?,tutar=?,btarih=?,durum=? WHERE id=?");
$query->execute(array($dsure,$dperiyod,$dtutar,$dbtarih,$durum,$d));
}catch(PDOException $e){
die($e->getMessage());
}
}
}

if($durum == 1 && $snc->durum != 1){

$hesapp			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$sayfay			= $db->query("SELECT id,baslik FROM sayfalar WHERE site_id_555=999 AND id=".$snc->ilan_id)->fetch(PDO::FETCH_OBJ);

$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $sayfay->baslik." ".dil("PAY_NAME");

$fiyat			= $gvn->para_str($tutar)." ".dil("DOPING_PBIRIMI");
$neresi			= "dopinglerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparis_onaylandi",$hesapp->email,$hesapp->telefon);


}


try{
$query				= $db->prepare("UPDATE dopingler_group_19541956 SET durum=?,odeme_yontemi=?,tutar=? WHERE id=?");
$query->execute(array($durum,$odeme_yontemi,$xtutar,$id));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Güncelleme başarıyla gerçekleşti.");

}
}
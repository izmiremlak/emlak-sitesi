<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$otoug				= $gvn->zrakam($_POST["otoug"]);
$otoh				= $gvn->zrakam($_POST["otoh"]);
$otoug_sira			= $gvn->zrakam($_POST["otoug_sira"]);
$otoh_sira			= $gvn->zrakam($_POST["otoh_sira"]);

if($sms_firma != ''){
@file_put_contents("../sms_firma.txt",$sms_firma);
}


$guncelle		= $db->prepare("UPDATE gayarlar_19541956 SET otoug=?,otoh=?,otoug_sira=?,otoh_sira=? ");
$guncelle->execute(array($otoug,$otoh,$otoug_sira,$otoh_sira));

if($guncelle){
$fonk->ajax_tamam("Menü Ayarları Güncellendi.");
}


}
}
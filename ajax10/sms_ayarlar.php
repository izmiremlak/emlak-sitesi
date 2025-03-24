<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$sms_baslik			= $gvn->html_temizle($_POST["sms_baslik"]);
$sms_username		= $gvn->html_temizle($_POST["sms_username"]);
$sms_password		= $gvn->html_temizle($_POST["sms_password"]);
$rez_tel			= $gvn->html_temizle($_POST["rez_tel"]);
$sms_firma			= $gvn->zrakam($_POST["sms_firma"]);


$guncelle		= $db->prepare("UPDATE gayarlar_19541956 SET sms_firma=?,sms_baslik=?,sms_username=?,sms_password=?,rez_tel=?");
$guncelle->execute(array($sms_firma,$sms_baslik,$sms_username,$sms_password,$rez_tel));

if($guncelle){
$fonk->ajax_tamam("SMS Ayarları Güncellendi.");
}


}
}
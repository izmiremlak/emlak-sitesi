<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$paypal					= $gvn->zrakam($_POST["paypal"]);
$iyzico					= $gvn->zrakam($_POST["iyzico"]);
$paytr					= $gvn->zrakam($_POST["paytr"]);
$paypal_odeme_email 	= $gvn->html_temizle($_POST["paypal_odeme_email"]);
$iyzico_key 			= $gvn->html_temizle($_POST["iyzico_key"]);
$iyzico_secret_key 		= $gvn->html_temizle($_POST["iyzico_secret_key"]);
$paytr_magaza_no 		= $gvn->html_temizle($_POST["paytr_magaza_no"]);
$paytr_magaza_key 		= $gvn->html_temizle($_POST["paytr_magaza_key"]);
$paytr_magaza_salt 		= $gvn->html_temizle($_POST["paytr_magaza_salt"]);
$hesap_numaralari		= $_POST["hesap_numaralari"];


if($iyzico == 1 AND $paytr == 1){
die($fonk->ajax_hata("İki ödeme sistemi aynı anda kullanılamaz."));
}


$guncelle0		= $db->prepare("UPDATE ayarlar_19541956 SET hesap_numaralari=? WHERE dil='".$dil."'");
$guncelle0->execute(array($hesap_numaralari));

$guncelle		= $db->prepare("UPDATE gayarlar_19541956 SET paytr=?,paypal=?,iyzico=?,iyzico_key=?,iyzico_secret_key=?,paytr_magaza_no=?,paytr_magaza_key=?,paytr_magaza_salt=?,paypal_odeme_email=? ");
$guncelle->execute(array($paytr,$paypal,$iyzico,$iyzico_key,$iyzico_secret_key,$paytr_magaza_no,$paytr_magaza_key,$paytr_magaza_salt,$paypal_odeme_email)); 

if($guncelle){
$fonk->ajax_tamam("Tahsilat Ayarları Güncellendi.");
}


}
}
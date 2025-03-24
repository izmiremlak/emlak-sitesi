<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){
$ua					= $fonk->UyelikAyarlar();
$bireysel_uyelik	= $_POST["bireysel_uyelik"];
$kurumsal_uyelik	= $_POST["kurumsal_uyelik"];

$ua["bireysel_uyelik"] = $bireysel_uyelik;
$ua["kurumsal_uyelik"] = $kurumsal_uyelik;

$jso				= $fonk->json_encode_tr($ua);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
$gunc			= $db->prepare("UPDATE gayarlar_19541956 SET uyelik_ayarlar=? ");
$gunc->execute(array($jso));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Ayarlar Güncellendi.");

}
}
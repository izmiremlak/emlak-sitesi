<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$paketler_icerik	= $_POST["paketler_icerik"];

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
$gunc			= $db->prepare("UPDATE ayarlar_19541956 SET paketler_icerik=? WHERE dil='".$dil."' ");
$gunc->execute(array($paketler_icerik));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Ayarlar Güncellendi.");

}
}
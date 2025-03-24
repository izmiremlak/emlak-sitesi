<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$dzaman1a			= $gvn->zrakam($_POST["dzaman1a"]);
$dzaman1b			= $gvn->harf_rakam($_POST["dzaman1b"]);
$dzaman2a			= $gvn->zrakam($_POST["dzaman2a"]);
$dzaman2b			= $gvn->harf_rakam($_POST["dzaman2b"]);
$dzaman3a			= $gvn->zrakam($_POST["dzaman3a"]);
$dzaman3b			= $gvn->harf_rakam($_POST["dzaman3b"]);
$dzaman1			= $dzaman1a."|".$dzaman1b;
$dzaman2			= $dzaman2a."|".$dzaman2b;
$dzaman3			= $dzaman3a."|".$dzaman3b;

$fiyat1				= $_POST["fiyat1"];
$fiyat2				= $_POST["fiyat2"];
$fiyat3				= $_POST["fiyat3"];

foreach($fiyat1 AS $k=>$v){
$dfiyat1			= $gvn->prakam($fiyat1[$k]);
$dfiyat2			= $gvn->prakam($fiyat2[$k]);
$dfiyat3			= $gvn->prakam($fiyat3[$k]);
$dfiyat1			= $gvn->para_int($dfiyat1);
$dfiyat2			= $gvn->para_int($dfiyat2);
$dfiyat3			= $gvn->para_int($dfiyat3);

$gunc				= $db->prepare("UPDATE doping_ayarlar_19541956 SET fiyat1=?,fiyat2=?,fiyat3=? WHERE id=?");
$gunc->execute(array($dfiyat1,$dfiyat2,$dfiyat3,$k));

}



$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{
$gunc			= $db->prepare("UPDATE gayarlar_19541956 SET dzaman1=?,dzaman2=?,dzaman3=? ");
$gunc->execute(array($dzaman1,$dzaman2,$dzaman3));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Ayarlar Güncellendi.");

}
}
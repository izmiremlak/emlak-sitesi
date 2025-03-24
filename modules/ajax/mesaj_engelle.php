<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($gayarlar->anlik_sohbet == 0){
die();
}

$bid	= $hesap->id;
$basd	= $hesap->adi." ".$hesap->soyadi;
$uid	= $gvn->zrakam($_GET["uid"]);

include "methods/chat.lib.php";

if($BenEngel==1){
$db->query("DELETE FROM engelli_kisiler_19541956 WHERE kim=".$bid." AND kimi=".$uid);
}else{
$db->query("INSERT INTO engelli_kisiler_19541956 SET kim='".$bid."',kimi='".$uid."',tarih='".$fonk->datetime()."' ");
}
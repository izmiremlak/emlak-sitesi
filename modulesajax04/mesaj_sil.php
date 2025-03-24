<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($gayarlar->anlik_sohbet == 0){
die();
}

$bid	= $hesap->id;
$basd	= $hesap->adi." ".$hesap->soyadi;
$uid	= $gvn->zrakam($_GET["uid"]);

include "methods/chat.lib.php";

if($ilkSohbet==1){
die();
}

if($MesajLine->kimden == $bid){
$db->query("UPDATE mesaj_iletiler_19541956 SET gsil='1' WHERE mid=".$MesajLine->id);
}elseif($MesajLine->kime == $bid){
$db->query("UPDATE mesaj_iletiler_19541956 SET asil='1' WHERE mid=".$MesajLine->id);
}
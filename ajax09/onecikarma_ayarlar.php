<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){
$ua					= $fonk->UyelikAyarlar();

$sureler					= $_POST["sure"];
$periyodlar					= $_POST["periyod"];
$tutarlar					= $_POST["tutar"];
$ucretler					= array();

for($i=0;$i<=count($sureler);$i++){
if($periyodlar[$i] != ''){
$sure				= $gvn->zrakam($sureler[$i]);
$periyodu			= $gvn->harf_rakam($periyodlar[$i]);
$tutar				= $gvn->prakam($tutarlar[$i]);
$tutar				= $gvn->para_int($tutar);
$ucretler[]			= array('sure' => $sure,'periyod' => $periyodu,'tutar' => $tutar);
}
}
$ua["danisman_onecikar_ucretler"]	= $ucretler;


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
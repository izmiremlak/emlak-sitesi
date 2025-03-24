<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM mail_sablonlar_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




$adi			= $gvn->html_temizle($_POST["adi"]);
$konu			= $gvn->html_temizle($_POST["konu"]);
$konu2			= $gvn->html_temizle($_POST["konu2"]);
$degiskenler	= $gvn->html_temizle($_POST["degiskenler"]);
$yemails		= $gvn->html_temizle($_POST["yemails"]);
$yphones		= $gvn->html_temizle($_POST["yphones"]);
$icerik			= $_POST["icerik"];
$icerik2		= $_POST["icerik2"];
$icerik3		= $_POST["icerik3"];
$icerik4		= $_POST["icerik4"];
$ubildirim		= $gvn->zrakam($_POST["ubildirim"]);
$abildirim		= $gvn->zrakam($_POST["abildirim"]);
$sbildirim		= $gvn->zrakam($_POST["sbildirim"]);
$ysbildirim		= $gvn->zrakam($_POST["ysbildirim"]);



$updt			= $db->prepare("UPDATE mail_sablonlar_19541956 SET adi=?,konu=?,konu2=?,icerik=?,icerik2=?,icerik3=?,icerik4=?,ubildirim=?,abildirim=?,sbildirim=?,ysbildirim=?,degiskenler=?,yemails=?,yphones=? WHERE id=".$snc->id);
$updt->execute(array($adi,$konu,$konu2,$icerik,$icerik2,$icerik3,$icerik4,$ubildirim,$abildirim,$sbildirim,$ysbildirim,$degiskenler,$yemails,$yphones));

if($updt){
$fonk->ajax_tamam("İşlem Tamamlandı.");
}



}
}
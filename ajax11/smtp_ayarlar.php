<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$smtp_fromname		= $gvn->html_temizle($_POST["smtp_fromname"]); 
$smtp_host			= $gvn->html_temizle($_POST["smtp_host"]); 
$smtp_port			= $gvn->zrakam($_POST["smtp_port"]);
$smtp_protokol		= $gvn->html_temizle($_POST["smtp_protokol"]);
$smtp_username		= $gvn->html_temizle($_POST["smtp_username"]);
$smtp_password		= $gvn->html_temizle($_POST["smtp_password"]);



$guncelle		= $db->prepare("UPDATE gayarlar_19541956 SET smtp_host=:host,smtp_port=:port,smtp_protokol=:protokol,smtp_username=:username,smtp_password=:password,smtp_fromname=:fromname ");
$guncelle->execute(array('host' => $smtp_host, 'port' => $smtp_port, 'protokol' => $smtp_protokol, 'username' => $smtp_username,'password' => $smtp_password, 'fromname' => $smtp_fromname));

if($guncelle){
$fonk->ajax_tamam("SMTP Ayarları Güncellendi.");
}


}
}
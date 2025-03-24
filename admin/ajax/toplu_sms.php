<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$gonderilenler		= $_POST["gonderilenler"];
$mesaj				= $_POST["mesaj"];

if($gonderilenler == '' OR $mesaj == ''){
die($fonk->ajax_hata('Lütfen boş bırakma!'));
}
$gidecekler			= explode("\n",$gonderilenler);
$gsmler				= array();

$i					= 0;
foreach($gidecekler as $gsm){
$gsm				= trim($gsm);
if($gsm != "" AND is_numeric($gsm)){
$gsm				= (substr($gsm,0,3) == '+90') ? '0'.substr($gsm,3,20) : $gsm;
$gsm				= (substr($gsm,0,2) == '90') ? '0'.substr($gsm,2,20) : $gsm;
$gsm				= (substr($gsm,0,1) != 0) ? '0'.$gsm : $gsm;
if(strlen($gsm) == 11){
$gsmler[]			= $gsm;
}
}
}

$gonder		=	$fonk->sms_gonder($gsmler,$mesaj);

if($gonder){
$fonk->ajax_tamam("Toplu SMS Başarılı bir şekilde gönderildi.",3000);
}else{
$fonk->ajax_hata("İşlem Gerçekleşemiyor. Sms Gönderilemiyor.",3000);
}

}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$konu				= $gvn->html_temizle($_POST["konu"]);
$gonderilenler		= $_POST["gonderilenler"];
$mesaj				= $_POST["mesaj"];

if($konu == "" OR $gonderilenler == '' OR $mesaj == ''){
die($fonk->ajax_hata('Lütfen boş bırakma!'));
}
$gidecekler			= explode("\n",$gonderilenler);

$i					= 0;
$ygidecekler		= array();
foreach($gidecekler as $eposta){
if($eposta != ""){

$xgndr				= $fonk->mail_gonder($konu,$eposta,$mesaj);
if($xgndr){
$i					= $i+1;
}


}
}


$gonder = true;

if($gonder){
$fonk->ajax_tamam("İşlem Başarıyla Gerçekleşti.");
echo 'Toplam '.$i.' adet kişiye mail gönderildi.';
}else{
$fonk->ajax_hata("Mail gönderilemiyor.");
}


}
} 
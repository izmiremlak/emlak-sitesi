<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$konu		= $gvn->html_temizle($_POST["konu"]);
$kime		= $gvn->html_temizle($_POST["kime"]);
$mesaj		= $_POST["mesaj"];

if($konu == '' OR $kime == '' OR $mesaj == ''){
die($fonk->ajax_hata("Tüm alanları doldurunuz."));
}elseif($gvn->eposta_kontrol($kime) == false){
die($fonk->ajax_hata("Geçersiz bir e-posta adresi girdiniz."));
}

$message	= $mesaj;

$gonder		= $fonk->mail_gonder($konu,$kime,$message);

if($gonder){
?><script>$('#MailGonder').modal('hide');</script><?
$fonk->ajax_tamam("Mail Başarıyla Gönderildi.");
}else{
die($fonk->ajax_hata("Mail Gönderilemedi bir hata oluştu."));
}




}
}
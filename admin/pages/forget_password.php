<?php
if($_POST){
if($hesap->id == ""){
$cerez		= $_COOKIE["parola_hatirlat"];

if($fonk->bosluk_kontrol($cerez) == false){
die($fonk->bilgi("Az önce bildirim yapıldı. 15 dk. kadar bekleyin."));
}


$email		= $gvn->eposta($_POST["email"]);

if($fonk->bosluk_kontrol($email) == true){
die($fonk->uyari("Kayıtlı e-posta adresinizi girin."));
}

if($gvn->eposta_kontrol($email) == false){
die($fonk->hata("Geçersiz E-Posta formatı"));
}

$kontrol = $db->prepare("SELECT email,parola,id FROM hesaplar WHERE site_id_555=999 AND email=:eposta AND tipi=1");
$kontrol->execute(array('eposta' => $email));

if($kontrol->rowCount() > 0 ){
$hesap		= $kontrol->fetch(PDO::FETCH_OBJ);

$message 	= 'Yönetici Giriş Parolanız:  <strong>'.$hesap->parola.'</strong>';

$gonder		= $fonk->mail_gonder('Yönetim Parola Hatırlatma',$hesap->email,$message);

if($gonder){
$fonk->tamam("Parola Bilgileriniz E-posta Adresinize Gönderildi.");
setcookie("parola_hatirlat",$email,time()+60*15);
}else{
$fonk->hata("Mail gönderilemedi!");
}
}else{
$fonk->hata("Bu e-posta sistemimizdeki ile uyuşmuyor! <br/>Sistem yöneticiniz ile irtibat sağlayınız.");
}


}
}
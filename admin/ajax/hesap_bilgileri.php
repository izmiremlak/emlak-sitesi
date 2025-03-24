<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$adi			= $gvn->html_temizle($_POST["adi"]);
$soyadi			= $gvn->html_temizle($_POST["soyadi"]);
$email			= $gvn->eposta($_POST["email"]);
$avatartmp		= $_FILES['avatar']["tmp_name"];
$avatarnm		= $_FILES['avatar']["name"];

$mparola		= $gvn->html_temizle($_POST["mparola"]);
$yparola		= $gvn->html_temizle($_POST["yparola"]);
$ytparola		= $gvn->html_temizle($_POST["ytparola"]);



if($fonk->bosluk_kontrol($adi) == true OR $fonk->bosluk_kontrol($email) == true){
die($fonk->ajax_hata("Lütfen adınızı veya e-posta adresinizi boş bırakmayınız."));
}elseif($fonk->bosluk_kontrol($mparola) == true){
die($fonk->ajax_hata("Lütfen mevcut parolanızı giriniz."));
}

if($mparola != $hesap->parola){
die($fonk->ajax_hata("Mevcut Parolanızı Yanlış Yazdınız!"));
}



if($yparola != ''){ // Yeni parola girmiş ise start

if($fonk->bosluk_kontrol($ytparola) == true){
die($fonk->ajax_hata("Yeni Parola Tekrarı Giriniz!"));
}

if($ytparola != $yparola){
die($fonk->ajax_hata("Yeni Parola Tekrarı Hatalı Yazdınız!"));
}


$guncelle		= $db->prepare("UPDATE hesaplar SET parola=:yparola WHERE site_id_555=999 AND id=:acid");
$guncelle->execute(array('yparola' => $yparola,'acid' => $hesap->id));

if($guncelle){
$fonk->ajax_tamam("Hesap Parolanız Güncellendi.");
$_SESSION["acpw"] = $yparola;

if($ck_acpw != ""){
$login_secret	= $fonk->login_secret_key($hesap->id,$yparola);
setcookie("acid",$hesap->id,time()+60*60*24*30);
setcookie("acpw",$yparola,time()+60*60*24*30);
setcookie("acsecret",$login_secret,time()+60*60*24*30);
$db->query("UPDATE hesaplar SET login_secret='".$login_secret."' WHERE site_id_555=999 AND id=".$hesap->id);
}

}

} // Yeni parola girmiş ise end


if($gvn->eposta_kontrol($email) === false){
die($fonk->ajax_hata("E-posta adresiniz geçersiz!"));
}

if($email != $hesap->email){
$kontrol		= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND email=:email");
$kontrol->execute(array('email' => $email));
if($kontrol->rowCount() > 0 ){
die($fonk->ajax_uyari("E-posta başka hesap tarafından kullanılıyor."));
}else{
$guncelle		= $db->prepare("UPDATE hesaplar SET email=:email WHERE site_id_555=999 AND id=:id");
$guncelle->execute(array('email' => $email, 'id' => $hesap->id));
$fonk->ajax_tamam("E-posta adresiniz güncellendi.");
}
}


if($avatartmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($avatarnm);
$avatar			= $fonk->resim_yukle(true,'avatar',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',128,128);
if($avatar){
$avgn			= $db->prepare("UPDATE hesaplar SET avatar=:avatar WHERE site_id_555=999 AND id=:id");
$avgn->execute(array('avatar' => $avatar, 'id' => $hesap->id));
if($avgn){
$fonk->ajax_tamam('Avatar Resimi Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('.img-circle').attr("src","/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?=$avatar;?>");
});
</script><?
}
}else{
$fonk->ajax_hata('Avatar Güncellenemedi. Bir hata oluştu!');
}
}



$yguncelle		= $db->prepare("UPDATE hesaplar SET adi=:adi,soyadi=:soyadi WHERE site_id_555=999 AND id=:id");
$yguncelle->execute(array('adi' => $adi,'soyadi' => $soyadi, 'id' => $hesap->id));

if($yguncelle){
$fonk->ajax_tamam("Hesap bilgileri güncellendi.");
}else{
$fonk->ajax_hata("Hesap bilgileri güncellenemiyor.");
}


}
}
?>
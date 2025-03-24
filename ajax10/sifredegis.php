<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$mparola		= $gvn->html_temizle($_POST["mparola"]);
$yparola		= $gvn->html_temizle($_POST["yparola"]);
$ytparola		= $gvn->html_temizle($_POST["ytparola"]);

if($fonk->bosluk_kontrol($mparola) == true OR $fonk->bosluk_kontrol($yparola) == true OR $fonk->bosluk_kontrol($ytparola) == true){
die($fonk->ajax_uyari("Lütfen Boş Alan Bırakmayın!"));
}

if($mparola != $hesap->parola){
die($fonk->ajax_hata("Mevcut Parolanızı Yanlış Yazdınız!"));
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

}else{
$fonk->ajax_hata("Bir hata oluştu. Şifre Değiştirilemiyor.");
}


}
}
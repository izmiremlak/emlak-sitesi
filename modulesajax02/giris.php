<?php
if($hesap->id == "" AND $_POST){


$email		= $gvn->eposta($_POST["email"]);
$parola		= $gvn->html_temizle($_POST["parola"]);
$otut		= $gvn->rakam($_POST["otut"]);

if($fonk->bosluk_kontrol($email) == true OR $fonk->bosluk_kontrol($parola) == true){
die('<span class="error">'.dil("TX10").'</span>');
}

$kontrol	= $db->prepare("SELECT durum,id,email,parola,tipi FROM hesaplar WHERE site_id_555=999 AND email=:eposta AND parola=:sifre");
$kontrol->execute(array('eposta' => $email, 'sifre' => $parola));

if($kontrol->rowCount()!=0){
$hesap		= $kontrol->fetch(PDO::FETCH_OBJ);
$secret		= $fonk->login_secret_key($hesap->id,$parola);
$dt			= $fonk->datetime();
$ip_adres	= $fonk->IpAdresi();


$hup		= $db->prepare("UPDATE hesaplar SET ip=:ip_adresi,son_giris_tarih=:tarih,login_secret=:secret WHERE site_id_555=999 AND id=:hesap_id");
$hup->execute(array(
'ip_adresi' => $ip_adres,
'tarih' => $dt,
'secret' => $secret,
'hesap_id' => $hesap->id
));


if($hesap->durum == 1){ // hesabınız engellenmiştir.
die('<span class="error">'.dil("TX11").'</span>');

}else{ // hesap düzgünse

$_SESSION["acid"] 	= $hesap->id;
$_SESSION["acpw"] = $hesap->parola;

if($otut == 1){
setcookie("acid",$hesap->id,time()+60*60*24*30);
setcookie("acpw",$parola,time()+60*60*24*30);
setcookie("acsecret",$secret,time()+60*60*24*30);
}
echo('<span class="complete">'.dil("TX12").'</span>');

$referer	= $gvn->html_temizle($_COOKIE["login_redirect"]);
if($referer != '' AND stristr($referer,$domain)){
$yonlendir	= (stristr($referer,"index.html") || stristr($referer,"index.php")) ? "uye-paneli" : $referer;
}else{
$yonlendir	= "uye-paneli";
}

$fonk->yonlendir($yonlendir,0);
setcookie("login_redirect","",time()-1);

} // hesabı  düzgünse

}else{
die('<span class="error">'.dil("TX13").'<span>');
}



}
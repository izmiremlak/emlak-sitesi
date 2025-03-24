<?php
if($_POST){
if($hesap->id == ""){
$cerez		= $_COOKIE["parola_hatirlat"];

if($fonk->bosluk_kontrol($cerez) == false){
die("<span class='error'>".dil("TX41")."</span>");
}


$email		= $gvn->eposta($_POST["email"]);

if($fonk->bosluk_kontrol($email) == true){
die("<span class='error'>".dil("TX42")."</span>");
}

if($gvn->eposta_kontrol($email) == false){
die("<span class='error'>".dil("TX43")."</span>");
}

$kontrol = $db->prepare("SELECT email,parola,id,concat_ws(' ',adi,soyadi) AS adsoyad,unvan,telefon FROM hesaplar WHERE site_id_555=999 AND email=:eposta");
$kontrol->execute(array('eposta' => $email));

if($kontrol->rowCount() > 0 ){
$acc		= $kontrol->fetch(PDO::FETCH_OBJ);
$adsoyad	= ($acc->unvan != '') ? $acc->unvan : $acc->adsoyad;


$gonder 	= $fonk->bildirim_gonder(array($adsoyad,$acc->email,$acc->parola,SITE_URL."hesabim"),"sifre_unuttum",$acc->email,$acc->telefon);

if($gonder){
echo("<span class='complete'>".dil("TX44")."</span>");
setcookie("parola_hatirlat",$email,time()+60*15);
}else{
die("<span class='error'>".dil("TX45")."</span>");
}
}else{
die("<span class='error'>".dil("TX46")."</span>");
}


}
}
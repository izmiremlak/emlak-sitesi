<?php
if($_POST){
$adsoyad		= $gvn->html_temizle($_POST["adsoyad"]);
$telefon		= $gvn->html_temizle($_POST["telefon"]);
$email			= $gvn->html_temizle($_POST["email"]);
$cevap			= strtolower($gvn->html_temizle($_POST["cevap"]));
$mesaj			= $gvn->mesaj($_POST["mesaj"]);
$ip_adres		= $fonk->IpAdresi();
$tarih			= $fonk->datetime();

$varmi			= $db->prepare("SELECT * FROM mail_19541956 WHERE tipi=0 AND ip=? AND tarih BETWEEN DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND NOW()"); 
$varmi->execute(array($ip_adres));


if($fonk->bosluk_kontrol($adsoyad) == true OR $fonk->bosluk_kontrol($email) == true OR $fonk->bosluk_kontrol($mesaj) == true ){
die('<span class="error">'.dil("MS1").'</span>');
}

if($gvn->eposta_kontrol($email) == false){
die('<span class="error">'.dil("MS2").'</span>');
}

if($varmi->rowCount() > 0){
die('<span class="error">'.dil("MS3").'</span>');
}


if($cevap != dil('CEVP')){
die('<span class="error">'.dil("MS6").'</span>');
}



$gonder 	= $fonk->bildirim_gonder(array($adsoyad,$email,$telefon,$mesaj,date("d.m.Y H:i",strtotime($tarih)),$ip_adres),"iletisim",$email,$telefon);

if($gonder){

?>
<script type="text/javascript">
$("#iletisim_form").slideUp(500,function(){
$("#IletisimTamam").slideDown(500);
});
$('html, body').animate({scrollTop: 250}, 500);
</script>
<?

$ekle		= $db->prepare("INSERT INTO mail_19541956 SET adsoyad=:adsoyad,email=:email,telefon=:telefon,tarih=:tarih,mesaj=:mesaj,ip=:ip");
$ekle->execute(array(
'adsoyad' => $adsoyad,
'email' => $email,
'telefon' => $telefon,
'tarih' => $tarih,
'mesaj' => $mesaj,
'ip' => $ip_adres
));

}else{
die('<span class="hata">'.dil("MS5").'</span>');
}


}
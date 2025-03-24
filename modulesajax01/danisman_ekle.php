<?php
if($_POST){
if($hesap->id != ""){

$danisman_limit		= $hesap->danisman_limit;
$paketi				= $db->query("SELECT * FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND btarih>NOW()");
if($paketi->rowCount()>0){
$paketi				=  $paketi->fetch(PDO::FETCH_OBJ);
$danisman_limit		+= ($paketi->danisman_limit == 0) ? 9999 : $paketi->danisman_limit;
$danisman_limit		-= $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND kid=".$paketi->acid." AND pid=".$paketi->id)->rowCount();
}


if($danisman_limit<1){
die('<span class="error">'.dil("TX608").'</span>');
}

$pid				= ($paketi->id == '') ? 0 : $paketi->id;
$turu				= 2;
$adsoyad			= $gvn->html_temizle($_POST["adsoyad"]);
$ayr				= @explode(" ",$adsoyad);
$soyadi				= end($ayr);
array_pop($ayr);
$adi				= implode(" ",$ayr);
$nick_adi			= $gvn->PermaLink($adsoyad);
$email				= $gvn->html_temizle($_POST["email"]);
$telefon			= $gvn->rakam($_POST["telefon"]);
$sabit_telefon		= $gvn->rakam($_POST["sabit_telefon"]);
$parola				= $gvn->parola($_POST["parola"]);
$parola_tekrar		= $gvn->parola($_POST["parola_tekrar"]);
/*
$unvan				= $gvn->html_temizle($_POST["unvan"]);
$vergi_no			= $gvn->html_temizle($_POST["vergi_no"]);
$vergi_dairesi		= $gvn->html_temizle($_POST["vergi_dairesi"]);
$adres				= $gvn->html_temizle($_POST["adres"]);
$tcno				= $gvn->rakam($_POST["tcno"]);
$hakkinda			= $gvn->mesaj(htmlspecialchars($_POST["hakkinda"],ENT_QUOTES));
*/
$telefond			= $gvn->zrakam($_POST["telefond"]);
$sabittelefond		= $gvn->zrakam($_POST["sabittelefond"]);
$epostad			= $gvn->zrakam($_POST["epostad"]);
$avatard			= $gvn->zrakam($_POST["avatard"]);
$sms_izin			= $gvn->zrakam($_POST["sms_izin"]);
$mail_izin			= $gvn->zrakam($_POST["mail_izin"]);
$avatar				= $_FILES["avatar"];
$hakkinda			= $gvn->filtre($_POST["hakkinda"]);

if($fonk->bosluk_kontrol($adsoyad) == true){
die('<span class="error" >'.dil("TX14").'</span>');
}elseif($gvn->eposta_kontrol($email) == false){
die('<span class="error" >'.dil("TX15").'</span>');
}



if($avatar["tmp_name"] != ''){
$max_size				= 2097152; // Y?klyeyece?i her resim i?in max 2Mb boyut siniri a?arsa resim y?klenmez!
$allow_exten			= array('.jpg','.jpeg','.png'); // ?zin verilen uzant?lar...
$file					= $avatar;

$tmp	= $file["tmp_name"]; // Kaynak ?ekiyoruz
$xadi	= $file["name"]; // Dosya ad?n? al?yoruz..
$size	= $file["size"]; // Boyutunu al?yoruz
$uzanti	= $fonk->uzanti($xadi); // Uzant?s?n? al?yoruz
if($size <= $max_size){ // Boyutu max boyutu ge?miyorsa devam ediyoruz
if(in_array($uzanti,$allow_exten)){ // izin verilen uzant?larda ise devam ediyoruz
$watermark		= '';
$exmd			= strtolower(substr(md5(uniqid(rand())), 0,18));
$randnm			= $exmd.$uzanti;
$resim			= $fonk->resim_yukle(true,$file,$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['avatar']['thumb_x'],$gorsel_boyutlari['avatar']['thumb_y'],true); // K???k
$resim			= $fonk->resim_yukle(false,$file,$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['avatar']['orjin_x'],$gorsel_boyutlari['avatar']['orjin_y'],true); // B?y?k boy
if($resim != ''){ // E?er resim y?klenmi?se...

}else{ // E?er resim y?klenmi?se...
die('<span class="error" >Image Upload is Failed!</span>');
}
}else{ // izin verilen uzant?larda ise devam ediyoruz end
die('<span class="error" >'.dil("TX355").'</span>');
}
}else{
die('<span class="error" >'.dil("TX354").'</span>');
}
}




$kontrol2		= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND durum=1 AND (email=? OR ip=?) ");
$kontrol2->execute(array($email,$ip));

if($kontrol2->rowCount() > 0 ){
die('<span class="error" >'.dil("TX16").'</span>');
}

$kontrol		= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND email=?");
$kontrol->execute(array($email));

if($kontrol->rowCount() > 0 ){
die('<span class="error" >'.dil("TX17").'</span>');
}


if($telefon != ''){
$kontrol3		= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND telefon=?");
$kontrol3->execute(array($telefon));
if($kontrol3->rowCount() > 0 ){
die('<span class="error" >'.dil("TX18").'</span>');
}
}


if($fonk->bosluk_kontrol($parola) == true){
die('<span class="error">'.dil("TX34").'</span>');
}elseif($fonk->bosluk_kontrol($parola_tekrar) == true){
die('<span class="error">'.dil("TX35").'</span>');
}

if($parola_tekrar != $parola){
die('<span class="error" >'.dil("TX20").'');
}


try{

$sql		= $db->prepare("INSERT INTO hesaplar SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_333=333,site_id_335=335,site_id_334=334,site_id_306=306,site_id_222=222,site_id_111=111,turu=?,adi=?,soyadi=?,telefon=?,email=?,sms_izin=?,mail_izin=?,sabit_telefon=?,telefond=?,sabittelefond=?,epostad=?,avatard=?,nick_adi=?,parola=?,avatar=?,kid=?,olusturma_tarih=?,hakkinda=?,pid=?");
$sql->execute(array($turu,$adi,$soyadi,$telefon,$email,$sms_izin,$mail_izin,$sabit_telefon,$telefond,$sabittelefond,$epostad,$avatard,$nick_adi,$parola,$resim,$hesap->id,$fonk->datetime(),$hakkinda,$pid));

$acid		= $db->lastInsertId();

}catch(PDOException $e){
die($e->getMessage());
}

$baskasi		= $db->prepare("SELECT nick_adi FROM hesaplar WHERE site_id_555=999 AND nick_adi=? AND id!=?");
$baskasi->execute(array($nick_adi,$acid));
if($baskasi->rowCount()>0){
$nick_adi		.= "-".$acid;
$nup			= $db->prepare("UPDATE hesaplar SET nick_adi=? WHERE site_id_555=999 AND id=".$acid);
$nup->execute(array($nick_adi));
}

$fonk->yonlendir("eklenen-danismanlar",2000);
?>
<script>
$("#DanismanEkleForm").slideUp(500,function(){
$("#TamamDiv").slideDown(500);
});
$('html, body').animate({scrollTop: 250}, 500);
</script>
<?


}
}
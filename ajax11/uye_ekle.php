<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$adsoyad			= $gvn->html_temizle($_POST["adsoyad"]);
$ayr				= @explode(" ",$adsoyad);
$soyadi				= end($ayr);
array_pop($ayr);
$adi				= implode(" ",$ayr);
$email				= $gvn->html_temizle($_POST["email"]);
$dunvan				= $gvn->html_temizle($_POST["dunvan"]);
$webadres			= $gvn->html_temizle($_POST["webadres"]);
$telefon			= $gvn->rakam($_POST["telefon"]);
$sabit_telefon		= $gvn->rakam($_POST["sabit_telefon"]);
$parola				= $gvn->html_temizle($_POST["parola"]);
$durum				= 0;
$turu				= $gvn->zrakam($_POST["turu"]);
$ilan_aktifet		= $gvn->zrakam($_POST["ilan_aktifet"]);
$adres				= $gvn->html_temizle($_POST["adres"]);
$tcno				= $gvn->rakam($_POST["tcno"]);
$unvan				= $gvn->html_temizle($_POST["unvan"]);
$vergi_no			= $gvn->html_temizle($_POST["vergi_no"]);
$vergi_dairesi		= $gvn->html_temizle($_POST["vergi_dairesi"]);
$vergi_dairesi		= $gvn->html_temizle($_POST["vergi_dairesi"]);
$nick_adi			= $gvn->html_temizle($_POST["nick_adi"]);
$hakkinda			= $_POST["hakkinda"];
$ulke_id			= $gvn->zrakam($_POST["ulke_id"]);
$il					= $gvn->zrakam($_POST["il"]);
$ilce				= $gvn->zrakam($_POST["ilce"]);
$mahalle			= $gvn->zrakam($_POST["mahalle"]);
$maps				= $gvn->html_temizle($_POST["maps"]);
$kid				= ($turu == 2) ? $gvn->zrakam($_POST["kid"]) : 0;
$onecikar			= $gvn->zrakam($_POST["onecikar"]);
$onecikar_btarih	= $gvn->html_temizle($_POST["onecikar_btarih"]);
$onecikar_btarih	= ($onecikar_btarih == '') ? '' : date("Y-m-d",strtotime($onecikar_btarih))." 23:59:59";


if($fonk->bosluk_kontrol($adsoyad) == true OR $fonk->bosluk_kontrol($email) == true OR $fonk->bosluk_kontrol($parola) == true){
die($fonk->ajax_uyari("Lütfen adı soyadı, email ve parola alanlarını boş bırakmayınız."));
}

if($nick_adi == ''){
if(($turu == 0 || $turu == 2) && ($adi != '' || $soyadi != '')){
$nick_adi			= $adi;
$nick_adi			.= ($soyadi != '') ? $soyadi : '';
$nick_adi			= $gvn->PermaLink($nick_adi);
}elseif($turu == 1 && $unvan != ''){
$nick_adi			= $gvn->PermaLink($unvan);
}elseif($turu == 1 && $unvan == ''){
$nick_adi			= $adi;
$nick_adi			.= ($soyadi != '') ? $soyadi : '';
$nick_adi			= $gvn->PermaLink($nick_adi);
}
}else{
$nick_adi			= $gvn->PermaLink($nick_adi);
}

$resim1tmp		= $_FILES['avatar']["tmp_name"];
$resim1nm		= $_FILES['avatar']["name"];
if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,14)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'avatar',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['avatar']['thumb_x'],$gorsel_boyutlari['avatar']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'avatar',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['avatar']['orjin_x'],$gorsel_boyutlari['avatar']['orjin_y']);
}


$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{

$gunc		= $db->prepare("INSERT INTO hesaplar SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_333=333,site_id_335=335,site_id_334=334,site_id_306=306,site_id_222=222,site_id_111=111,adi=?,soyadi=?,email=?,dunvan=?,telefon=?,webadres=?,parola=?,durum=?,turu=?,nick_adi=?,sabit_telefon=?,unvan=?,vergi_no=?,vergi_dairesi=?,adres=?,tcno=?,avatar=?,hakkinda=?,kid=?,ilan_aktifet=?,onecikar=?,onecikar_btarih=?,ulke_id=?,il_id=?,ilce_id=?,mahalle_id=?,maps=?,olusturma_tarih=? ");
$gunc->execute(array($adi,$soyadi,$email,$dunvan,$telefon,$webadres,$parola,$durum,$turu,$nick_adi,$sabit_telefon,$unvan,$vergi_no,$vergi_dairesi,$adres,$tcno,$resim,$hakkinda,$kid,$ilan_aktifet,$onecikar,$onecikar_btarih,$ulke_id,$il,$ilce,$mahalle,$maps,$fonk->datetime()));

}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Üye Başarıyla Oluşturuldu."); 
$fonk->yonlendir("index.php?p=uyeler&turu=".$turu);


}
}
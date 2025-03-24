<?php
if($hesap->id == ''){ 
die();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id			= $gvn->rakam($_GET["id"]);
$periyodu	= $gvn->zrakam($_GET["periyod"]);
$odeme		= $gvn->harf_rakam($_GET["odeme"]);

if($id == 0 || strlen($periyodu) > 3 || strlen($periyodu) < 1 || !is_numeric($periyodu)){
die();
}


$sorgula	= $db->prepare("SELECT * FROM uyelik_paketleri_19541956 WHERE id=?");
$sorgula->execute(array($id));
if($sorgula->rowCount()<1){
die();
}
$paket		= $sorgula->fetch(PDO::FETCH_OBJ);
$ucretler	= json_decode($paket->ucretler,true);
$secilen	= $ucretler[$periyodu];


if($secilen["periyod"] == ''){
die();
}


if($_SESSION["custom"] == '' && $odeme == "paypal"){
die('<span class="error">Hay aksi bir sorun oluştu. Lütfen tekrar deneyiniz.</span>');
}


if($odeme == "paypal"){ // PayPal geliyorsa...

$customs		= $_SESSION["custom"];
$custom			= base64_decode($customs);
$custom			= json_decode($custom,true);
if($custom["satis"] != "uyelik_paketi"){
die('<span class="error">Hay aksi bir sorun oluştu. Lütfen tekrar deneyiniz.</span>');
}

$fiyat_int	= $secilen["tutar"];
?>
<script type="text/javascript">
$("#OdemeButon").slideUp(500,function(){
$("#SipGoster").slideDown(500);
});

function PayPal_Yonlendir(){
$("#PaypalLocation").submit();
}
setTimeout("PayPal_Yonlendir();",500);
</script>
<FORM ACTION="https://www.paypal.com/cgi-bin/webscr" METHOD="POST" id="PaypalLocation">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?=$gayarlar->paypal_odeme_email;?>">
<input type="hidden" name="item_number" value="<? echo time(); ?>">
<input type="hidden" name="custom" value="<? echo $customs;?>">
<input type="hidden" name="cancel_return" value="<?=SITE_URL."odeme-basarisiz";?>">
<input type="hidden" name="amount" value="<?=$fiyat_int;?>">
<input type="hidden" name="currency_code" value="<?=$fonk->currency_code(dil("UYELIKP_PBIRIMI"));?>">
<input type="hidden" name="item_name" value="<? echo $fonk->eng_cevir($paket->baslik." ".dil("PAY_NAME2")); ?>">
</FORM>
<?
} // Ödeme PayPal ise End...

if($odeme == "havale_eft"){ // Banka Havale / EFT geliyorsa...
$odeme_yontemi	= "Ücretsiz Kayıt";
$tarih			= $fonk->datetime();
$durum			= 0;
$hesap_id		= $hesap->id;

$hesapp			= $hesap;
$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $paket->baslik." ".dil("PAY_NAME2");


$fiyat			= $gvn->para_str($secilen["tutar"])." ".dil("UYELIKP_PBIRIMI");
$neresi			= "paketlerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparisiniz_alindi",$hesapp->email,$hesapp->telefon);


$expiry			= "+".$secilen["sure"];
$expiry			.= ($secilen["periyod"] == "gunluk") ? ' day' : '';
$expiry			.= ($secilen["periyod"] == "aylik") ? ' month' : '';
$expiry			.= ($secilen["periyod"] == "yillik") ? ' year' : '';
$btarih			= date("Y-m-d",strtotime($expiry))." 23:59:59";

try{
$query			= $db->prepare("INSERT INTO upaketler_19541956 SET acid=?,pid=?,adi=?,tutar=?,durum=?,odeme_yontemi=?,tarih=?,btarih=?,sure=?,periyod=?,aylik_ilan_limit=?,ilan_resim_limit=?,ilan_yayin_sure=?,ilan_yayin_periyod=?,danisman_limit=?,danisman_onecikar=?,danisman_onecikar_sure=?,danisman_onecikar_periyod=?");
$query->execute(array($hesap_id,$paket->id,$paket->baslik,$secilen["tutar"],$durum,$odeme_yontemi,$tarih,$btarih,$secilen["sure"],$secilen["periyod"],$paket->aylik_ilan_limit,$paket->ilan_resim_limit,$paket->ilan_yayin_sure,$paket->ilan_yayin_periyod,$paket->danisman_limit,$paket->danisman_onecikar,$paket->danisman_onecikar_sure,$paket->danisman_onecikar_periyod));
}catch(PDOException $e){
die($e->getMessage());
}



$fonk->yonlendir("paketlerim",3000);
?><script type="text/javascript">
$("#OdemePencere").hide(100,function(){
$("#TamamDiv").show(100);
});
$('html, body').animate({scrollTop: 250}, 500);
</script><?

} // Ödeme Havale/EFT ise End..
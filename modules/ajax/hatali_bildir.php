<?php
if($hesap->id == ''){
die();
}
if(!$_POST){
die();
}

$id				= $gvn->rakam($_GET["id"]);
$ipi			= $fonk->IpAdresi();
$mesaj			= $gvn->mesaj(htmlspecialchars($_POST["mesaj"],ENT_QUOTES));

if($fonk->bosluk_kontrol($mesaj)==true AND strlen($mesaj) < 5){
die('<span class="error">'.dil("TX448").'</span>');
}


$kontrol		= $db->prepare("SELECT id,url,baslik FROM sayfalar WHERE site_id_555=999 AND id=? AND tipi=4");
$kontrol->execute(array($id));

if($kontrol->rowCount()==0){
die();
}
$ilan			= $kontrol->fetch(PDO::FETCH_OBJ);
$ilan_linki		= ($dayarlar->permalink == 'Evet') ? SITE_URL.$ilan->url.".html" : SITE_URL."index.php?p=sayfa&id=".$ilan->id;
$customs		= array();

$customs["acid"] = $hesap->id;
$customs["ilan_id"] = $ilan->id;



$like1			= '"acid":'.$hesap->id.',';
$like2			= '"ilan_id":'.$ilan->id;
$varmi			= $db->prepare("SELECT * FROM mail_19541956 WHERE tipi=1 AND customs LIKE '%".$like1."%' AND customs LIKE '%".$like2."%' AND ip=? AND tarih BETWEEN DATE_SUB(NOW(), INTERVAL 10 MINUTE) AND NOW()");
$varmi->execute(array($ipi));
if($varmi->rowCount() > 0){
die(dil("TX435"));
}


$customs		= $fonk->json_encode_tr($customs);
if($hesap->unvan != ''){
$adsoyad		= $hesap->unvan;
}else{
$adsoyad		= $hesap->adi;
$adsoyad		.= ($hesap->soyadi == '') ?  '' : ' '.$hesap->soyadi;
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
$ekle			= $db->prepare("INSERT INTO mail_19541956 SET tipi=?,adsoyad=?,email=?,telefon=?,tarih=?,mesaj=?,ip=?,customs=?");
$ekle->execute(array(1,$adsoyad,$hesap->email,$hesap->telefon,$fonk->datetime(),$mesaj,$ipi,$customs));
}catch(PDOException $e){
die($e->getMessage());
}

?>
<script type="text/javascript">
$("#HataliBildirForm").slideUp(500,function(){
$("#BiTamamPnc").slideDown(500);
});
</script>
<?

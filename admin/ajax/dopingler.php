<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$sil			= $gvn->rakam($_GET["sil"]);
$onayla			= $gvn->rakam($_GET["onayla"]);
if($sil != ""){
$db->query("DELETE FROM dopingler_group_19541956 WHERE id=".$sil." ");
$db->query("DELETE FROM dopingler_19541956 WHERE gid=".$sil." ");
?>
<script type="text/javascript">
$(document).ready(function(){
$("#doping<?=$sil;?>").fadeOut(500,function(){
$("#doping<?=$sil;?>").remove();
});
});
</script>
<?
$fonk->ajax_tamam("Paket Silindi");
}elseif($onayla != ""){

$sip			= $db->query("SELECT * FROM dopingler_group_19541956 WHERE id=".$onayla)->fetch(PDO::FETCH_OBJ);
$hesapp			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$sip->acid)->fetch(PDO::FETCH_OBJ);
$snc			= $db->query("SELECT id,baslik FROM sayfalar WHERE site_id_555=999 AND id=".$sip->ilan_id)->fetch(PDO::FETCH_OBJ);

$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $snc->baslik." ".dil("PAY_NAME");

$fiyat			= $gvn->para_str($sip->tutar)." ".dil("DOPING_PBIRIMI");
$neresi			= "dopinglerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparis_onaylandi",$hesapp->email,$hesapp->telefon);


$db->query("UPDATE dopingler_group_19541956 SET durum='1' WHERE id=".$onayla." ");
$db->query("UPDATE dopingler_19541956 SET durum='1' WHERE gid=".$onayla." ");
?>
<script type="text/javascript">
$(document).ready(function(){
$("#doping<?=$onayla;?>_durum").html('<strong style="color:green">Onaylandı</strong>');
});
</script>
<?
}


}
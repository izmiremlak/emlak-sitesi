<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$sil			= $gvn->rakam($_GET["sil"]);
$onayla			= $gvn->rakam($_GET["onayla"]);
if($sil != ""){
$db->query("DELETE FROM upaketler_19541956 WHERE id=".$sil." ");
?>
<script type="text/javascript">
$(document).ready(function(){
$("#upaket<?=$sil;?>").fadeOut(500,function(){
$("#upaket<?=$sil;?>").remove();
});
});
</script>
<?
$fonk->ajax_tamam("Paket Silindi");
}elseif($onayla != ""){

$paket			= $db->query("SELECT * FROM upaketler_19541956 WHERE id=".$onayla)->fetch(PDO::FETCH_OBJ);
$hesapp			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$paket->acid)->fetch(PDO::FETCH_OBJ);


$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$baslik			= $paket->adi." ".dil("PAY_NAME2");


$fiyat			= $gvn->para_str($paket->tutar)." ".dil("UYELIKP_PBIRIMI");
$neresi			= "paketlerim";

$fonk->bildirim_gonder(array($adsoyad,$hesapp->email,$hesapp->parola,$baslik,$fiyat,date("d.m.Y H:i",strtotime($fonk->datetime())),SITE_URL.$neresi),"siparis_onaylandi",$hesapp->email,$hesapp->telefon);


$db->query("UPDATE upaketler_19541956 SET durum='1' WHERE id=".$onayla." ");
?>
<script type="text/javascript">
$(document).ready(function(){
$("#upaket<?=$onayla;?>_durum").html('<strong style="color:green">Onaylandı</strong>');
});
</script>
<?
}


}
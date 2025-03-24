<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik						= $gvn->html_temizle($_POST["baslik"]);
$sira						= $gvn->zrakam($_POST["sira"]);
$renk						= $gvn->html_temizle($_POST["renk"]);
$gizle						= $gvn->zrakam($_POST["gizle"]);
$aylik_ilan_limit			= $gvn->zrakam($_POST["aylik_ilan_limit"]);
$ilan_resim_limit			= $gvn->zrakam($_POST["ilan_resim_limit"]);
$danisman_limit				= $gvn->zrakam($_POST["danisman_limit"]);
$ilan_yayin_sure			= $gvn->zrakam($_POST["ilan_yayin_sure"]);
$ilan_yayin_periyod			= $gvn->harf_rakam($_POST["ilan_yayin_periyod"]);
$danisman_onecikar			= $gvn->zrakam($_POST["danisman_onecikar"]);
$danisman_onecikar_sure		= $gvn->zrakam($_POST["danisman_onecikar_sure"]);
$danisman_onecikar_periyod	= $gvn->harf_rakam($_POST["danisman_onecikar_periyod"]);
$sureler					= $_POST["sure"];
$periyodlar					= $_POST["periyod"];
$tutarlar					= $_POST["tutar"];
$ucretler					= array();

if($fonk->bosluk_kontrol($baslik)==true){
die($fonk->ajax_hata("Lütfen başlık belirtiniz."));
}

if($fonk->bosluk_kontrol($renk)==true){
die($fonk->ajax_hata("Lütfen renk seçiniz."));
}



for($i=0;$i<=count($sureler);$i++){
if($periyodlar[$i] != ''){
$sure				= $gvn->zrakam($sureler[$i]);
$periyodu			= $gvn->harf_rakam($periyodlar[$i]);
$tutar				= $gvn->prakam($tutarlar[$i]);
$tutar				= $gvn->para_int($tutar);
$ucretler[]			= array('sure' => $sure,'periyod' => $periyodu,'tutar' => $tutar);
}
}
$ucretler			= $fonk->json_encode_tr($ucretler);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
$query				= $db->prepare("INSERT INTO uyelik_paketleri_19541956 SET baslik=?,sira=?,renk=?,gizle=?,aylik_ilan_limit=?,ilan_resim_limit=?,ilan_yayin_sure=?,ilan_yayin_periyod=?,danisman_limit=?,danisman_onecikar=?,danisman_onecikar_sure=?,danisman_onecikar_periyod=?,ucretler=?,tarih=?");
$query->execute(array($baslik,$sira,$renk,$gizle,$aylik_ilan_limit,$ilan_resim_limit,$ilan_yayin_sure,$ilan_yayin_periyod,$danisman_limit,$danisman_onecikar,$danisman_onecikar_sure,$danisman_onecikar_periyod,$ucretler,$fonk->datetime()));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Paket Başarıyla Oluşturuldu.");
$fonk->yonlendir("index.php?p=uyelik_paketleri",1000);


}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$title			= $gvn->html_temizle($_POST["title"]);
$keywords		= $gvn->html_temizle($_POST["keywords"]);
$description	= $gvn->html_temizle($_POST["description"]);
$facebook		= $gvn->html_temizle($_POST["facebook"]);
$twitter		= $gvn->html_temizle($_POST["twitter"]);
$instagram		= $gvn->html_temizle($_POST["instagram"]);
$google			= $gvn->html_temizle($_POST["google"]);
$google_maps	= $gvn->html_temizle($_POST["google_maps"]);
$slogan1		= $gvn->html_temizle($_POST["slogan1"]);
$slogan2		= $gvn->html_temizle($_POST["slogan2"]);
$slogan3		= $gvn->html_temizle($_POST["slogan3"]);
$telefon		= $gvn->html_temizle($_POST["telefon"]);
$faks			= $gvn->html_temizle($_POST["faks"]);
$gsm			= $gvn->html_temizle($_POST["gsm"]);
$email			= $gvn->html_temizle($_POST["email"]);
$adres			= $_POST["adres"];
$analytics		= $_POST["analytics"];
$verification	= $_POST["verification"];
$embed			= $_POST["embed"];
$google_api_key	= $_POST["google_api_key"];



try{
    $guncelle		= $db->prepare("UPDATE gayarlar_19541956 SET google_api_key=?");
    $guncelle->execute(array($google_api_key));
}catch(PDOException $e){
    die("Hata : ".$e->getMessage());
}


$guncelle		= $db->prepare("UPDATE ayarlar_19541956 SET title=:titlex,keywords=:keywordsx,description=:descriptionx,facebook=:facebookx,twitter=:twitterx,instagram=:instagramx,google=:googlex,slogan1=:slogan1x,slogan2=:slogan2x,slogan3=:slogan3x,telefon=:telefonx,faks=:faksx,gsm=:gsmx,email=:emailx,adres=:adresx,analytics=:analyticsx,google_maps=:maps,embed=:emb,verification=:ver WHERE dil=:dilx");
$guncelle->execute(array(
'titlex' => $title,
'keywordsx' => $keywords,
'descriptionx' => $description,
'facebookx' => $facebook,
'twitterx' => $twitter,
'instagramx' => $instagram,
'googlex' => $google,
'slogan1x' => $slogan1,
'slogan2x' => $slogan2,
'slogan3x' => $slogan3,
'telefonx' => $telefon,
'faksx' => $faks,
'gsmx' => $gsm,
'emailx' => $email,
'adresx' => $adres,
'analyticsx' => $analytics,
'maps' => $google_maps,
'emb'  => $embed,
'ver'  => $verification,
'dilx' => $dil
));

if($guncelle){
$fonk->ajax_tamam("Site Bilgileri Güncellendi. ");
}else{
$fonk->ajax_hata("Bir Hata Oluştu!");
}



}
}
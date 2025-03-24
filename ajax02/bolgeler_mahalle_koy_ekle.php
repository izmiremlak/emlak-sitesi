<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$ilce_id		= $gvn->rakam($_GET["ilce_id"]);
$adi			= $gvn->html_temizle($_POST["adi"]);
$semt_id		= $gvn->zrakam($_POST["semt"]);


if($fonk->bosluk_kontrol($ilce_id)==true){
die($fonk->ajax_uyari("Lütfen ilçe seçiniz."));
}

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$snc		= $db->prepare("SELECT * FROM ilce WHERE id=:ids");
$snc->execute(array('ids' => $ilce_id));
if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$slug			= $gvn->PermaLink($adi);
$il_slug		= $db->query("SELECT slug FROM il WHERE id=".$snc->il_id)->fetch(PDO::FETCH_OBJ)->slug;
$ilce_slug		= $snc->slug;
$slug2			= $il_slug."-".$ilce_slug."-".$slug;

$ekle			= $db->prepare("INSERT INTO mahalle_koy SET il_id=?,ilce_id=?,semt_id=?,ulke_id=?,mahalle_adi=?,slug=?,slug2=? ");
$ekle->execute(array($snc->il_id,$snc->id,$semt_id,$snc->ulke_id,$adi,$slug,$slug2));



$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=bolgeler_ilce&id=".$ilce_id,1000);


}
}
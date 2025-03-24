<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$ulke_id		= $gvn->rakam($_GET["ulke_id"]);
$adi			= $gvn->html_temizle($_POST["adi"]);

if($fonk->bosluk_kontrol($ulke_id)==true){
die($fonk->ajax_uyari("Lütfen ülke seçiniz."));
}

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$slug			= $gvn->PermaLink($adi);


$ekle			= $db->prepare("INSERT INTO il SET ulke_id=?,il_adi=?,slug=? ");
$ekle->execute(array($ulke_id,$adi,$slug));

if($ekle){
$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=bolgeler_ulke&id=".$ulke_id,1000);
}


}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$adi			= $gvn->html_temizle($_POST["adi"]);

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$slug			= $gvn->PermaLink($adi);


$ekle			= $db->prepare("INSERT INTO ulkeler_19541956 SET ulke_adi=?,slug=? ");
$ekle->execute(array($adi,$slug));

if($ekle){
$fonk->ajax_tamam("Başarıyla Eklendi.");
$fonk->yonlendir("index.php?p=bolgeler",1000);
}


}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM ulkeler_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$adi			= $gvn->html_temizle($_POST["ulke_adi"]);

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$slug			= $gvn->PermaLink($adi);


$ekle			= $db->prepare("UPDATE ulkeler_19541956 SET ulke_adi=?,slug=? WHERE id=".$snc->id);
$ekle->execute(array($adi,$slug));

if($ekle){
$fonk->ajax_tamam("Başarıyla Güncellendi.");
}


}
}
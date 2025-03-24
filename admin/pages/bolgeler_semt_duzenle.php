<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM semt WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$adi			= $gvn->html_temizle($_POST["adi"]);

if($fonk->bosluk_kontrol($adi)==true){
die($fonk->ajax_uyari("Lütfen bir isim belirleyin."));
}

$slug			= $gvn->PermaLink($adi);


$ekle			= $db->prepare("UPDATE semt SET semt_adi=? WHERE id=".$snc->id);
$ekle->execute(array($adi));


$fonk->ajax_tamam("Başarıyla Güncellendi.");
$fonk->yonlendir("index.php?p=bolgeler_ilce&id=".$snc->ilce_id,500);


}
}
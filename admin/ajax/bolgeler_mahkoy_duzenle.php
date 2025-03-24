<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM mahalle_koy WHERE id=:ids");
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
$il_slug		= $db->query("SELECT slug FROM il WHERE id=".$snc->il_id)->fetch(PDO::FETCH_OBJ)->slug;
$ilce_slug		= $db->query("SELECT slug FROM ilce WHERE id=".$snc->ilce_id)->fetch(PDO::FETCH_OBJ)->slug;
$slug2			= $il_slug."-".$ilce_slug."-".$slug;


$ekle			= $db->prepare("UPDATE mahalle_koy SET mahalle_adi=?,slug=?,slug2=? WHERE id=".$snc->id);
$ekle->execute(array($adi,$slug,$slug2));


$fonk->ajax_tamam("Başarıyla Güncellendi.");
$fonk->yonlendir("index.php?p=bolgeler_ilce&id=".$snc->ilce_id,500);


}
}
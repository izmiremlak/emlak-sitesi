<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM kategoriler_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


if($_POST){

$baslik			= $gvn->html_temizle($_POST["baslik"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$url			= $gvn->PermaLink($baslik);


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("Lütfen başlık yazınız."));
}


## PermaLink Control Start ##
$kcvr			= $db->prepare("SELECT id FROM kategoriler_19541956 WHERE baslik=:baslik AND id!=".$snc->id." AND url=:urls AND dil='".$dil."' ");
$kcvr->execute(array('baslik' => $baslik,'urls' => $url));
$kcvr			= $kcvr->rowCount();
if($kcvr > 0 ){
$tpla			= $kcvr+1;
$url			.= '_'.$tpla;
}
## PermaLink Control End ##



$sql			= $db->prepare("UPDATE kategoriler_19541956 SET baslik=:baslik,url=:url,sira=:siras WHERE id=".$snc->id);

  $sql->execute(array(
'baslik' => $baslik,
'url' => $url,
'siras' => $sira
));
    
	

if($sql){
$fonk->ajax_tamam("Referans Kategori Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}



}
}
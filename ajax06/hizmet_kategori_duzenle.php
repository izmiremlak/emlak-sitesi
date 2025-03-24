<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM kategoriler_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$baslik			= $gvn->html_temizle($_POST["baslik"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$icerik			= $_POST["icerik"];
$url			= $gvn->PermaLink($baslik);
$title			= $gvn->html_temizle($_POST["title"]);
$keywords		= $gvn->html_temizle($_POST["keywords"]);
$description	= $gvn->html_temizle($_POST["description"]);


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("Lütfen baþlýk yazýnýz."));
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



$sql			= $db->prepare("UPDATE kategoriler_19541956 SET baslik=:baslik,url=:url,title=:title,keywords=:keywords,description=:description,sira=:siras WHERE id=".$snc->id);

  $sql->execute(array(
'baslik' => $baslik,
'url' => $url,
'title' => $title,
'keywords' => $keywords,
'description' => $description,
'siras' => $sira
));
    
	

if($sql){
$fonk->ajax_tamam("Hizmet Kategori Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluþtu.");
}




}
}
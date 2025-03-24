<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){
$tarih			= $fonk->datetime();
$baslik			= $gvn->html_temizle($_POST["baslik"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$url			= $gvn->PermaLink($baslik);



if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("Lütfen başlık yazınız."));
}


## PermaLink Control Start ##
$kcvr			= $db->prepare("SELECT id FROM kategoriler_19541956 WHERE baslik=:baslik AND dil='".$dil."' ");
$kcvr->execute(array('baslik' => $baslik));
$kcvr			= $kcvr->rowCount();
if($kcvr > 0 ){
$tpla			= $kcvr+1;
$url			.= '_'.$tpla;
}
## PermaLink Control End ##


$sql			= $db->prepare("INSERT INTO kategoriler_19541956 SET dil=:dil,baslik=:baslik,url=:url,tarih=:tarih,sira=:sira,tipi=:tipi ");

  $sql->execute(array(
'dil' => $dil,
'baslik' => $baslik,
'url' => $url,
'tarih' => $tarih,
'sira' => $sira,
'tipi' => 3,
));
    
	

if($sql){
$fonk->ajax_tamam("Referans Kategori Eklendi.");
$fonk->yonlendir("index.php?p=referans_kategoriler",3000);
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}
}
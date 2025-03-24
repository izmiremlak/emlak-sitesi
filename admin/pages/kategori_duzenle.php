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
$ustu			= $gvn->zrakam($_POST["ustu"]);
$icerik			= $_POST["icerik"];
$url			= $gvn->PermaLink($baslik);
$title			= $gvn->html_temizle($_POST["title"]);
$keywords		= $gvn->html_temizle($_POST["keywords"]);
$description	= $gvn->html_temizle($_POST["description"]);


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

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

$resim2tmp		= $_FILES['resim2']["tmp_name"];
$resim2nm		= $_FILES['resim2']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['kategoriler']['resim1']['thumb_x'],$gorsel_boyutlari['kategoriler']['resim1']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['kategoriler']['resim1']['orjin_x'],$gorsel_boyutlari['kategoriler']['resim1']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE kategoriler_19541956 SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","../uploads/thumb/<?=$resim;?>");
});
</script><?
}

}

if($resim2tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim2nm);
$resim2			= $fonk->resim_yukle(true,'resim2',$randnm,'../uploads',$gorsel_boyutlari['kategoriler']['resim2']['thumb_x'],$gorsel_boyutlari['kategoriler']['resim2']['thumb_y']);
$resim2			= $fonk->resim_yukle(false,'resim2',$randnm,'../uploads',$gorsel_boyutlari['kategoriler']['resim2']['orjin_x'],$gorsel_boyutlari['kategoriler']['resim2']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE kategoriler_19541956 SET resim2=:image WHERE id=:id");
$avgn->execute(array('image' => $resim2, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim2_src').attr("src","../uploads/thumb/<?=$resim2;?>");
});
</script><?
}

}


$sql			= $db->prepare("UPDATE kategoriler_19541956 SET baslik=:baslik,url=:url,icerik=:icerik,title=:title,keywords=:keywords,description=:description,sira=:siras,ustu=:ustus WHERE id=".$snc->id);

  $sql->execute(array(
'baslik' => $baslik,
'url' => $url,
'icerik' => $icerik,
'title' => $title,
'keywords' => $keywords,
'description' => $description,
'siras' => $sira,
'ustus' => $ustu,
));
    
	

if($sql){
$fonk->ajax_tamam("Kategori Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}
}
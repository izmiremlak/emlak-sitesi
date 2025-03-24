<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){
$tipi			= 2;
$tarih			= $fonk->datetime();
$ekleyen		= $hesap->id;
$baslik			= $gvn->html_temizle($_POST["baslik"]);
$icerik			= $_POST["icerik"];
$url			= $gvn->PermaLink($baslik);
$title			= $gvn->html_temizle($_POST["title"]);
$keywords		= $gvn->html_temizle($_POST["keywords"]);
$description	= $gvn->html_temizle($_POST["description"]);


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("Lütfen başlık yazınız."));
}


## PermaLink Control Start ##
$kcvr			= $db->prepare("SELECT id FROM sayfalar WHERE site_id_555=888 AND baslik=:baslik AND dil='".$dil."' ");
$kcvr->execute(array('baslik' => $baslik));
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
#$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$randnm			= $url.$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['haber_ve_duyurular']['resim1']['thumb_x'],$gorsel_boyutlari['haber_ve_duyurular']['resim1']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['haber_ve_duyurular']['resim1']['orjin_x'],$gorsel_boyutlari['haber_ve_duyurular']['resim1']['orjin_y']);
}

if($resim2tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim2nm);
$resim2			= $fonk->resim_yukle(true,'resim2',$randnm,'../uploads',$gorsel_boyutlari['haber_ve_duyurular']['resim2']['thumb_x'],$gorsel_boyutlari['haber_ve_duyurular']['resim2']['thumb_y']);
$resim2			= $fonk->resim_yukle(false,'resim2',$randnm,'../uploads',$gorsel_boyutlari['haber_ve_duyurular']['resim2']['orjin_x'],$gorsel_boyutlari['haber_ve_duyurular']['resim2']['orjin_y']);
}


$sql			= $db->prepare("INSERT INTO sayfalar SET site_id_555=ZZZ,dil=:dil,tipi=:tipi,baslik=:baslik,url=:url,resim=:resim,resim2=:resim2,icerik=:icerik,tarih=:tarih,title=:title,keywords=:keywords,description=:description,ekleyen=:ekleyen");

  $sql->execute(array(
'dil' => $dil,
'tipi' => $tipi,
'baslik' => $baslik,
'url' => $url,
'resim' => $resim,
'resim2' => $resim2,
'icerik' => $icerik,
'tarih' => $tarih,
'title' => $title,
'keywords' => $keywords,
'description' => $description,
'ekleyen' => $ekleyen
));
    
	

if($sql){
$fonk->ajax_tamam("Haberler Eklendi.");
$fonk->yonlendir("index.php?p=haber_ve_duyurular",3000);
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}
}
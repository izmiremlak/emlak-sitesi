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



$galeri		= $_GET["galeri"];
if($galeri == 1){
if($_FILES){


$resim1tmp		= $_FILES['file']["tmp_name"];
$resim1nm		= $_FILES['file']["name"];

$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'file',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['thumb_x'],$gorsel_boyutlari['foto_galeri']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'file',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['orjin_x'],$gorsel_boyutlari['foto_galeri']['orjin_y']);
$db->query("INSERT INTO galeri_foto SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_333=333,site_id_335=335,site_id_334=334,site_id_306=306,site_id_222=222,site_id_111=111,galeri_id='".$snc->id."',resim='".$resim."',dil='".$dil."' ");


}
die();
}




if($_POST){



$baslik			= $gvn->html_temizle($_POST["baslik"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$url			= $gvn->PermaLink($baslik);


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("L?tfen ba?l?k yaz?n?z."));
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
$fonk->ajax_tamam("Foto Galeri G?ncellendi.");
}else{
$fonk->ajax_hata("Bir hata olu?tu.");
}



}
}
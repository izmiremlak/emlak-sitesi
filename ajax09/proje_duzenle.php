<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=888 AND id=:ids");
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

$exmd			= strtolower(substr(md5(uniqid(rand())), 0,5));
$randnm			= $snc->url."-".$exmd.$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'file',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim1']['thumb_x'],$gorsel_boyutlari['projeler']['resim1']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'file',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim1']['orjin_x'],$gorsel_boyutlari['projeler']['resim1']['orjin_y']);
$db->query("INSERT INTO galeri_foto SET site_id_555=ZZZ,sayfa_id='".$snc->id."',resim='".$resim."',dil='".$dil."' ");


}
die();
}



if($_POST){

$baslik			= $gvn->html_temizle($_POST["baslik"]);
$kisa_icerik	= $gvn->html_temizle($_POST["kisa_icerik"]);
$turu			= $gvn->zrakam($_POST["turu"]);
$onecikan		= $gvn->zrakam($_POST["onecikan"]);
$kategori_id	= $gvn->zrakam($_POST["kategori_id"]);
$danisman_id	= $gvn->zrakam($_POST["danisman_id"]);
$icerik			= $_POST["icerik"];
$url			= $gvn->PermaLink($baslik);
$title			= $gvn->html_temizle($_POST["title"]);
$keywords		= $gvn->html_temizle($_POST["keywords"]);
$description	= $gvn->html_temizle($_POST["description"]);
$maps			= $gvn->html_temizle($_POST["maps"]);


if($fonk->bosluk_kontrol($baslik) == true){
die($fonk->ajax_hata("Lütfen başlık yazınız."));
}


## PermaLink Control Start ##
$kcvr			= $db->prepare("SELECT id FROM sayfalar WHERE site_id_555=888 AND baslik=:baslik AND id!=".$snc->id." AND url=:urls AND dil='".$dil."' ");
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
#$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$randnm			= $url.$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim1']['thumb_x'],$gorsel_boyutlari['projeler']['resim1']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim1']['orjin_x'],$gorsel_boyutlari['projeler']['resim1']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE sayfalar SET resim=:image WHERE site_id_555=888 AND id=:id");
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
$resim2			= $fonk->resim_yukle(true,'resim2',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim2']['thumb_x'],$gorsel_boyutlari['projeler']['resim2']['thumb_y']);
$resim2			= $fonk->resim_yukle(false,'resim2',$randnm,'../uploads',$gorsel_boyutlari['projeler']['resim2']['orjin_x'],$gorsel_boyutlari['projeler']['resim2']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE sayfalar SET resim2=:image WHERE site_id_555=888 AND id=:id");
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


$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try{

$sql			= $db->prepare("UPDATE sayfalar SET baslik=:baslik,url=:url,icerik=:icerik,title=:title,keywords=:keywords,description=:description,onecikan=:onecikan,kategori_id=:kategori,kisa_icerik=:kisa_icerik,turu=:turu,danisman_id=:danisman,maps=:maps WHERE site_id_555=888 AND id=".$snc->id);

  $sql->execute(array(
'baslik' => $baslik,
'url' => $url,
'icerik' => $icerik,
'title' => $title,
'keywords' => $keywords,
'description' => $description,
'onecikan' => $onecikan,
'kategori' => $kategori_id,
'kisa_icerik' => $kisa_icerik,
'turu' => $turu,
'danisman' => $danisman_id,
'maps' => $maps,
));
    
}catch(PDOException $e){
echo("Bir hata oluştu. ".$e->getMessage());
die();
} 


if($sql){
$fonk->ajax_tamam("Proje Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}



}
<?php if(!defined("THEME_DIR")){die();}
$url 	= $gvn->html_temizle($_GET["url"]);
$id 	= $gvn->rakam($_GET["id"]);

if($dayarlar->permalink == 'Evet'){
$sayfay	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=999 AND url=:urls ");
$sayfay->execute(array('urls' => $url));
$sayfay	= $sayfay->fetch(PDO::FETCH_OBJ);
}else{
$sayfay	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=999 AND id=:ids ");
$sayfay->execute(array('ids' => $id));
$sayfay	= $sayfay->fetch(PDO::FETCH_OBJ);
}

$url		= str_replace(array("../","./","&","?","%"),"",$url);
if(file_exists($url.".html")){
include $url.".html";
die(); exit;
}elseif($sayfay->id == ""){
include "404.php";
die(); exit;
}

if($sayfay->kategori_id != 0){
$kat1			= $db->query("SELECT * FROM kategoriler_19541956 WHERE id=".$sayfay->kategori_id)->fetch(PDO::FETCH_OBJ);


if($kat1->ustu != 0){
$kat2			= $db->query("SELECT * FROM kategoriler_19541956 WHERE id=".$kat1->ustu)->fetch(PDO::FETCH_OBJ);
$kategori		= clone $kat2;
$alt_kategori	= clone $kat1;
}else{
$kategori		= $kat1;
}

if($sayfay->tipi == 3){
$klink 		= ($dayarlar->permalink == 'Evet') ? 'hizmetler/'.$kategori->url : 'index.php?p=hizmetler&id='.$kategori->id;
}elseif($sayfay->tipi == 4){
$klink 		= ($dayarlar->permalink == 'Evet') ? 'kategori/'.$kategori->url : 'index.php?p=kategori&id='.$kategori->id;
$aklink 	= ($dayarlar->permalink == 'Evet') ? 'kategori/'.$alt_kategori->url : 'index.php?p=kategori&id='.$alt_kategori->id;
}

}

if($sayfay->tipi == 4){
include THEME_DIR."ilan_detay.php";
die(); exit;
}elseif($sayfay->tipi == 5){
include THEME_DIR."proje_detay.php";
die(); exit;
}


if($sayfay->tipi == 3){
$category = true;
}else{
$sayfa = true;
}


$sayfaya_gore_headbg		= ($sayfay->tipi == 0) ? 'style="background-image: url(uploads/'.$gayarlar->ekatalog_resim.');"' : '';
$sayfaya_gore_headbg		= ($sayfay->tipi == 1) ? 'style="background-image: url(uploads/'.$gayarlar->yazilar_resim.');"' : $sayfaya_gore_headbg;
$sayfaya_gore_headbg		= ($sayfay->tipi == 2) ? 'style="background-image: url(uploads/'.$gayarlar->haber_ve_duyurular_resim.');"' : $sayfaya_gore_headbg;
$sayfaya_gore_headbg		= ($sayfay->tipi == 3) ? 'style="background-image: url(uploads/'.$gayarlar->hizmetler_resim.');"' : $sayfaya_gore_headbg;

?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=($sayfay->title == '') ? $sayfay->baslik : $sayfay->title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$sayfay->keywords;?>" />
<meta name="description" content="<?=$sayfay->description;?>" />
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<?php include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>


<div class="headerbg" <?=($sayfay->resim2  != '') ? 'style="background-image: url(uploads/'.$sayfay->resim2.');"' : $sayfaya_gore_headbg; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=$sayfay->baslik;?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> 
<? if($sayfay->tipi == 1){ ?><a href="yazilar"><?=dil("TX221");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <? } ?>
<? if($sayfay->tipi == 2){ ?><a href="haber-ve-duyurular"><?=dil("TX222");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <? } ?>
<? if($sayfay->tipi == 3){ ?><a href="hizmetler"><?=dil("TX223");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <? } ?>
<? if($kategori->id != ''){ ?><a href="<?=$klink;?>"><?=$kategori->baslik;?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <? } ?>
<? if($alt_kategori->id != ''){ ?><a href="<?=$aklink;?>"><?=$alt_kategori->baslik;?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <? } ?>
<span><?=$sayfay->baslik;?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">


<div class="content" <?=( ($gayarlar->blog_sidebar == 0 AND $sayfay->tipi == 1) OR ($gayarlar->haberler_sidebar == 0 AND $sayfay->tipi == 2) OR ($gayarlar->sayfa_sidebar == 0 AND $sayfay->tipi == 0) OR ($gayarlar->hizmetler_sidebar == 0 AND $sayfay->tipi == 3)) ? 'id="bigcontent"' : '';?>>

<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="altbaslik">

<h4><strong><?=$sayfay->baslik;?></strong></h4>

</div>

<div class="clear"></div>

<div class="sayfadetay">


<?php
if($gayarlar->reklamlar == 1){ // E?er reklamlar aktif ise...
$detect 	= (!isset($detect)) ? new Mobile_Detect : $detect;
$rtipi		= 4;
$reklamlar	= $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1)");
$rcount		= $reklamlar->rowCount();
$order		= ($rcount>1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
$reklam		= $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) ".$order." LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
if($rcount>0){
?><!-- 336 x 280 Reklam Alan?-->
<div class="ad336x280">
<?=($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu;?>
</div>
<!-- 336 x 280 Reklam Alan? END-->
<? }} // E?er reklamlar aktif ise... ?>

<p><?=$sayfay->icerik;?></p>


<div class="urungiderfotolar gallery">
<?php
$sql		= $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$sayfay->id." AND dil='".$dil."' ORDER BY id DESC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?>
<a href="uploads/<?=$row->resim;?>" rel="prettyPhoto[gallery1]"><img src="uploads/thumb/<?=$row->resim;?>" width="150" height="100"></a>
<? } ?>
</div>


</div>


</div>


<?php
if(($gayarlar->blog_sidebar != 0 AND $sayfay->tipi == 1) OR ($gayarlar->haberler_sidebar != 0 AND $sayfay->tipi == 2) OR ($gayarlar->sayfa_sidebar != 0 AND $sayfay->tipi == 0) OR ($gayarlar->hizmetler_sidebar != 0 AND $sayfay->tipi == 3)){
?>
<div class="sidebar">
<?php
$sayfa = true;
include THEME_DIR."inc/sayfa_sidebar.php"; 
?>
</div>
<? } ?>


<div class="clear"></div>

<? include THEME_DIR."inc/ilanvertanitim.php"; ?>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
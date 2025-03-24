<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX228");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? include THEME_DIR."inc/head.php"; ?>
</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>

<div class="headerbg" <?=($gayarlar->yazilar_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->yazilar_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX228");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <span><strong><?=dil("TX228");?></strong></span>
</div>
</div>

</div>
</div>

<div id="wrapper">


<div class="content" <?=($gayarlar->blog_sidebar == 0) ? 'id="bigcontent"' : '';?>>

<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="altbaslik">

<h4><strong><?=dil("TX228");?></strong></h4>

</div>

<div class="clear"></div>


<?php

$qry		= $pagent->sql_query("SELECT * FROM sayfalar WHERE site_id_555=888 AND tipi=1 AND dil='".$dil."' ORDER BY id DESC",$gvn->rakam($_GET["git"]),5);
$query 		= $db->query($qry['sql']);

if($query->rowCount() > 0 ){
while($ft	= $query->fetch(PDO::FETCH_OBJ)){
$linkx		= ($dayarlar->permalink == 'Evet') ? $ft->url.'.html' : 'index.php?p=sayfa&id='.$ft->id;
$icerik		= strip_tags($ft->icerik);
?>
<div class="listeleme"> 
<div class="listefoto">
<img src="uploads/thumb/<?=$ft->resim;?>" width="210" height="190"></div>
<div class="listeicerik">
<h3><a href="<?=$linkx;?>"><?=$ft->baslik;?></a></h3>
<p><?=$fonk->kisalt($icerik,0,335);?><?=(strlen($icerik) > 335) ? '...' : '';?> <strong><a class="detaylink" href="<?=$linkx;?>"><?=dil("TX137");?></a></strong></p> 
</div>
</div>
<? } ?>

<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele('yazilar?git=',$gvn->rakam($_GET["git"]),$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>


<? }else{ ?>
<b style="color:#aa1818;"><?=dil("TX229");?></b>
<? } ?> 




</div>


<?php
if($gayarlar->blog_sidebar != 0){
?>
<div class="sidebar">
<? include THEME_DIR."inc/sayfa_sidebar.php"; ?>
</div>
<? } ?>


<div class="clear"></div>


<? include THEME_DIR."inc/ilanvertanitim.php"; ?>

</div>

<? include THEME_DIR."inc/footer.php"; ?>
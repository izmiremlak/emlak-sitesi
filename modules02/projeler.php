<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX219");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? $category = true; include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>

<div class="headerbg" <?=($gayarlar->projeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->projeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX219");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <span><strong><?=dil("TX219");?></strong></span>
</div>
</div>

</div>
</div>

<div id="wrapper">


<div class="content" id="bigcontent">

<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="altbaslik">

<h4><strong><?=dil("TX219");?></strong></h4>

</div>

<div class="clear"></div>

<div class="sehirbutonlar" id="projeler">
<div id="sehirbutonlar-container">

<?php
$qry		= $pagent->sql_query("SELECT id,url,baslik,resim FROM sayfalar WHERE site_id_555=888 AND tipi=5 AND dil='".$dil."' ORDER BY id DESC",$gvn->rakam($_GET["git"]),6);
$query 		= $db->query($qry['sql']);

if($query->rowCount() > 0 ){
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$linkx		= ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
?>
<a href="<?=$linkx;?>"><div class="sehirbtn fadeup">
<img src="uploads/thumb/<?=$row->resim;?>" width="320" height="290">
<div class="sehiristatistk">
<h2><strong><?=$fonk->kisalt($row->baslik,0,28);?><?=(strlen($row->baslik) > 28) ? '...' : '';?></strong></h2>
</div>
</div></a>


<? } ?>


<? }else{ ?>
<h4 style="color:red"><?=dil("TX220");?></h4>
<? } ?>


<? if($query->rowCount() > 0 ){ ?>
<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele('projeler?git=',$gvn->rakam($_GET["git"]),$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>
<? } ?>



</div>
</div>


</div>




<div class="clear"></div>


<? include THEME_DIR."inc/ilanvertanitim.php"; ?>

</div>

<? include THEME_DIR."inc/footer.php"; ?>
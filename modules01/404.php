<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil('TX1');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
<meta name="keywords" content="<?=$sayfay->keywords;?>" />
<meta name="description" content="<?=$sayfay->description;?>" />
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<base href="<?=SITE_URL;?>" />

<?php include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>


<div class="headerbg" style="background-image: url(uploads/404.jpg);">
<div id="wrapper">
</div>
</div>

<div id="wrapper">


<div class="content" id="bigcontent">


<div class="altbaslik">

<h4><strong><?=dil('TX1');?></strong></h4>

</div>

<div class="clear"></div>

<div class="sayfadetay" style="text-align:center;">

<h2><strong><?=dil('TX1');?></strong></h2>
<br><br>
<h4><?=dil('TX2');?></h4>
<br><br>
<h4><a href="index.html"><strong><?=dil('TX3');?></strong></a></h4>

</div>


</div>



<div class="clear"></div>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
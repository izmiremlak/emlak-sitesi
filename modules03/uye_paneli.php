<?php if(!defined("THEME_DIR")){die();}
if($hesap->id == ""){
include THEME_DIR."giris-yap.php";
die(); exit;
}

$rd		= $gvn->harf_rakam($_GET["rd"]);

?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX227");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? include THEME_DIR."inc/head.php"; ?>

<? if($rd == "danismanlar"){?>
<link rel="stylesheet" href="<?=THEME_DIR;?>/remodal/dist/remodal.css">
<link rel="stylesheet" href="<?=THEME_DIR;?>/remodal/dist/remodal-default-theme.css">
<?}?>

</head>
<body>
<? include THEME_DIR."inc/header.php"; ?>

<?php
if($rd != ""){
if(file_exists(THEME_DIR.'uye-paneli/'.$rd.".php")){
include THEME_DIR."uye-paneli/".$rd.".php";
}else{
include THEME_DIR."uye-paneli/hesabim.php";
}
}else{
include THEME_DIR."uye-paneli/hesabim.php";
}

?>

<? include THEME_DIR."inc/footer.php"; ?>
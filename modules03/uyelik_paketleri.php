<?php if(!defined("THEME_DIR")){die();}
if($hesap->id != '' && $hesap->turu == 2){
header("Location:index.php");
die();
}

if($hesap->id == ''){
$danisman	= true;
}elseif($hesap->id != '' && $hesap->turu == 1){
$danisman	= true;
}else{
$danisman	= false;
}

?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX593");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" />
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<?php include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>


<div class="headerbg" style="background-image: url(uploads/911da78222.jpg);">
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX570");?></h1>
<div class="sayfayolu">
<span><?=dil("TX571");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div class="clear"></div>

<div id="wrapper">
<div class="content" id="bigcontent">

<div class="clearmob" style="margin-top:20px;"></div>

<div class="uyelikpaketleri">

<?php
$sql		= $db->query("SELECT * FROM uyelik_paketleri_19541956 WHERE gizle=0 ORDER BY sira ASC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?>
<div class="uyepaket_19541956" style="border:2px solid <?=$row->renk;?>;">
<div style="padding:15px;">
<h1 style="color: <?=$row->renk;?>;"><i class="ion-ribbon-b"></i> <?=$row->baslik;?></h1>

<span><?=dil("TX594");?>: <strong><?=($row->aylik_ilan_limit == 0) ? dil("TX622") : $row->aylik_ilan_limit." ".dil("TX595");?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?=str_replace("[aylik_ilan_limit]",($row->aylik_ilan_limit == 0) ? dil("TX622") : $row->aylik_ilan_limit." ".dil("TX595"),dil("TX596"));?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<span><?=dil("TX587");?>: <strong><?=($row->ilan_resim_limit == 0) ? dil("TX622") : $row->ilan_resim_limit." ".dil("TX581");?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?=str_replace("[ilan_resim_limit]",($row->ilan_resim_limit == 0) ? dil("TX622") : $row->ilan_resim_limit." ".dil("TX581"),dil("TX597"));?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<span><?=dil("TX588");?>: <strong><?=($row->ilan_yayin_sure == 0) ? dil("TX622") : $row->ilan_yayin_sure." ".$periyod[$row->ilan_yayin_periyod];?></strong>  <a href="#" class="tooltip-bottom" data-tooltip="<?=str_replace("[ilan_yayin|sure|periyod]",($row->ilan_yayin_sure == 0) ? dil("TX622") : $row->ilan_yayin_sure." ".$periyod[$row->ilan_yayin_periyod],dil("TX599"));?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<?if($danisman){?>
<span><?=dil("TX600");?>: <strong><?=($row->danisman_limit == 0) ? dil("TX622") : $row->danisman_limit." ".dil("TX581");?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?=str_replace("[danisman_limit]",($row->danisman_limit == 0) ? dil("TX622") : $row->danisman_limit." ".dil("TX581"),dil("TX601"));?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<span><?=dil("TX589");?> <a href="#" class="tooltip-bottom" data-tooltip="<?=dil("TX602");?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<span><?=dil("TX590");?> <a href="#" class="tooltip-bottom" data-tooltip="<?=dil("TX603");?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<span><?=dil("TX591");?> <a href="#" class="tooltip-bottom" data-tooltip="<?=dil("TX604");?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

<?if($row->danisman_onecikar == 1){?>
<span><?=dil("TX605");?>: <br><strong><?=($row->danisman_onecikar_sure==0) ? dil("TX622") : $row->danisman_onecikar_sure." ".$periyod[$row->danisman_onecikar_periyod];?> <?=dil("TX583");?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?=dil("TX606");?>"><i style="    margin-left: 7px;    font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>
<?}else{?>
<span style="line-height: 39px;">--</span>
<?}?>

<?}?>


<select id="periyod_<?=$row->id;?>">
<?php
$ucretler		= json_decode($row->ucretler,true);
foreach($ucretler as $idi=>$urow){
$suresi			= $urow["sure"];
$periyodu		= $periyod[$urow["periyod"]];
$tutar			= $gvn->para_str($urow["tutar"]);
?><option value="<?=$idi;?>"><?php echo ($suresi != 0) ? $suresi." " : '1 '; echo $periyodu." ".$tutar; ?> <?=dil("UYELIKP_PBIRIMI");?></option><?
}
?>
</select>
<a href="javascript:void(0);" onclick="window.location.href='uyelik-paketi-satinal?id=<?=$row->id;?>&periyod='+$('#periyod_<?=$row->id;?>').val();" class="btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?=dil("TX607");?></a>
</div>
</div>
<?
}
?>

<? echo $dayarlar->paketler_icerik; ?>
</div>


</div>


<div class="clear"></div>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
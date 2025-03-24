<?php
$customs	= $_SESSION["custom"];
if($fonk->bosluk_kontrol($customs)==false){
$custom		= base64_decode($customs);
$custom		= json_decode($custom,true);
}
?><div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX549");?></h1>
<div class="sayfayolu">
<!--span>...</span-->
</div>
</div>

</div><div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">

<div class="content">


<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX549");?></h4>


<div style="margin-top:60px;margin-bottom:60px;text-align:center;" id="BasvrTamam">
<i style="font-size:80px;color:green;" class="fa fa-check"></i>
<h2 style="color:green;font-weight:bold;"><?=dil("TX550");?></h2>
<br/>
<h4><?=dil("TX555");?><br>
</h4><br><br>
<?php
if($customs != ''){
if($custom["satis"] == "doping_ekle"){
if($_SESSION["advfrom"] == "insert"){
header("Refresh:3; url=ilan-olustur?id=".$custom["ilan_id"]."&asama=3");
echo dil("TX552");
}elseif($_SESSION["advfrom"] == "adv"){
header("Refresh:2; url=uye-paneli?rd=ilan_duzenle&id=".$custom["ilan_id"]."&goto=doping");
echo dil("TX552");
}
}elseif($custom["satis"] == "uyelik_paketi"){
header("Refresh:2; url=paketlerim");
echo dil("TX552");
}elseif($custom["satis"] == "danisman_onecikar"){
header("Refresh:2; url=eklenen-danismanlar");
echo dil("TX552");
}
unset($_SESSION["custom"]);
unset($_SESSION["advfrom"]);
}
?>
</div>


</div>

</div>
</div><div class="sidebar">
<? include THEME_DIR."inc/uyepanel_sidebar.php"; ?>
</div>
</div>
<div class="clear"></div>




</div>
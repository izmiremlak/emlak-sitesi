<?php if(!defined("THEME_DIR")){die();}

$bslk		= ($sayfay->turu == 0) ? "Devam Eden Projeler" : "Projelerimiz";
$bslk		= ($sayfay->turu == 1) ? "Tamamlanan Projeler" : $bslk;
$bslk_link	= ($sayfay->turu == 0) ? 'projeler?turu=0' : 'projeler';
$bslk_link	= ($sayfay->turu == 1) ? 'projeler?turu=1' : $bslk_link;

$sayfaya_gore_headbg		= ($sayfay->tipi == 5) ? 'style="background-image: url(uploads/'.$gayarlar->projeler_resim.');"' : $sayfaya_gore_headbg;

/*
Dan??man i?in kontroller
*/
if($sayfay->danisman_id != 0 AND $sayfay->danisman_id != 1){
$danisman		= $db->prepare("SELECT * FROM danismanlar_19541956 WHERE id=?");
$danisman->execute(array($sayfay->danisman_id));
if($danisman->rowCount()>0){
$danisman		= $danisman->fetch(PDO::FETCH_OBJ);

$adsoyad		= $danisman->adsoyad;
$gsm			= ($danisman->gsm != '') ? $danisman->gsm : '';
$telefon		= ($danisman->telefon != '') ? $danisman->telefon : '';
$demail			= ($danisman->email != '') ? $danisman->email : '';
$davatar		= ($danisman->resim != '') ? 'uploads/thumb/'.$danisman->resim : 'uploads/default-avatar.png';
$profil_link	= "javascript:void(0);";
}else{
$uye_id			= $sayfay->danisman_id;
}
}else{
$uye_id			= $sayfay->acid;
}

if($uye_id != ''){
$uyee			= $db->prepare("SELECT *,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
$uyee->execute(array($uye_id));
if($uyee->rowCount()>0){
$uyee			= $uyee->fetch(PDO::FETCH_OBJ);

$adsoyad		= ($uyee->unvan == '') ? $uyee->adsoyad : $uyee->unvan;
$gsm			= ($uyee->telefon != '' AND $uyee->telefond == 0) ? $uyee->telefon : '';
$telefon		= ($uyee->sabit_telefon != '' AND $uyee->sabittelefond == 0) ? $uyee->sabit_telefon : '';
$demail			= ($uyee->email != '' AND $uyee->epostad == 0) ? $uyee->email : '';
$davatar		= ($uyee->avatar != '' AND $uyee->avatard == 0) ? 'uploads/thumb/'.$uyee->avatar : 'uploads/default-avatar.png';

$profil_link	= "profil/";
$profil_link	.= ($uyee->nick_adi == '') ? $uyee->id : $uyee->nick_adi;
}
}


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

<?php $category=true; include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>



<div class="headerbg" <?=($sayfay->resim2  != '') ? 'style="background-image: url(uploads/'.$sayfay->resim2.');"' : $sayfaya_gore_headbg; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=$sayfay->baslik;?></h1>
<div class="sayfayolu">
<a href="index.html"><strong><?=dil("TX136");?></strong></a> <i class="fa fa-caret-right" aria-hidden="true"></i> 
<a href="projeler"><strong><?=dil("TX210");?></strong></a> <i class="fa fa-caret-right" aria-hidden="true"></i> 
<? /*<a href="<?=$bslk_link;?>"><strong><?=$bslk;?></strong></a> <i class="fa fa-caret-right" aria-hidden="true"></i> */?>
<span><strong><?=$sayfay->baslik;?></strong></span>
</div>
</div>

</div>
</div>

<div id="wrapper">

<div class="content" id="bigcontent">
<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="ilandetay">

<div class="altbaslik">
<h4><strong><?=$sayfay->baslik;?></strong></h4>
</div>

<div class="ilanfotolar" id="projefotolar">

<div id="image-gallery" style="display:none">
<?php
$query		= "SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$sayfay->id." ORDER BY id DESC";
$sql		= $db->query($query);
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?>
<a class="ilandetaybigfoto" data-exthumbimage="uploads/<?=$row->resim;?>" data-src="uploads/<?=$row->resim;?>" id="mega<?=$row->id;?>">Mega Foto #<?=$row->id;?></a>
<? } ?>
</div>
	
		<div class="clearfix" >
                <ul id="image-slider" class="gallery list-unstyled cS-hidden" style="width:100%;">
				<?php
				$sql		= $db->query($query);
				while($row	= $sql->fetch(PDO::FETCH_OBJ)){
				?>
				<li data-thumb="uploads/thumb/<?=$row->resim;?>" onclick="$('#mega<?=$row->id;?>').click();">
					<img style="width:100%;cursor: crosshair;" src="uploads/<?=$row->resim;?>" />
				</li>
				<? } ?>
                </ul>
            </div>
			
			
</div>



<?php
if($adsoyad != ''){
?>
<!-- danisman start -->
<div class="danisman">
<h3 class="danismantitle"><?=($uyee->id == '' OR $uyee->turu==2 OR $uyee->turu==1) ? dil("TX155") : dil("TX154");?></h3>

<a href="<?=$profil_link;?>"><img src="<?=$davatar;?>" width="200" height="150"></a>

<h4><strong><a href="<?=$profil_link;?>"><?=$adsoyad;?></a></strong></h4>
<div class="clear"></div>


<? if($gsm != ''){ ?><h5 class="profilgsm"><strong><a style="color:white;" href="tel:<?=$gsm;?>"><?=$gsm;?></a></strong><span style="margin-left:5px;font-size:13px;"><?=dil("TX156");?></span></h5><? } ?>

<? if($telefon != ''){ ?><h5><strong><?=dil("TX157");?></strong><br><a href="tel:<?=$telefon;?>"><?=$telefon;?></a></h5><? } ?>

<? if($demail != ''){ ?><h5><strong><?=dil("TX158");?></strong><br><?=$demail;?></h5><? } ?>

<div class="clear"></div>
</div>
<!-- danisman end -->
<? } ?>


<div class="clear"></div>


<div class="ilanaciklamalar">
<h3><?=dil("TX217");?></h3>

<p><?=$sayfay->icerik;?></p>

</div>


<div class="clear"></div>
<? if($sayfay->maps != ''){ ?>
<div class="ilanaciklamalar">
<h3><?=dil("TX218");?></h3>

<iframe src="<?=$sayfay->maps;?>" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>

</div>
<? } ?>

</div>


</div>


<div class="clear"></div>

</div>

<? include THEME_DIR."inc/footer.php"; ?>
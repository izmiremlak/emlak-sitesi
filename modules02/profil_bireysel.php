<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><? echo $name; echo ($on == 'hakkinda') ? ' '.dil("TX425") : ''; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
<meta name="keywords" content="<? echo $name; ?>" />
<meta name="description" content="<? echo $name; ?>" />
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<base href="<?=SITE_URL;?>" />

<?php include THEME_DIR."inc/head.php"; ?>

</head>
<body>


<?if($hesap->id == ''){?>
<div id="uyemsjgonder" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="<?=REQUEST_URL;?>#!" title="Close" class="close">X</a>
<h2><strong><?=$name;?></strong> / <?=dil("TX413");?></h2><br>
<center><strong><?=dil("TX414");?></strong>
<div class="clear"></div><br><br>
<a href="giris-yap" class="gonderbtn"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=dil("TX356");?></a><div class="clearmob"></div> <span><?=dil("TX415");?></span> <a href="hesap-olustur" class="gonderbtn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=dil("TX125");?></a>
<br><br><br>
</center>
<div class="clear"></div>
</div>
</div>
</div>
<?}?>

<?if($hesap->id != ''){?>
<div id="uyemsjgonder" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="<?=REQUEST_URL;?>#!" title="Close" class="close">X</a>
<h2><strong><?=$name;?></strong> / <?=dil("TX413");?></h2>
<form action="ajax.php?p=mesaj_gonder&uid=<?=$profil->id;?>&from=adv" method="POST" id="MesajGonderForm">
<textarea rows="3" name="mesaj" id="MesajYaz"></textarea>
<a href="javascript:;" onclick="AjaxFormS('MesajGonderForm','MesajGonderSonuc');" style="float:right;" class="gonderbtn"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=dil("TX405");?></a>
</form>
<div id="TamamPnc" style="display:none"><?=dil("TX423");?></div>
<div class="clear"></div>
<div id="MesajGonderSonuc" style="display:none"></div>
</div>
</div>
</div>
<?}?>


<? include THEME_DIR."inc/header.php"; ?>


<div id="kfirmaprofili" class="headerbg" <?=($gayarlar->foto_galeri_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->foto_galeri_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=$name;?></h1>
</div>
</div>
</div>


<div class="clear"></div>

<div class="kurumsalbtns">
<div id="wrapper">
<a href="<?=$uyelink;?>" id="kurumsalbtnaktif"><?=dil("TX626");?></a>
<?if($gayarlar->anlik_sohbet==1){?><a href="<?=REQUEST_URL;?>#uyemsjgonder" class="gonderbtn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?=dil("TX392");?></a><?}?>
</div>
</div> 


<div id="wrapper">

<?php
if($gayarlar->reklamlar == 1){ // Eğer reklamlar aktif ise...
$detect 	= (!isset($detect)) ? new Mobile_Detect : $detect;

$rtipi		= 10;
$reklamlar	= $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1)");
$rcount		= $reklamlar->rowCount();
$order		= ($rcount>1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
$reklam		= $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) ".$order." LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
if($rcount>0){
?><!-- 728 x 90 Reklam Alanı -->
<div class="clear"></div>
<div class="ad728home">
<?=($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu;?>
</div>
<!-- 728 x 90 Reklam Alanı END-->
<? }} // Eğer reklamlar aktif ise... ?>


<div class="content" style="float:left;">

<?php
$search_link			= $uyelink."?on=profile";
$search_linkx			= $search_link;
$execute				= array();


// Emlak Durumu için filtre...
if($emlak_durum != ''){
$dahili_query 	.= "AND emlak_durum=? ";
$execute[]		= $emlak_durum;

$search_link	.= "&emlak_durum=".$emlak_durum;

}


// Order by için işlemler...
$orderi				= $gvn->html_temizle($_REQUEST["order"]);
$search_linkx	= $search_link;
if($fonk->bosluk_kontrol($orderi)==true){
$dahili_order		= "id DESC";
}else{
$filtre_count	+=1;
$bgrs			= '&';
$search_link	.= $bgrs."order=".$orderi;
if($orderi == 'fiyat_asc'){
$dahili_order		= "CAST(fiyat AS DECIMAL(10,2)) ASC";
}elseif($orderi == 'fiyat_desc'){
$dahili_order		= "CAST(fiyat AS DECIMAL(10,2)) DESC";
}else{
$dahili_order		= "id DESC";
}
}
$orbgrs			= '&';
# Bitiş


$git			= $gvn->zrakam($_GET["git"]);
$qry			= $pagent->sql_query("SELECT t1.ilan_no,t1.id,t1.url,t1.fiyat,t1.tarih,t1.il_id,t1.ilce_id,t1.emlak_durum,t1.emlak_tipi,t1.resim,t1.baslik,t1.pbirim,t1.metrekare FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND durum=1 AND acid=".$profil->id." ".$dahili_query." GROUP BY t1.ilan_no ORDER BY ".$dahili_order,$git,8,$execute);
$query 			= $db->prepare($qry['sql']);
$query->execute($execute);
$adet			= $qry['toplam'];
?>

<?php
if($adet > 0 ){
?>
<span style="float:left;margin-bottom:15px;"><strong><?=$name;?></strong> <?=dil("TX627");?> <b><?=$adet;?></b> <?=dil("TX628");?></span>
<div class="clear"></div>


<div class="list_carousel">
	<ul id="foo44">
		<?php
		while($row	= $query->fetch(PDO::FETCH_OBJ)){
			$id     = $row->id;
			$row_lang = $db->query("SELECT t1.ilan_no,t1.id,t1.url,t1.fiyat,t1.tarih,t1.il_id,t1.ilce_id,t1.emlak_durum,t1.emlak_tipi,t1.resim,t1.baslik,t1.pbirim,t1.metrekare FROM sayfalar AS t1 WHERE t1.site_id_555=999 AND t1.ilan_no=".$row->ilan_no." AND t1.dil='".$dil."' ");
			if($row_lang->rowCount()>0){
				$row = $row_lang->fetch(PDO::FETCH_OBJ);
				$row->id = $id;
			}


		?><li><?
		$link		= ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
		if($row->fiyat != 0){
		$fiyat_int		= $gvn->para_int($row->fiyat);
		$fiyat			= $gvn->para_str($fiyat_int);
		}
		$sc_il				= $db->query("SELECT il_adi FROM il WHERE id=".$row->il_id)->fetch(PDO::FETCH_OBJ);
		$sc_ilce			= $db->query("SELECT ilce_adi FROM ilce WHERE id=".$row->ilce_id)->fetch(PDO::FETCH_OBJ);
		?>
		<a href="<?=$link;?>">
		<div class="kareilan">
		<span class="ilandurum" <?php echo ($row->emlak_durum == $emstlk) ? 'id="satilik"' : ''; echo ($row->emlak_durum == $emkrlk) ? 'id="kiralik"' : ''; ?>><?=$row->emlak_durum;?>
				/  <?=$row->emlak_tipi;?>
		</span>
		<img title="Sıcak Fırsat" alt="Sıcak Fırsat" src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?=$row->resim;?>" width="234" height="201">
		<div class="fiyatlokasyon" <? echo ($row->emlak_durum == $emkrlk) ? 'id="lokkiralik"' : ''; ?>>
		<? if($row->fiyat != '' OR $row->fiyat != 0){ ?><h3><?=$fiyat;?> <?=$row->pbirim;?></h3><? } ?> 
		<h4><?=$sc_il->il_adi;?> / <?=$sc_ilce->ilce_adi;?></h4>
		</div>
		<div class="kareilanbaslik">
		<h3><?=$fonk->kisalt($row->baslik,0,45);?><?=(strlen($row->baslik) > 45) ? '...' : '';?></h3>
		</div> 
		</div>
		</a>
		</li>
		<? } ?>
	</ul>
</div>


<? }else{ ?>
<h4 style="text-align:center;margin-top:60px;"><?=dil("TX385");?></h4>
<? } ?>


<? if($adet > 0 ){ ?>
<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele($uyelink.'?git=',$git,$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>
<? } ?>

</div>
<!-- FİRMA DETAYI END-->





<div class="sidebar" style="float:right;">

<!-- profil start -->
<div class="danisman">
<h3 class="danismantitle"><?=$uturu[$profil->turu];?> <?=($profil->turu == 3) ? '' : dil("TX384");?></h3>

<img src="<?=$avatar;?>" width="200" height="150">

<h4><strong><a><?=$name;?></a></strong></h4>
<div class="clear"></div>

<?php
$gsm		= ($profil->telefon != '' && $profil->telefond==0) ? $profil->telefon : '';
$tel		= ($profil->sabit_telefon != '' && $profil->sabittelefond==0) ? $profil->sabit_telefon : '';
?>

<? if($gsm != ''){ ?><h5 class="profilgsm"><strong><a style="color:white;" href="tel:<?=$gsm;?>"><?=$gsm;?></a></strong><span style="margin-left:5px;font-size:13px;"><?=dil("TX156");?></span></h5><? } ?>

<? if($tel != ''){ ?><h5><strong><?=dil("TX157");?></strong><br><a href="tel:<?=$tel;?>"><?=$tel;?></a></h5><? } ?>

<? if($profil->email != '' && $profil->epostad==0){ ?><h5><strong><?=dil("TX158");?></strong><br><?=$profil->email;?></h5><? } ?>

<div class="clear"></div>
<br>
</div>
<!-- profil end -->


</div>




</div>


<div class="clear"></div>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX480");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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


<div class="headerbg" style="background-image: url(uploads/e115b36791.jpg);">
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX480");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> / 
<span><?=dil("TX480");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">


<div class="content" id="bigcontent">

<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="altbaslik">

<h4><strong><?=dil("TX480");?></strong></h4>

</div>

<div class="clear"></div>

<div class="sayfadetay">

<div class="emlaktalepformu">
<form action="ajax.php?p=emlak_talep_formu" method="POST" id="EmlakTalepForm">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="40%"><?=dil("TX126");?></td>
    <td><input name="adsoyad" type="text"></td>
  </tr>
  <tr>
    <td><?=dil("TX128");?></td>
    <td><input name="telefon" type="text"></td>
  </tr>
  <tr>
    <td><?=dil("TX127");?></td>
    <td><input name="email" type="text"></td>
  </tr>
  
  <?php
  $emlak_tipi	= dil("EMLKTLP1");
 if($emlak_tipi != ''){
 ?>
  <tr>
    <td><?=dil("TX54");?></td>
    <td>
    <select name="emlak_tipi">
	<?=$emlak_tipi;?>
	</select>
    </td>
  </tr>
  <?}?>
  
  
  <?php
$ulkeler	= $db->query("SELECT * FROM ulkeler_19541956 ORDER BY id ASC");
$ulkelerc	= $ulkeler->rowCount();
if($ulkelerc>1){
?>
<tr>
    <td><?=dil("TX348");?></td>
    <td>
<select name="ulke_id" onchange="ajaxHere('ajax.php?p=il_getir&ulke_id='+this.options[this.selectedIndex].value,'il');">
        <option value=""><?=dil("TX348");?></option>
        <?php
		while($row	= $ulkeler->fetch(PDO::FETCH_OBJ)){
		?><option value="<?=$row->id;?>"><?=$row->ulke_adi;?></option><?
		}
		?>
</select>
</td>
  </tr>
<?}?>
  
  <tr>
    <td><?=dil("TX55");?></td>
    <td>
    <select name="il" id="il" onchange="ajaxHere('ajax.php?p=ilce_getir&il_id='+this.options[this.selectedIndex].value,'ilce');">
        <option value=""><?=dil("TX55");?></option>
        <?php
		if($ulkelerc<2){
		$ulke		= $ulkeler->fetch(PDO::FETCH_OBJ);
		$sql		= $db->query("SELECT id,il_adi FROM il WHERE ulke_id=".$ulke->id." ORDER BY id ASC");
		}else{
		$sql		= NULL;
		}
		if($sql != NULL){
		while($row	= $sql->fetch(PDO::FETCH_OBJ)){
		?><option value="<?=$row->id;?>"><?=$row->il_adi;?></option><?
		}
		}
		?>
</select>
    </td>
  </tr>
  
  
  <tr>
    <td><?=dil("TX56");?></td>
    <td>
	<select name="ilce" id="ilce" onchange="ajaxHere('ajax.php?p=mahalle_getir&ilce_id='+this.options[this.selectedIndex].value,'mahalle');">
        <option value=""><?=dil("TX56");?></option>
        <?php
		if($il != ''){
		$sql		= $db->prepare("SELECT id,ilce_adi FROM ilce WHERE il_id=? ORDER BY id ASC");
		$sql->execute(array($il));
		}else{
		$sql		= '';
		}

		if($sql != ''){
		while($row	= $sql->fetch(PDO::FETCH_OBJ)){
		?><option value="<?=$row->id;?>"><?=$row->ilce_adi;?></option><?
		}
		}
		?>
</select>
	</td>
  </tr>
  <tr>
    <td><?=dil("TX266");?></td>
    <td>
	<select name="mahalle" id="mahalle">
        <option value=""><?=dil("TX266");?></option>
</select>
</td>
  </tr>
  
  
  
    <?php
  $talepler		= dil("EMLKTLP2");
 if($talepler != ''){
 ?>
  <tr>
    <td><?=dil("TX481");?></td>
    <td>
    <select name="talep">
	<?=$talepler;?>
	</select>
    </td>
  </tr>
  <?}?>
  
  
  
  <tr>
    <td><?=dil("TX482");?></td>
    <td>
    <textarea name="mesaj"></textarea>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><a class="gonderbtn" onclick="AjaxFormS('EmlakTalepForm','EmlakTalepForm_output');" href="javascript:void(0);"><?=dil("TX483");?></a></td>
  </tr>
  
  <tr>
  <td colspan="2"><div id="EmlakTalepForm_output" style="display:none"></div></td>
  </tr>
  
  </table>
  </form>
  <div id="EmlakTalepForm_SUCCESS" style="display:none"><?=dil("TX645");?></div>
</div>

</div>


</div>


<div class="clear"></div>

<? include THEME_DIR."inc/ilanvertanitim.php"; ?>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
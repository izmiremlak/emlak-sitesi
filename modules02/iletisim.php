<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX188");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? $iletisim = true; include THEME_DIR."inc/head.php"; ?>
</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>


<div class="headerbg" <?=($gayarlar->iletisim_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->iletisim_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX189");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <span><strong><?=dil("TX189");?></strong></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="content" id="bigcontent">

</div>

<div class="clear"></div>


<div class="iletisim">
<div class="iletisimdetay">
<table width="100%" border="0">
  <tr>
    <td colspan="2"><h3><strong><?=dil("TX190");?></strong></h3></td>
    </tr>
	
	<? if($dayarlar->telefon != ''){ ?>
  <tr>
    <td width="30%"><strong><?=dil("TX191");?></strong></td>
    <td width="70%"><a href="tel:<?=$dayarlar->telefon;?>"><?=$dayarlar->telefon;?></a></td>
    </tr>
	<? } ?>
    
    	<? if($dayarlar->gsm != ''){ ?>
  <tr>
    <td width="30%"><strong><?=dil("TX193");?></strong></td>
    <td width="70%"><a href="tel:<?=$dayarlar->gsm;?>"><?=$dayarlar->gsm;?></a></td>
  </tr>
  <? } ?>
	
	<? if($dayarlar->faks != ''){ ?>
  <tr>
    <td width="30%"><strong><?=dil("TX192");?></strong></td>
    <td width="70%"><?=$dayarlar->faks;?></td>
    </tr>
	<? } ?>

  
  <? if($dayarlar->adres != ''){ ?>
  <tr>
    <td width="30%"><strong><?=dil("TX194");?></strong></td>
    <td width="70%"><?=$dayarlar->adres;?></td>
  </tr>
  
  <? } ?>
  
  
  <? if($dayarlar->google_maps != ''){ ?>
  <tr>
    <td colspan="2">
<?php
$subeler		= $db->query("SELECT id FROM subeler_bayiler_19541956  WHERE turu=0");
?>
<? if($subeler->rowCount() > 0){ ?><a class="subebayibtn" href="subeler"><i class="fa fa-map-marker" aria-hidden="true"></i><strong><?=dil("TX195");?></strong></a><? } ?>


<?php
    $coords = $dayarlar->google_maps;
    list($lat,$lng) = explode(",", $coords);
?>
<div id="map" style="width: 100%; height: 250px"></div>
<input type="hidden" value="<?php echo $lat; ?>" id="g_lat">
<input type="hidden" value="<?php echo $lng; ?>" id="g_lng">

<script type="text/javascript">
      function initMap() {
		var g_lat = parseFloat(document.getElementById("g_lat").value);
		var g_lng = parseFloat(document.getElementById("g_lng").value);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat:g_lat,lng:g_lng}
        });
        var geocoder = new google.maps.Geocoder();
		
		var marker = new google.maps.Marker({
            position:{
              lat:g_lat,
              lng:g_lng
            },
            map:map
          });
	   
      }	 
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gayarlar->google_api_key; ?>&callback=initMap"></script>
    
    </td>
    </tr>
	
	<? } ?>
	
  </table>

</div>


<div class="iletisimform">
<form action="ajax.php?p=iletisim" method="POST" id="iletisim_form">
<table width="100%" border="0">
  <tr>
    <td width="100%"><h3><strong><?=dil("TX196");?></strong></h3></td>
    </tr>
  <tr>
    <td><input name="adsoyad" type="text" placeholder="<?=dil("TX197");?>"></td>
  </tr>
  <tr>
    <td><input name="email" type="text" placeholder="<?=dil("TX198");?>"></td>
  </tr>
  <tr>
    <td><input name="telefon" type="text" placeholder="<?=dil("TX199");?>" id="gsm"></td>
  </tr>
  <tr>
    <td><textarea name="mesaj" cols="" rows="4" placeholder="<?=dil("TX200");?>"></textarea></td>
  </tr>
  <tr>
    <td style="border:none;">
    <span style="font-size:13px;"><?=dil("TX201");?></span>
    <input name="cevap" type="text" placeholder="<?=dil('SORU');?>">
    </td>
  </tr>
  <tr>
    <td style="border:none;"><a href="javascript:void(0);" onclick="AjaxFormS('iletisim_form','iletisim_sonuc');" class="btn"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=dil("TX202");?></a>
	
	<div id="iletisim_sonuc"></div>
	
	</td>
  </tr>
  
  </table>
</form> 
  
  
<!-- TAMAM MESAJ -->
<div style="margin-top:70px;margin-bottom:70px;text-align:center; display:none" id="IletisimTamam">
<i style="font-size:80px;color:green;" class="fa fa-check"></i>
<h2 style="color:green;font-weight:bold;"><?=dil("TX203");?></h2>
<br/>
<h4><?=dil("TX204");?></h4>
</div>
<!-- TAMAM MESAJ -->
  
  
</div>

<div class="clear"></div>

</div>



</div>

<? include THEME_DIR."inc/footer.php"; ?>
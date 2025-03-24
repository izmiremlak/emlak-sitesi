<?php if(!defined("THEME_DIR")){die();}
if($_GET["id"]){
$id		= $gvn->rakam($_GET["id"]);

$sql	= $db->prepare("SELECT * FROM subeler_bayiler_19541956  WHERE id=? AND dil='".$dil."' ");
$sql->execute(array($id));

if($sql->rowCount() == 0){
header("Location:subeler");
die();
}
$veri	= $sql->fetch(PDO::FETCH_OBJ);
}

?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX224");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? $galeri = true; include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>

<div class="headerbg" <?=($gayarlar->subeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->subeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX224");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=dil("TX136");?></a> <i class="fa fa-caret-right" aria-hidden="true"></i> <span><strong><?=dil("TX224");?></strong></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="content" id="bigcontent">

</div>

<div class="clear"></div>


<div class="subelerbayiler">

<div class="lokasyonsec">
<h3><?=dil("TX225");?></h3>
<select name="lokasyon" id="lokasyon" onchange="sube_bayi_getir();">
<option value=""><?=dil("TX226");?></option>
<?php
$sql		= $db->query("SELECT * FROM subeler_bayiler_19541956  WHERE turu=0 AND dil='".$dil."' ORDER BY sira ASC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>" <?=($id == $row->id) ? 'selected' : '';?>><?=$row->lokasyon;?></option><?
}
?>
</select>
<script type="text/javascript">
function sube_bayi_getir(){
vals	= $("#lokasyon").val();
if(vals != ""){
window.location.href = 'subeler?id='+vals;
}
}
</script>
</div>

<div class="bayiblgileri" id="bayiblgileri">
<?php
if($_GET["id"]){
?>

<div class="bayisubedetay">
<table width="100%" border="0" cellpadding="5">
  <tbody><tr>
    <td colspan="2" align="center"><h4><strong><?=$veri->lokasyon;?></strong></h4></td>
    </tr>
	<? if($veri->adres != ""){ ?>
    <tr>
    <td width="20%"><strong>Adres</strong></td>
    <td width="80%"><?=$veri->adres;?></td>
    </tr>
	<? } ?>
	
	<? if($veri->telefon != ""){ ?>
	<tr>
    <td width="20%"><strong>Telefon</strong></td>
    <td width="80%"><?=$veri->telefon;?></td>
  </tr>
    <? } ?>
	
	<? if($veri->gsm != ""){ ?>
    <tr>
    <td width="20%"><strong>Gsm</strong></td>
    <td width="80%"><?=$veri->gsm;?></td>
  </tr>
   <? } ?>
    
	<? if($veri->email != ""){ ?>
    <tr>
    <td width="20%"><strong>E-Posta</strong></td>
    <td width="80%"><?=$veri->email;?></td>
  </tr>
	<? } ?>
    
	<? if($veri->google_maps != ""){ ?>
    <tr>
    <td colspan="2" align="center">


<?php
    $coords = $veri->google_maps;
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
    </tr><? } ?>
	  </tbody></table>
</div>
<? } ?>

</div><!-- .bayibilgileri end -->


</div>



</div>
<? include THEME_DIR."inc/footer.php"; ?>
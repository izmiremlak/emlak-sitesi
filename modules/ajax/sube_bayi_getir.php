<?php
$id		= $gvn->rakam($_GET["id"]);

$sql	= $db->prepare("SELECT * FROM subeler_bayiler_19541956  WHERE id=? AND dil='".$dil."' ");
$sql->execute(array($id));

if($sql->rowCount() == 0){
die(dil("TX116"));
}
$veri	= $sql->fetch(PDO::FETCH_OBJ);

?>

<div class="bayisubedetay">
<table width="100%" border="0" cellpadding="5">
  <tbody><tr>
    <td colspan="2" align="center"><h4><strong><?=$veri->lokasyon;?></strong></h4></td>
    </tr>
	<? if($veri->adres != ""){ ?>
    <tr>
    <td width="20%"><strong><?=dil("TX47");?></strong></td>
    <td width="80%"><?=$veri->adres;?></td>
    </tr>
	<? } ?>
	
	<? if($veri->telefon != ""){ ?>
	<tr>
    <td width="20%"><strong><?=dil("TX48");?></strong></td>
    <td width="80%"><?=$veri->telefon;?></td>
  </tr>
    <? } ?>
	
	<? if($veri->gsm != ""){ ?>
    <tr>
    <td width="20%"><strong><?=dil("TX49");?></strong></td>
    <td width="80%"><?=$veri->gsm;?></td>
  </tr>
   <? } ?>
    
	<? if($veri->email != ""){ ?>
    <tr>
    <td width="20%"><strong><?=dil("TX50");?></strong></td>
    <td width="80%"><?=$veri->email;?></td>
  </tr>
	<? } ?>
    
	<? if($veri->google_maps != ""){ ?>
    <tr>
    <td colspan="2" align="center">
<script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key=AIzaSyAwyu2l9Pq7A0iBRv-jsbTCe6y2DTzkavM" type="text/javascript"></script>
	<script type="text/javascript">
		function initialize() {
			if (GBrowserIsCompatible()) {
				var hrt = new GMap2(document.getElementById("hrt"));
				hrt.addControl(new GMapTypeControl(1));
				hrt.addControl(new GLargeMapControl());
				hrt.enableContinuousZoom();
				hrt.enableDoubleClickZoom();
				var coords = new GLatLng(<?=$veri->google_maps;?>);
				hrt.setCenter(coords, 15);
				var im = new GMarker(coords, {draggable: true});
				GEvent.addListener(im, "drag", function(){
				document.getElementById("coords").value = im.getPoint().toUrlValue();
				});
				hrt.addOverlay(im);
			}
		}
		window.onload = function(){initialize();}
	</script>

    <div id="hrt" style="width: 100%; height: 300px"></div>
	<input type="text" id="coords" style="display:none;" />
      </td>
    </tr><? } ?>
	  </tbody></table>
</div>
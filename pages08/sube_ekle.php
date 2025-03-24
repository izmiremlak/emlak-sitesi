            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Yeni Şube Ekle</h4>

                        </div>
                    </div>
					
                    <div class="row">
                        
                        <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
								
									<div id="form_status"></div>
                                    <form role="form" class="form-horizontal"  id="forms" method="POST" action="ajax.php?p=sube_ekle" onsubmit="return false;" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="lokasyon" class="col-sm-3 control-label">İL ve Emlak Ofisi Adı</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="lokasyon" name="lokasyon" value="" placeholder="Emlak Ofisinin Bulunduğu İli ve Adını Yazınız">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="sira" class="col-sm-3 control-label">Sıra</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="sira" name="sira" value="" placeholder="">
                                        </div>
                                        </div>
										
										
										<div class="form-group">
                                            <label for="adres" class="col-sm-3 control-label">Adres</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="adres" name="adres" value="" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="telefon" class="col-sm-3 control-label">Telefon</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="telefon" name="telefon" value="" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="gsm" class="col-sm-3 control-label">GSM</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="gsm" name="gsm" value="" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="email" class="col-sm-3 control-label">E-Posta</label>
                                            <div class="col-sm-9">
											<input type="text" class="form-control" id="email" name="email" value="" placeholder="">
                                        </div>
                                        </div>
										
										<div class="form-group">
                                            <label for="google_maps" class="col-sm-3 control-label">Google Harita Ekle </label>
                                            <div class="col-sm-9">

<div class="form-group">
<label class="col-sm-1 control-label">&nbsp;</label>
<div class="col-sm-11">
<h3><i class="fa fa-search"></i> Harita'da Arayın</h3>
</div>
</div>

<div class="form-group">
<label class="col-sm-1 control-label">Şehir</label>
<div class="col-sm-11">
<select name="map_il" class="form-control"  onchange="yazdir();ajaxHere('ajax.php?p=ilce_getir_string&il_adi='+this.options[this.selectedIndex].value,'map_ilce');">
<option value="">Seçiniz</option>
<?php
$sql		= $db->query("SELECT id,il_adi FROM il ORDER BY id ASC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?><option><?=$row->il_adi;?></option><?
}
?>
</select>
</div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
<label class="col-sm-1 control-label">İlçe</label>
<div class="col-sm-11">
<select onchange="yazdir();" name="map_ilce" id="map_ilce" class="form-control">
<option value="">Önce Şehir Seçiniz</option>
</select>
</div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
<label class="col-sm-1 control-label">Mahalle</label>
<div class="col-sm-11">
<input onchange="yazdir();" type="text" class="form-control" name="map_mahalle" value="">
</div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
<label class="col-sm-1 control-label">Cadde</label>
<div class="col-sm-11">
<input onchange="yazdir();" type="text" class="form-control" name="map_cadde" value="">
</div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
<label class="col-sm-1 control-label">Sokak</label>
<div class="col-sm-11">
<input onchange="yazdir();" type="text" class="form-control" name="map_sokak" value="">
</div><!-- col end -->
</div><!-- row end -->

<input type="text" class="form-control" id="map_adres" name="map_adres" placeholder="Adres yazınız..." style="display: none;">
<input type="text" id="coords" name="google_maps" value="" style="display:none;" />

    <div id="map" style="width: 100%; height: 300px"></div>

    <?php
    $coords = "41.003917,28.967299";
    list($lat,$lng) = explode(",", $coords);
    ?>
	<input type="hidden" value="<?php echo $lat; ?>" id="g_lat">
	<input type="hidden" value="<?php echo $lng; ?>" id="g_lng">
    <script type="text/javascript">
      function initMap() {
		var g_lat = parseFloat(document.getElementById("g_lat").value);
		var g_lng = parseFloat(document.getElementById("g_lng").value);
        var map = new google.maps.Map(document.getElementById('map'), {
		  dragable:true,
          zoom: 15,
          center: {lat:g_lat,lng:g_lng}
        });
        var geocoder = new google.maps.Geocoder();
		
		var marker = new google.maps.Marker({
            position:{
              lat:g_lat,
              lng:g_lng
            },
            map:map,
            draggable:true
          });
		  
        jQuery('#map_adres').on('change', function(){
        	var val = $(this).val();
          	geocodeAddress(marker,geocoder, map,val);
        });

       google.maps.event.addListener(marker,'dragend',function(){
        dragend(marker);
       });
	   
      }

     function geocodeAddress(marker,geocoder, resultsMap,address) {
        if(address){
            geocoder.geocode({'address': address}, function(results, status) {
              if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                marker.setMap(resultsMap);
                marker.setPosition(results[0].geometry.location);
                dragend(marker);
              } else {
                console.log('Geocode was not successful for the following reason: ' + status+" word: "+address);
              }
            });
        }
     }
	  
	  
	  function dragend(marker){
	  	var lat = marker.getPosition().lat();
		var lng = marker.getPosition().lng();
        $("#coords").val(lat+","+lng);
	  }
	  </script>



                                        </div>
                                        </div>
										
										
										
										
                                        
									<div align="right">
                                        <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('forms','form_status');">Kaydet</button>
                                    </div>
									
									</form>
									
									
									
                                </div>
                            </div>
                        </div>
						<!-- Col1 end -->
						
						</div><!-- row end -->
						
                        
						 
						
					
                    
                    
                    
                    
                    
                </div>
            </div>

        </div>

    </div>
    <script>
        var resizefunc = [];
    </script>
	<script src="assets/js/admin.min.js"></script>
	<link href="assets/plugins/notifications/notification.css" rel="stylesheet">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
			<script type="text/javascript">
			function yazdir(){
			var il 		= $("select[name='map_il']").val();
			var ilce 	= $("select[name='map_ilce']").val();
			var maha 	= $("input[name='map_mahalle']").val();
			var cadde 	= $("input[name='map_cadde']").val();
			var sokak 	= $("input[name='map_sokak']").val();
			var neler 	= "";
			if(il != undefined){
			neler 		+=il;
				if(ilce != undefined){
				neler +=", "+ilce;
					if(maha != undefined){
					neler += ", "+maha;
					
					}
					
					if(cadde != undefined){
					neler += ", "+cadde;
					
					}
					
					if(sokak != undefined){
					neler += ", "+sokak;
					}
				}
			}
			
			$("input[name='map_adres']").val(neler);
			GetMap();
			}

			function GetMap(){
				$("#map_adres").trigger("change");
			}
			</script>
			
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gayarlar->google_api_key; ?>&callback=initMap"></script>
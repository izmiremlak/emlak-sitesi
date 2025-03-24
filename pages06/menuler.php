            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Menüler</h4>

                        </div>
                    </div>
					

					
<div class="row">
                       <!-- Col 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

<button type="button" class="btn btn-info waves-effect waves-light w-lg m-b-5" onclick="window.location.href='index.php?p=menuler&ekle=1';"> <i class="fa fa-plus"></i> Yeni Menu Ekle</button>

<?php
############ Veri silme ###############
if($gvn->rakam($_GET["sil"]) != ""){
if($hesap->tipi != 2){
$id 		= $gvn->rakam($_GET["sil"]);	
if(is_numeric($id) ){
$sils 		= $db->query("DELETE FROM menuler_19541956 WHERE id=".$id." ");
if($sils) {

}else {
$fonk->uyari("Teknik Bir Hata oluştu!");
}
}
}
}
############ Veri silme ###############

## Ekeleme ##
$duzenle		= $gvn->rakam($_GET["duzenle"]);
$ekle			= $gvn->rakam($_GET["ekle"]);
if($duzenle == ""){

if($_POST){
if($hesap->tipi != 2){
?><br /><?
$ustu		= $gvn->zrakam($_POST["ustu"]);
$baslik		= $gvn->title($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$sayfa		= $gvn->zrakam($_POST["sayfa"]);
$url		= $gvn->title($_POST["url"]);
$target		= $gvn->html_temizle($_POST["target"]);

if($baslik == ""){
$fonk->uyari("Lütfen başlık yaz.");
}else{
$query		= $db->query("INSERT INTO menuler_19541956 SET dil='".$dil."',ustu='".$ustu."',baslik='".$baslik."',sira='".$sira."',sayfa='".$sayfa."',url='".$url."',target='".$target."' ");
if($query){

}else{

}
}
?><br /><?
}
}
}else{ // boş değilse 
if($_POST){
if($hesap->tipi != 2){
?><br /><?
$ustu		= $gvn->zrakam($_POST["ustu"]);
$baslik		= $gvn->title($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$sayfa		= $gvn->zrakam($_POST["sayfa"]);
$url		= $gvn->title($_POST["url"]);
$target		= $gvn->html_temizle($_POST["target"]);

if($baslik == ""){
$fonk->uyari("Lütfen başlık yaz.");
}else{
$query		= $db->query("UPDATE menuler_19541956 SET ustu='".$ustu."',baslik='".$baslik."',sira='".$sira."',sayfa='".$sayfa."',url='".$url."',target='".$target."' WHERE id=".$duzenle." ");
if($query){
$fonk->tamam("Başarıyla Güncellendi.");
}else{

}
}
?><br /><?
}
}
} // boş değilse
?>


<style type="text/css">
.adminmenu ul li {
	float: left;
	width: 175px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-right-style: dotted;
	border-bottom-style: dotted;
	border-right-color: #CCC;
	border-bottom-color: #CCC;
	list-style-type: none;
	margin-right: 10px;
	font-size: 12px;
	margin-bottom: 15px;
}
.adminmenu ul li ul {
	padding: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 15px;
}

.adminmenu ul li i {
	float: right;
	margin-left:5px;
	font-size:14px;
	-webkit-transition: all 0.3s ease-out;
-moz-transition: all 0.3s ease-out;
-ms-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;
}



.adminmenu ul li ul li {
	width: 100%;
	margin-bottom: 0px;
}

.adminmenu h3 {
	font-weight: lighter;
	margin-top: 20px;
	margin-bottom: 20px;
	padding-top: 20px;
	border-top-width: 1px;
	border-top-style: solid;
	border-top-color: #CCC;
}
</style>

<div style="clear:both;"></div><br/><br/>
<div class="adminmenu">

<? $fonk->admin_menu_listesi(); ?>

<div style="clear:both;"></div>

<h3>Menu Ekle/Düzenle</h3>

<form action="" method="POST" id="forms" role="form" class="form-horizontal">
<?php
$duzenle		= $gvn->rakam($_GET["duzenle"]);
$ekle			= $gvn->rakam($_GET["ekle"]);
if($duzenle!= ''){
$srg			= $db->query("SELECT * FROM menuler_19541956 WHERE id=".$duzenle." ");
$dt				= $srg->fetch(PDO::FETCH_OBJ);
}
?>
<div class="form-group">
<label class="col-sm-3 control-label">Üst Menu Seç:</label>
<div class="col-sm-9">
<select name="ustu" class="form-control">
<option value="0">Yok</option>
<?php
$fonk->selectbox_menu_list(0,false,0,$dt->ustu);
?>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">Başlık:</label>
<div class="col-sm-9">
<input type="text" name="baslik" value="<?=$dt->baslik;?>" class="form-control">
</div>
</div>


<div class="form-group">
<label for="target" class="col-sm-3 control-label">Yeni sekme de aç:</label>
<div class="col-sm-8" style="margin-top:7px;">

<input type="checkbox" id="target_check" class="stm-checkbox" value="_blank" name="target" <?=($dt->target == '_blank') ? 'checked' : '';?>>
<label style="float:left;margin-right:10px;" for="target_check" class="stm-checkbox-label">Aktif</label><span style="margin-left:10px;font-size:14px;margin-top:5px;">(Aktif ederseniz bağlantı tıklandığında yeni sekme de açılır.)</span>

</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">Sıra:</label>
<div class="col-sm-9">
<input type="text" name="sira" value="<?=$dt->sira;?>" class="form-control">
</div>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">Sayfa Seç:</label>
<div class="col-sm-9">
<select name="sayfa" class="form-control">
<option value="0">Yok</option>
<?php
$sql		= $db->query("SELECT * FROM sayfalar WHERE site_id_555=888 AND tipi!=4 AND dil='".$dil."' ORDER BY baslik ASC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>" <?=($dt->sayfa == $row->id) ? 'selected' : ''; ?> ><?=$row->baslik;?></option><?
}
?>
</select>
</div>
</div>



<div class="form-group">
<label class="col-sm-3 control-label">Sayfa URL:</label>
<div class="col-sm-9">
<input type="text" name="url" value="<?=$dt->url;?>" class="form-control">
<span style="font-size:13px;font-weight:bold;">Eğer harici yönlendirme yapmak istiyorsanız bu alanı kullanınız.</span>
</div>
</div>






		  <div align="right">
		<button type="submit" class="btn btn-purple waves-effect waves-light">Kaydet</button>
		</div>
</form>

	
		

										


									
									
                                </div>
                            </div>
                        </div>
						<!-- Col1 end -->
						</div> <!-- Row end -->

                    
                    
                    
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
	<? if($duzenle!= '' OR $ekle!= ''){ ?>
	$('html, body').animate({scrollTop: 500}, 1000);
	<? } ?>
	</script>
	
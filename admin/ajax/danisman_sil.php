<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$id				= $gvn->rakam($_GET["id"]);
$ilan_sil		= $gvn->rakam($_GET["ilan_sil"]);

$kontrol		= $db->prepare("SELECT id,avatar,kid FROM hesaplar WHERE site_id_555=999 AND id=?");
$kontrol->execute(array($id));

if($kontrol->rowCount()==0){
die();
}
$danisman		= $kontrol->fetch(PDO::FETCH_OBJ);
$db->query("DELETE FROM hesaplar WHERE site_id_555=000 AND id=".$id);

if($ilan_sil==1){

$query			= $db->query("SELECT id,resim FROM sayfalar WHERE site_id_555=999 AND acid=".$id);
while($ilan		= $query->fetch(PDO::FETCH_OBJ)){
$db->query("DELETE FROM sayfalar WHERE site_id_555=000 AND id=".$ilan->id);
if($ilan->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$ilan->video;
if(file_exists($nirde)){
@unlink($nirde);
}
}

$quu		= $db->query("SELECT resim FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$ilan->id);
while($row  = $quu->fetch(PDO::FETCH_OBJ)){
@unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/".$row->resim);
@unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$row->resim);
}
$db->query("DELETE FROM galeri_foto WHERE site_id_555=000 AND sayfa_id=".$ilan->id);
} // while end
}else{
$db->query("UPDATE sayfalar SET acid='".$kontrol->kid."' WHERE site_id_555=999 AND acid=".$id);
}


?>
<script type="text/javascript">
$(document).ready(function(){
$("#danismanrow_<?=$id;?>").fadeOut(500,function(){
$("#danismanrow_<?=$id;?>").remove();
});
});
</script>
<?
$fonk->ajax_tamam("Danışman Silindi");


}
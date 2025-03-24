<?php
if($hesap->id == ''){
die();
}
$id				= $gvn->rakam($_GET["id"]);
$ilan_sil		= $gvn->rakam($_GET["ilan_sil"]);

$kontrol		= $db->prepare("SELECT id,avatar FROM hesaplar WHERE site_id_555=999 AND id=? AND kid=?");
$kontrol->execute(array($id,$hesap->id));

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

$pinfo      = pathinfo("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$row->resim);
$folder     = $pinfo["dirname"]."/";
$ext        = $pinfo["extension"];
$fname      = $pinfo["filename"];
$bname      = $pinfo["basename"];

@unlink($folder."thumb/".$bname);
@unlink($folder.$bname);
@unlink($folder.$fname."_original.".$ext);

}
$db->query("DELETE FROM galeri_foto WHERE site_id_555=000 AND sayfa_id=".$ilan->id);
} // while end
}else{
$db->query("UPDATE sayfalar SET acid='".$hesap->id."' WHERE site_id_555=999 AND acid=".$id);
}


?>
<script type="text/javascript">
$(function(){
$("#row_<?=$id;?>").css({"background-color" : '#EFCFCF'});
 $("#row_<?=$id;?>").animate({opacity : 0.1},1000,function(){
 $("#row_<?=$id;?>").fadeOut(100);
 });
});
</script>
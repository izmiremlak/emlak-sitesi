<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT id,video,ilan_no FROM sayfalar XXXXXXXXXXXXXXXXXXXXXX tipi=4");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}

$multi			= $db->query("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=999 AND ilan_no=".$snc->ilan_no." ORDER BY id ASC");
$multif			= $multi->fetch(PDO::FETCH_OBJ);
$multidids		= $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=999 AND ilan_no=".$snc->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;
$mulid 			= ($multi->rowCount()>1 && $snc->id == $multif->id) ? " IN(".$multidids.")" : "=".$snc->id;



$db->query("DELETE FROM sayfalar WHERE site_id_555=000 AND id".$mulid);
if($snc->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$snc->video;
if(file_exists($nirde)){
@unlink($nirde);
}
}
$quu		= $db->query("SELECT id,resim FROM galeri_foto WHERE site_id_555=999 AND sayfa_id".$mulid);
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
$db->query("DELETE FROM galeri_foto WHERE site_id_555=000 AND sayfa_id".$mulid);

?>
<script type="text/javascript">
$(document).ready(function(){
$("#row_<?=$id;?>").fadeOut(500);
});
</script>
<?
$fonk->ajax_tamam("Veri Silindi");


}
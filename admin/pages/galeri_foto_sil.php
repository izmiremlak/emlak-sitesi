<?php
if($hesap->id != "" AND $hesap->tipi != 0){
$id		= $gvn->rakam($_GET["id"]);

/*sadece site sahibi resim silebilecek*/
$snc		= $db->prepare("SELECT * FROM galeri_foto WHERE site_id_555=000 AND id=:ids");
$snc->execute(array('ids' => $id));
if($snc->rowCount()>0){$snc=$snc->fetch(PDO::FETCH_OBJ);}else{die();}

$pinfo      = pathinfo("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$snc->resim);
$folder     = $pinfo["dirname"]."/";
$ext        = $pinfo["extension"];
$fname      = $pinfo["filename"];
$bname      = $pinfo["basename"];
@unlink($folder."thumb/".$bname);
@unlink($folder.$bname);
@unlink($folder.$fname."_original.".$ext);
/*sadece site sahibi resim silebilecek*/
$db->query("DELETE FROM galeri_foto WHERE site_id_555=000 AND id=".$id);

?>
<script type="text/javascript">document.getElementById('foto_<?=$id;?>').style.display='none';</script>
<?
$fonk->ajax_tamam("Fotoğraf Silindi.");


}
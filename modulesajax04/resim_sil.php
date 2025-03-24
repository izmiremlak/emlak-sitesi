<?php
if($hesap->id == ''){ 
die();
}

$id			= $gvn->rakam($_GET["ilan_id"]);
$resim_id	= $gvn->rakam($_GET["resim_id"]);

$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);

$acc		= $db->query("SELECT id,kid FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$kid		= $acc->kid;
if($snc->acid != $hesap->id AND $hesap->id != $kid){
die();
}


if($resim_id == '' OR $resim_id == 0){
die();
}

$qqq		= $db->prepare("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=? AND id=? ");
$qqq->execute(array($snc->id,$resim_id));
$qqq		= $qqq->fetch(PDO::FETCH_OBJ);


$pinfo      = pathinfo("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$qqq->resim);
$folder     = $pinfo["dirname"]."/";
$ext        = $pinfo["extension"];
$fname      = $pinfo["filename"];
$bname      = $pinfo["basename"];

@unlink($folder."thumb/".$bname);
@unlink($folder.$bname);
@unlink($folder.$fname."_original.".$ext);

try{
$sil		= $db->prepare("DELETE FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=? AND id=? ");
$sil->execute(array($snc->id,$resim_id));
}catch(PDOException $e){
die();
}


?>
<script type="text/javascript">
$(function(){
$("#xrow_<?=$resim_id;?>").css({"background-color" : '#EFCFCF'});
 $("#xrow_<?=$resim_id;?>").animate({opacity : 0.1},1000,function(){
 $("#xrow_<?=$resim_id;?>").fadeOut(100);
 });

$("#xrowd_<?=$resim_id;?>").css({"background-color" : '#EFCFCF'});
 $("#xrowd_<?=$resim_id;?>").animate({opacity : 0.1},1000,function(){
 $("#xrowd_<?=$resim_id;?>").fadeOut(100);
 });
});
</script>
<?
<?php
if($hesap->id == ''){
die();
}
$id				= $gvn->rakam($_GET["id"]);

$kontrol		= $db->prepare("SELECT acid,id,durum,ilan_no FROM sayfalar WHERE site_id_555=999 AND id=? AND tipi=4");
$kontrol->execute(array($id));
if($kontrol->rowCount()==0){
die();
}
$ilan			= $kontrol->fetch(PDO::FETCH_OBJ);


$acc		= $db->query("SELECT id,kid FROM hesaplar WHERE site_id_555=999 AND id=".$ilan->acid)->fetch(PDO::FETCH_OBJ);
$kid		= $acc->kid;
if($ilan->acid != $hesap->id AND $hesap->id != $kid){
die();
}

$multi			= $db->query("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=999 AND ilan_no=".$ilan->ilan_no." ORDER BY id ASC");
$multict		= $multi->rowCount();
$multif			= $multi->fetch(PDO::FETCH_OBJ);
$multidids		= $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=999 AND ilan_no=".$ilan->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;
$mulid 			= ($multict>1 && $ilan->id == $multif->id) ? " IN(".$multidids.")" : "=".$ilan->id;



if($ilan->durum != 3)
	die();
$db->query("UPDATE sayfalar SET durum=1 WHERE site_id_555=999 AND id".$mulid);
?>
<script type="text/javascript">
$(function(){
$("#row_<?=$id;?>").css({"background-color" : '#CFEFD4'});
 $("#row_<?=$id;?>").animate({opacity : 0.1},1000,function(){
 $("#row_<?=$id;?>").fadeOut(100);
 });
});
</script>
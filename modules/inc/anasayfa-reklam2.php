<div class="clear"></div>
<?php
if($gayarlar->reklamlar == 1){ // Eğer reklamlar aktif ise...

$detect 	= (!isset($detect)) ? new Mobile_Detect : $detect;

$rtipi		= 2;
$reklamlar	= $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1)");
$rcount		= $reklamlar->rowCount();
$order		= ($rcount>1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
$reklam		= $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) ".$order." LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
if($rcount>0){
?><!-- 728 x 90 Reklam Alanı -->
<div class="ad728home">
<?=($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu;?>
</div>
<!-- 728 x 90 Reklam Alanı END-->
<? }} // Eğer reklamlar aktif ise... ?>
<div class="clear"></div>
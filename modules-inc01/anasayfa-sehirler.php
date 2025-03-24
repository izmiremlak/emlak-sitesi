<?php

$sehirler		= $db->query("SELECT * FROM sehirler_19541956 WHERE dil='".$dil."' ORDER BY sira ASC");
if($sehirler->rowCount() > 0){
?>
<!-- blok4 start -->
<div class="sehirbutonlar">
<div id="sehirbutonlar-container">

<?php
foreach($sehirler->fetchAll() as $row){
$eksq	= "";
$linki	= "";
if($row["il"]!=0){
$ilKontrol	= $db->prepare("SELECT id,il_adi,slug FROM il WHERE id=?");
$ilKontrol->execute(array($row["il"]));
if($ilKontrol->rowCount()>0){
$ilKontrol	= $ilKontrol->fetch(PDO::FETCH_OBJ);
$eksq		.= "t1.il_id=".$ilKontrol->id." AND ";
$linki		.= "/".$ilKontrol->slug;
$smod_adi	= $ilKontrol->il_adi;
}
}

if($row["ilce"]!=0){
$ilceKontrol	= $db->prepare("SELECT id,ilce_adi,slug FROM ilce WHERE id=?");
$ilceKontrol->execute(array($row["ilce"]));
if($ilceKontrol->rowCount()>0){
$ilceKontrol	= $ilceKontrol->fetch(PDO::FETCH_OBJ);
$eksq			.= "t1.ilce_id=".$ilceKontrol->id." AND ";
$linki			.= "-".$ilceKontrol->slug;
$smod_adi	= $ilceKontrol->ilce_adi;
}
}

if($row["mahalle"]!=0){
$mahaKontrol	= $db->prepare("SELECT id,mahalle_adi,slug FROM mahalle_koy WHERE id=?");
$mahaKontrol->execute(array($row["mahalle"]));
if($mahaKontrol->rowCount()>0){
$mahaKontrol	= $mahaKontrol->fetch(PDO::FETCH_OBJ);
$eksq			.= "t1.mahalle_id=".$mahaKontrol->id." AND ";
$linki			.= "-".$mahaKontrol->slug;
$smod_adi		= $mahaKontrol->mahalle_adi;
}
}


if($smod_adi != '' && $linki != ''){
$xemlak_durum	= "";
$xemlak_durum	= ($row['emlak_durum'] == "satilik") ? $emstlk : $xemlak_durum;
$xemlak_durum	= ($row['emlak_durum'] == "kiralik") ? $emkrlk : $xemlak_durum;
$xemlak_durum	= ($row['emlak_durum'] == "gunluk_kiralik") ? $emgkrlk : $xemlak_durum;
$slug_emlkdrm	= $gvn->PermaLink($xemlak_durum);
$adet			= $db->query("SELECT COUNT(t1.id) as adet FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t2.ilan_id=t1.id AND t2.did=4 AND t2.durum=1 AND t2.btarih>NOW() WHERE (t1.btarih>NOW() OR t2.btarih>NOW() OR EXISTS (SELECT btarih FROM dopingler_19541956 WHERE ilan_id=t1.id AND durum=1 AND btarih>NOW())) AND t1.durum=1 AND t1.ekleme=1 AND ".$eksq."t1.emlak_durum='".$xemlak_durum."' DDDDDDDDDDDDDDD t1.tipi=4")->fetch(PDO::FETCH_OBJ)->adet;
$linki			= $slug_emlkdrm.$linki;
?>
<a href="<?=$linki;?>"><div class="sehirbtn fadeup">
<img src="uploads/<?=$row['resim'];?>" title="<?=$smod_adi;?>" alt="<?=$smod_adi;?>" width="167" height="280">
<div class="sehiristatistk">
<h1><?=$smod_adi;?></h1>
<h2><?=$xemlak_durum;?></h2>
<h3><strong><?=$adet;?></strong> <?=dil("TX209");?></h3>
</div>
</div></a>
<?
}
}
?>
</div>
</div>
<!-- blok4 end -->
<?
} // eğer bir şeyler varsa göster

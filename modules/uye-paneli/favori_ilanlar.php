<div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX436");?></h1>
<div class="sayfayolu">
<span><?=dil("TX438");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">



<div class="content">

<?php
if($gayarlar->reklamlar == 1){ // E�er reklamlar aktif ise...
$detect 	= (!isset($detect)) ? new Mobile_Detect : $detect;
$rtipi		= 7;
$reklamlar	= $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih -> NOW() OR suresiz=1)");
$rcount		= $reklamlar->rowCount();
$order		= ($rcount>1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
$reklam		= $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) ".$order." LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
if($rcount>0){
?><!-- 728 x 90 Reklam Alan� -->
<div class="ad728home">
<?=($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu;?>
</div>
<!-- 728 x 90 Reklam Alan� END-->
<? }} // E�er reklamlar aktif ise... ?>

<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX436");?></h4>


<?php
$git		= $gvn->zrakam($_GET["git"]);
$qry		= $pagent->sql_query("SELECT sayfalar.id,sayfalar.url,sayfalar.tarih,sayfalar.baslik,sayfalar.durum,sayfalar.ilan_no,sayfalar.hit,sayfalar.resim,favoriler_19541956.tarih AS fav_tarih,favoriler_19541956.id AS fav_id FROM favoriler_19541956 INNER JOIN sayfalar ON favoriler_19541956.ilan_id=sayfalar.id QQQQQQQQQQQQQQQ sayfalar.tipi=4 AND favoriler_19541956.acid=".$hesap->id." ORDER BY favoriler_19541956.id DESC",$git,6);
$query 		= $db->query($qry['sql']);
$adet		= $qry['toplam'];
?>

<?php
if($adet > 0 ){
?>
<div id="hidden_result" style="display:none"></div>
<table width="100%" border="0" id="datatable">
   <thead style="background:#ebebeb;">  
                <tr>  
                    <th align="center"><strong><?=dil("TX232");?></strong></th>  
                    <th align="left"><strong><?=dil("TX233");?></strong></th>  
                    <th id="mobtd" align="center"><strong><?=dil("TX234");?></strong></th> 
                    <th align="center"><strong><?=dil("TX235");?></strong></th> 
                </tr>  
            </thead> 
  
  
<?php
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$ilink		= ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
$ilan_tarih	= date("d.m.Y",strtotime($row->fav_tarih));
?>
  <tr id="row_<?=$row->fav_id;?>">
    <td ><img src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?=$row->resim;?>" width="100" height="75"/></td>
    <td><a target="_blank" href="<?=$ilink;?>"><strong><?php echo $row->baslik;?></strong></a><br>
    <span class="ilantarih"><?=$ilan_tarih;?> <?=dil("TX440");?> </span>
    <span class="ilantarih"><?php if($row->durum == 1 OR $row->durum == 3){ ?><?=dil("TX315");?> <?php echo $row->hit;?><?php } ?> </span>
    <span class="ilantarih"><?php echo dil("TX140"); ?>: <?php echo $row->ilan_no; ?></span>
    </td>
    <td align="center" id="mobtd">
	<?php
	if($row->durum == 0){
	?><span style="color:red;font-weight:bold;"><?=dil("TX241");?></span><?
	}elseif($row->durum == 1){
	?><span style="color:green;font-weight:bold;"><?=dil("TX239");?></span><?
	}elseif($row->durum == 2){
	?><span style="color:green;font-weight:bold;"><?=dil("TX241");?></span><?
	}elseif($row->durum == 3){
	?><span style="color:orange;font-weight:bold;"><?=dil("TX241");?></span><?
	}
	?>
	</td>
    <td width="15%" align="center">
    <a title="<?=dil("TX445");?>" class="uyeilankontrolbtn" href="javascript:;" onclick="ajaxHere('ajax.php?p=favori_sil&id=<?=$row->fav_id;?>','hidden_result');"><i class="fa fa-times" aria-hidden="true"></i></a>
    </td>
  </tr>
  <? } ?>
  
  </table>


<div class="clear"></div>
<? /*
<div class="sayfalama">
<?php echo $pagent->listele('favori-ilanlar?git=',$git,$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div> */?>

<? }else{ ?> 
<h4 style="text-align:center;margin-top:60px;"><?=dil("TX441");?></h4>
<? } ?>



</div>
</div>
</div>

<div class="sidebar">
<? include THEME_DIR."inc/uyepanel_sidebar.php"; ?>
</div>

<div class="clear"></div>

</div>

</div>
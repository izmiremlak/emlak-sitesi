<div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX556");?></h1>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">



<div class="content">


<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX556");?></h4>
 
<?php
$git		= $gvn->zrakam($_GET["git"]);
$qry		= $pagent->sql_query("SELECT * FROM dopingler_group_19541956 WHERE acid=".$hesap->id." ORDER BY id DESC",$git,6);
$query 		= $db->query($qry['sql']);
$adet		= $qry['toplam'];
?>
<?php
if($adet > 0 ){
?>
<div id="hidden_result" style="display:none"></div>


  <div id="accordion">
  
	<?php
	$i			= 0;
	$bugun		= date("Y-m-d");
	while($dop	= $query->fetch(PDO::FETCH_OBJ)){
	$i			+=1;
	$ilani		= $db->query("SELECT id,url,baslik FROM sayfalar WHERE site_id_555=999 AND id=".$dop->ilan_id)->fetch(PDO::FETCH_OBJ);
	$ilanilink	= ($dayarlar->permalink == 'Evet') ? $ilani->url.'.html' : 'index.php?p=sayfa&id='.$ilani->id;
	?>
  <h3><?=$ilani->baslik;?></h3>
  <div>
    <table width="100%" border="0">
  <tr>
    <td bgcolor="#EFEFEF"><strong><?=dil("TX557");?></strong></td>
    <td align="center" bgcolor="#EFEFEF"><strong><?=dil("TX558");?></strong></td>
    <td align="center" bgcolor="#EFEFEF"><strong><?=dil("TX559");?></strong></td>
  </tr>
  <?
$dopingleri	= $db->query("SELECT * FROM dopingler_19541956 WHERE gid=".$dop->id);
while($row	= $dopingleri->fetch(PDO::FETCH_OBJ)){
$kgun 		= $fonk->gun_farki($row->btarih,$bugun);
$tarihi		= date("d.m.Y H:i",strtotime($row->tarih));
?>
  <tr>
  <td><?=dil("DOPING".$row->did);?></td>
  <td align="center">(<?=$row->sure;?> <?=$periyod[$row->periyod];?>)<br><strong><?=$gvn->para_str($row->tutar);?> <?=dil("DOPING_PBIRIMI");?></strong></td>
  <!--td><?=$row->odeme_yontemi;?></td-->
    <td align="center">
	<?php
	if($row->durum == 0){
	?><span style="color:orange;font-weight:bold;"><?=dil("TX560");?></span><?
	}elseif($row->durum == 1){
	?>
	<span style="color:green;font-weight:bold;"><?=dil("TX561");?></span><br>
	<? if($kgun < 0){ ?>
	<strong style="color:red"><i class="fa fa-clock-o"></i> <?=dil("TX562");?></strong>
	<? }else{ ?>
	<strong><i class="fa fa-clock-o"></i> <?=($kgun == 0) ? dil("TX563") : $kgun." ".dil("TX564");?></strong>
	<? } ?>
	<?
	}elseif($row->durum == 2){
	?><span style="color:red;font-weight:bold;"><?=dil("TX565");?></span><?
	}
	?>
	</td>
  </tr>
  <? } ?>
  <tr>
  <td colspan="3">
  <span style="float:left;"><?=dil("TX566");?>: <strong><?=date("d.m.Y H:i",strtotime($dop->tarih));?></strong></span>
  <span style="float:right; margin-left:20px;"><?=dil("TX567");?>: <strong><?=$gvn->para_str($dop->tutar);?> <?=dil("DOPING_PBIRIMI");?></strong></span>
  <span style="float:right;"><?=dil("TX568");?>: <strong><?=$dop->odeme_yontemi;?></strong></span>
 
  </td>
  </tr>
    </table>
  </div>
  <? } ?>
  
</div><!-- tab end -->


<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele('dopinglerim?git=',$git,$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>

<? }else{ ?> 
<h4 style="text-align:center;margin-top:60px;"><?=dil("TX569");?></h4>
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
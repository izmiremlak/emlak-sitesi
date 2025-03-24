<?php
if($hesap->turu == 2){
header("Location:index.php");
die();
}
?><div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX575");?></h1>
<div class="sayfayolu">
<span><?=dil("TX571");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">



<div class="content">


<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX576");?></h4>
  
  <style>
  #accordion {
    margin-top: 40px;
    font-family: Open Sans, sans-serif;
}
  #accordion h3 {font-size:16px;font-weight:bold;-webkit-transition: all 0.3s ease-out;
-moz-transition: all 0.3s ease-out;
-ms-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;}
  #accordion div p {font-family: Open Sans, Sans Serif;}
  .ui-state-active {    background: #be2527;}
  #accordion table {font-size:13px;}
  #accordion table tr td {padding:10px;}
  </style>

<?php
$git		= $gvn->zrakam($_GET["git"]);
$qry		= $pagent->sql_query("SELECT * FROM upaketler_19541956 WHERE acid=".$hesap->id." ORDER BY id DESC",$git,1);
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
	$buay		= date("Y-m");
	$bugun		= date("Y-m-d");
	while($row	= $query->fetch(PDO::FETCH_OBJ)){
	$i			+=1;
	
	if($hesap->turu == 1){
	$dids			= $db->query("SELECT kid,id,GROUP_CONCAT(id SEPARATOR ',') AS danismanlar_19541956 FROM hesaplar WHERE site_id_555=999 AND kid=".$row->acid)->fetch(PDO::FETCH_OBJ);
	$danismanlar	= $dids->danismanlar;
	$acids			= ($danismanlar == '') ? $row->acid : $row->acid.','.$danismanlar;
	}else{
	$acids			= $hesap->id;
	}
	
	$topilanlaray	= $db->query("SELECT tarih,id FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND pid=".$row->id." AND acid IN(".$acids.") AND tarih LIKE '%".$buay."%' ");
	$topilanlaray	= $topilanlaray->rowCount();
	
	if($hesap->turu == 1){
	// Toplam Danışman Sayısı
	$topdanisman	= $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND kid=".$row->acid." AND pid=".$row->id)->rowCount();
	
	
	// Daha önce danışman öne çıkarmış mı?
	$oncpaket	= $db->query("SELECT id FROM upaketler_19541956 WHERE id!=".$row->id." AND durum=1 AND danisman_onecikar=1 AND danisman_onecikar_use=1")->rowCount();
	
	$dlimit		= $row->danisman_limit - $topdanisman;
	}
	
	$eklimit	= ($row->aylik_ilan_limit - $topilanlaray);
	
	
	?>
  <h3><?=$row->adi;?></h3>
  <div>
    
<table width="100%" border="0">
  <tbody><tr>
    <td bgcolor="#EFEFEF"><strong><?=dil("TX577");?></strong></td>
    <td align="center" bgcolor="#EFEFEF"><strong><?=dil("TX578");?></strong></td>
    <td align="center" bgcolor="#EFEFEF"><strong><?=dil("TX579");?></strong></td>
  </tr>
    <tr>
  <td style="    line-height: 23px;">

<span><?=dil("TX580");?>: <?if($row->aylik_ilan_limit == 0){?><strong><?=dil("TX622");?></strong><?}else{?><strong><?=$row->aylik_ilan_limit." ".dil("TX581");?></strong> / <strong style="color:green;"><?=($eklimit <1) ? 0 : $eklimit." ".dil("TX582");?></strong><?}?></span><br>
<?if($hesap->turu ==1){?>
<span><?=dil("TX357");?>: <?if($row->danisman_limit == 0){?><strong><?=dil("TX622");?></strong><?}else{?><strong><?=$row->danisman_limit." ".dil("TX581");?></strong> / <strong style="color:green;"><?=($dlimit <1) ? "0 ".dil("TX582") : $dlimit." ".dil("TX582");?></strong><?}?></span><br>
<?if($row->danisman_onecikar==1 && $oncpaket<1){?>
<span><?=dil("TX605");?>;<br><strong><?=($row->danisman_onecikar_sure == 0) ? dil("TX622") : $row->danisman_onecikar_sure." ".$periyod[$row->danisman_onecikar_periyod];?> <?=dil("TX583");?></strong> / <?php if($row->danisman_onecikar_use==0){?><strong style="color:red;"><?=dil("TX584");?></strong><?}else{
$onecikand	= $db->query("SELECT onecikar_btarih,kid,onecikar,turu FROM hesaplar WHERE site_id_555=999 AND kid=".$row->acid." AND onecikar=1 AND turu=2")->fetch(PDO::FETCH_OBJ);
$dkgun 	= $fonk->gun_farki($onecikand->onecikar_btarih,$bugun);
if($row->danisman_onecikar_sure == 0){
?><strong style="color:green;"><?=dil("TX622")." ".$periyod["gunluk"];?></strong><?
}elseif($dkgun <0){
?><strong style="color:red;"><?=dil("TX585");?></strong><?
}elseif($dkgun == 0){
?><strong style="color:orange;"><?=dil("TX586");?></strong><?
}elseif($dkgun>0){
?><strong style="color:green;"><?=$dkgun;?> <?=dil("TX564");?></strong><?
}
}?> </span><br>
<?}?>
<?}?>
<span><?=dil("TX587");?>: <strong><?=($row->ilan_resim_limit == 0) ? dil("TX622") : $row->ilan_resim_limit." ".dil("TX581");?></strong> </span><br>
<span><?=dil("TX588");?>: <strong><?=($row->ilan_yayin_sure == 0) ? dil("TX622") : $row->ilan_yayin_sure." ".$periyod[$row->ilan_yayin_periyod];?></strong> </span><br>

<?if($hesap->turu ==1){?>
<span><?=dil("TX589");?> </span><br>
<span><?=dil("TX590");?> </span><br>
<span><?=dil("TX591");?> </span><br>
<?}?>
  </td>
  <td align="center">(<?=$row->sure;?> <?=$periyod[$row->periyod];?>)<br><?php if($row->durum == 1){
  $pkgun 	= $fonk->gun_farki($row->btarih,$bugun);
  if($pkgun <0){
?><strong style="color:red;"><?=dil("TX585");?></strong><?
}elseif($pkgun == 0){
?><strong style="color:orange;"><?=dil("TX586");?></strong><?
}elseif($pkgun>0){
?><strong style="color:green;"><?=$pkgun;?> <?=dil("TX564");?></strong><?
}}?></td>
    <td align="center">
	<?php
		if($row->durum == 0){
	?><span style="color:orange;font-weight:bold;"><?=dil("TX560");?></span><?
	}elseif($row->durum == 1){
	?><span style="color:green;font-weight:bold;"><?=dil("TX561");?></span><br><?
	}elseif($row->durum == 2){
	?><span style="color:red;font-weight:bold;"><?=dil("TX565");?></span><?
	}
	?>
    </td>
  </tr>
    <tr>
  <td colspan="3">
  <span style="float:left;"><?=dil("TX566");?>: <strong><?=date("d.m.Y H:i",strtotime($row->tarih));?></strong></span>
  <span style="float:right; margin-left:20px;"><?=dil("TX567");?>: <strong><?=$gvn->para_str($row->tutar);?> <?=dil("UYELIKP_PBIRIMI");?></strong></span>
  <span style="float:right;"><?=dil("TX568");?>: <strong><?=$row->odeme_yontemi;?></strong></span>
 
  </td>
  </tr>
    </tbody></table>
	
  </div>
  <? } ?>
  
</div><!-- tab end -->


<div class="clear"></div>
<!--div class="sayfalama">
<?php echo $pagent->listele('paketlerim?git=',$git,$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div-->

<? }else{ ?> 
<h4 style="text-align:center;margin-top:60px;"><?=dil("TX592");?></h4>
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
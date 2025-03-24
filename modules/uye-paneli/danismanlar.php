<?php
if($hesap->turu != 1){
header("Location:uye-paneli");
die();
}
?><div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX485");?></h1>
<div class="sayfayolu">
<span><?=dil("TX486");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">

<div class="content">

<?php
if($gayarlar->reklamlar == 1){ // Eğer reklamlar aktif ise...
$detect 	= (!isset($detect)) ? new Mobile_Detect : $detect;
$rtipi		= 11;
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

<div id="ucretler" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="<?=REQUEST_URL;?>#!" title="Close" class="close">X</a>
<h2><strong><?=dil("TX635");?></strong></h2>
<span>Danışmanlarınızı öne çıkarak web site anasayfasında yayınlanabilir ve daha fazla kitleye ulaşarak tanıtım yapabilirsiniz.</span><br><br>
<table width="100%">
<thead>
<tr>
<th align="left"><?=dil("TX636");?></th>
<th align="left"><?=dil("TX536");?></th>
</tr>
</thead>
<tbody>
<?php
$ua			= $fonk->UyelikAyarlar();
$ucretler	= $ua["danisman_onecikar_ucretler"];
foreach($ucretler AS $ucret){
?>
<tr>
<td><?=$ucret["sure"];?> <?=$periyod[$ucret["periyod"]];?></td>
<td><?=$gvn->para_str($ucret["tutar"])." ".dil("DONECIKAR_PBIRIMI");?></td>
</tr>
<?}?>
</tbody>
</table>


<div class="clear"></div>
</div>
</div>
</div>


<div class="uyedetay">
<div class="uyeolgirisyap">
<h4 class="uyepaneltitle"><?=dil("TX485");?> <a class="gonderbtn" href="uye-paneli?rd=danisman_ekle"><i style="margin-right:10px;" class="fa fa-plus"></i> <?=dil("TX494");?></a>
<a style="margin-right:10px;"  class="gonderbtn" href="#ucretler"><i style="margin-right:10px;" class="fa fa-rocket" aria-hidden="true"></i> <?=dil("TX635");?></a></h4>

<div class="clear"></div>



<?php
$git		= $gvn->zrakam($_GET["git"]);
$qry		= $pagent->sql_query("SELECT id,concat_ws(' ',adi,soyadi) AS adsoyad,durum,olusturma_tarih,son_giris_tarih,avatar,nick_adi,onecikar,onecikar_btarih FROM hesaplar WHERE site_id_555=999 AND (durum=0 OR durum=1) AND kid=".$hesap->id." ORDER BY id DESC",$git,6);
$query 		= $db->query($qry['sql']);
$adet		= $qry['toplam'];

?>

<?php
if($adet > 0 ){
?>
<div id="hidden_result" style="display:none"></div>
<table width="100%" border="0" id="uyepanelilantable">
  <tr>
    <td id="mobtd" bgcolor="#EFEFEF"><strong><?=dil("TX487");?></strong></td>
    <td bgcolor="#EFEFEF"><strong><?=dil("TX488");?></strong></td>
    <td align="center" bgcolor="#EFEFEF"><strong><?=dil("TX234");?></strong></td>
    <td width="15%" align="center" bgcolor="#EFEFEF"><strong><?=dil("TX235");?></strong></td>
  </tr>
  
  
<?php

$onchediye		= $db->query("SELECT id FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND danisman_onecikar=1 AND danisman_onecikar_use=1");
if($onchediye->rowCount()<1){
$hediye		= $db->query("SELECT id,danisman_onecikar,danisman_onecikar_sure,danisman_onecikar_periyod FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND danisman_onecikar=1 AND btarih>NOW()");
if($hediye->rowCount()>0){
$hediye			= $hediye->fetch(PDO::FETCH_OBJ);
}
}


$bugun		= date("Y-m-d");
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$prolink	= ($row->nick_adi == '') ? 'profil/'.$row->id : 'profil/'.$row->nick_adi;
$otarih		= date("d.m.Y H:i",strtotime($row->olusturma_tarih));
$avatar		= ($row->avatar == '') ? 'https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' : 'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/'.$row->avatar;
$adsoyad	= $row->adsoyad;

	if($row->onecikar == 1){
	$onecikarma			= true;
	$siparis	= $db->query("SELECT id,tarih,btarih,durum FROM onecikan_danismanlar_19541956 WHERE did=".$row->id." AND durum=1 AND btarih>NOW() ORDER BY id DESC");
	if($siparis->rowCount()>0){
	$siparis	= $siparis->fetch(PDO::FETCH_OBJ);
	}
	
	$dkgun		= $fonk->gun_farki($row->onecikar_btarih,$bugun);
	if($dkgun<0){
	$durumne  = dil("TX640");
	}elseif($dkgun==0){
	$durumne  = dil("TX641");
	}elseif($dkgun>0){
	$durumne  = dil("TX642") .$dkgun;
	}
	
	$aciklama_cikarma	= ($dkgun <0) ? dil("TX637") : dil("TX638");
	$baslangic_cikarma 	= ($siparis->id != '') ? dil("TX639") .date("d.m.Y",strtotime($siparis->tarih))." /" : '';
	$bitis_cikarma 		= date("d.m.Y",strtotime($row->onecikar_btarih));
	}else{
	$onecikarma			= false;
	}
	
	$bcikarma			= $db->query("SELECT id FROM onecikan_danismanlar_19541956 WHERE did=".$row->id." AND durum=0 ORDER BY id DESC");
	$bcikarma			= $bcikarma->rowCount();
	
?>
  <tr id="row_<?=$row->id;?>">
    <td width="75" id="mobtd"><img src="<?=$avatar;?>" width="75" height="75"/></td>
    <td><a target="_blank" href="<?=$prolink;?>"><h5 style="font-size:16px;margin-bottom:5px;"><strong><?php echo $adsoyad;?></strong></h5></a> 
	<?if($bcikarma>0){?>
	<span style="font-weight:bold;color:orange">(<?=dil("TX661");?>)</span><br>
	<?}elseif($onecikarma){?>
	<span style="font-weight:bold;color:orange">(<?=$aciklama_cikarma;?>)</span><br><strong><?=$durumne;?></strong> - <?=($baslangic_cikarma != '' ) ? $baslangic_cikarma : '';?> <?=dil("TX643");?> <?=$bitis_cikarma;?><br>
	<?}?>
    <span class="ilantarih"><?=dil("TX489");?> <?=$otarih;?></span>
    </td>
    <td align="center">
	<?php
	if($row->durum == 0){
	?><span style="color:green;font-weight:bold;"><?=dil("TX491");?></span><?
	}elseif($row->durum == 1){
	?><span style="color:orange;font-weight:bold;"><?=dil("TX490");?></span><?
	}
	?>
	</td>
    <td width="15%" align="center">
	
    <a title="Düzenle" class="uyeilankontrolbtn" href="uye-paneli?rd=danisman_duzenle&id=<?=$row->id;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    <div class="clearmob"></div>
	<? if($onecikarma==false && $bcikarma<1){?>
	<a title="Öne Çıkarın" id="RoketButon<?=$row->id;?>" class="uyeilankontrolbtn" href="javascript:void(0);" onclick="<?=($hediye->id!='') ? "if(confirm('".dil("TX658")."')){" : '';?>ajaxHere('ajax.php?p=danisman_onecikar&id=<?=$row->id;?>','hidden_result');<?=($hediye->id!='') ? '}' : '';?>"><i class="fa fa-rocket" aria-hidden="true"></i></a>
	<?}?>
	<div class="clearmob"></div>
	<a title="Sil" class="uyeilankontrolbtn" href="javascript:;" onclick="SilDanisman(<?=$row->id;?>);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
    </td>
  </tr>
  <? } ?>
  
  </table>


<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele('eklenen-danismanlar?git=',$git,$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>

<? }else{ ?> 
<h4 style="text-align:center;margin-top:60px;"><?=dil("TX492");?></h4>
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

<input type="hidden" name="delete_id" id="delete_id" value="0">
<div class="remodal" data-remodal-id="DanismanSil"
  data-remodal-options="hashTracking:false,closeOnOutsideClick:false">

  <button data-remodal-action="close" class="remodal-close"></button>
  <h1><?=dil("TX498");?></h1>
  <p>
    <?=dil("TX499");?>
  </p>
  <br>
  <?php
  $secenek	= explode("|",dil("TX500"));
  ?>
  <button  class="remodal-confirm" onclick="DanismanSil(1);"><i class="fa fa-check" aria-hidden="true"></i> <?=$secenek[0];?></button>
  <button  class="remodal-cancel" onclick="DanismanSil(0);"><i class="fa fa-times" aria-hidden="true"></i> <?=$secenek[1];?></button>
  <button data-remodal-action="close" class="remodal-cancel"><?=$secenek[2];?></button>
</div>
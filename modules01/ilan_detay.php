<?php if(!defined("THEME_DIR")){die();} $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($sayfay->durum != 1){

if($hesap->id == ''){
include THEME_DIR."404.php";
die();
}else{
if($hesap->tipi != 1){
$kid  = $db->query("SELECT kid FROM hesaplar WHERE site_id_555=999 AND id=".$sayfay->acid)->fetch(PDO::FETCH_OBJ)->kid;
if($sayfay->acid != $hesap->id AND $hesap->id != $kid){
include THEME_DIR."404.php";
die();
}
}
}
}

try{
$surevar    = $db->query("SELECT DISTINCT t1.id FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t2.ilan_id=t1.id AND t2.durum=1 WHERE t1.site_id_555=999 AND t1.id=".$sayfay->id." AND (t1.btarih>NOW() OR t2.btarih>NOW())");
$surevar    = $surevar->rowCount();
}catch(PDOException $e){
die($e->getMessage());
}

	$linkcek = "https://www.turkiyeemlaksitesi.com.tr";
$fiyat_int    = $gvn->para_int($sayfay->fiyat);
$fiyat      = $gvn->para_str($fiyat_int);

$aidat_int    = $gvn->para_int($sayfay->aidat);
$aidat      = $gvn->para_str($aidat_int);

$ulke     = $db->query("SELECT ulke_adi FROM ulkeler_19541956 WHERE id=".$sayfay->ulke_id)->fetch(PDO::FETCH_OBJ)->ulke_adi;
$il       = $db->query("SELECT il_adi,slug FROM il WHERE id=".$sayfay->il_id)->fetch(PDO::FETCH_OBJ);
$il_slug    = $il->slug;
$il       = $il->il_adi;
$ilce     = $db->query("SELECT ilce_adi,slug FROM ilce WHERE id=".$sayfay->ilce_id)->fetch(PDO::FETCH_OBJ);
$ilce_slug    = $ilce->slug;
$ilce     = $ilce->ilce_adi;
$mahalle    = $db->query("SELECT mahalle_adi,slug FROM mahalle_koy WHERE id=".$sayfay->mahalle_id)->fetch(PDO::FETCH_OBJ);
$mahalle_slug = $mahalle->slug;
$mahalle    = $mahalle->mahalle_adi;
$search     = SITE_URL;
$search     .= ($sayfay->emlak_durum != '') ? $gvn->PermaLink($sayfay->emlak_durum)."/" : '';
$search     .= ($sayfay->emlak_tipi != '') ? $gvn->PermaLink($sayfay->emlak_tipi)."/" : '';
$search     .= ($sayfay->konut_sekli != '') ? $gvn->PermaLink($sayfay->konut_sekli)."/" : '';
$search     .= ($sayfay->konut_tipi != '') ? $gvn->PermaLink($sayfay->konut_tipi)."/" : '';
$tarihi     = date("d-n-Y",strtotime($sayfay->tarih));
$tarihi     = explode("-",$tarihi);

$db->query("UPDATE sayfalar SET hit=hit+1 WHERE site_id_555=999 AND id=".$sayfay->id);

$arsa     = $fonk->get_lang($sayfay->dil,"EMLK_TIPI");
$arsa     = explode("<+>",$arsa);
$isyeri       = $arsa[1];
$arsa     = $arsa[2];
$ilan_linki   = ($dayarlar->permalink == 'Evet') ? $sayfay->url.'.html' : 'index.php?p=sayfa&id='.$sayfay->id;

/*
Danışman için kontroller
*/
if($sayfay->danisman_id != 0 AND $sayfay->danisman_id != 1){
$danisman   = $db->prepare("SELECT * FROM danismanlar_19541956 WHERE id=?");
$danisman->execute(array($sayfay->danisman_id));
if($danisman->rowCount()>0){
$danisman   = $danisman->fetch(PDO::FETCH_OBJ);

$adsoyad    = $danisman->adsoyad;
	
$gsm      = ($danisman->gsm != '') ? $danisman->gsm : '';
$telefon    = ($danisman->telefon != '') ? $danisman->telefon : '';
$demail     = ($danisman->email != '') ? $danisman->email : '';
$davatar    = ($danisman->resim != '') ? 'uploads/thumb/'.$danisman->resim : 'uploads/default-avatar.png';
$profil_link  = "javascript:void(0);";
}else{
$uye_id     = $sayfay->danisman_id;
}
}else{
/*sitede ilanların, ilan sahibi bilgileri ile gözükmesi istenirse acid=XXX; de XXX yerine site sahibinin hesap kodu yazılacak. İlan sahibinin bilgileri ile gözükmesi istenirse acid; şeklinde düzeltilecek.*/
$uye_id     = $sayfay->acid=XXX;
}

if($uye_id != ''){
$uyee     = $db->prepare("SELECT *,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
/*sitede ilanların, danışman adıyla bilgileri ile gözükmemesi için $uye_id=XXX de =XXX yerine site sahibinin hesap kodu yazılacak. Danışmanın bilgileri ile gözükmesi istenirse $uye_id şeklinde bırakılacak.*/
$uyee->execute(array($uye_id=XXX));
if($uyee->rowCount()>0){
$uyee     = $uyee->fetch(PDO::FETCH_OBJ);

$adsoyad    = ($uyee->unvan == '') ? $uyee->adsoyad : $uyee->unvan;
$gsm      = ($uyee->telefon != '' AND $uyee->telefond == 0) ? $uyee->telefon : '';
$telefon    = ($uyee->sabit_telefon != '' AND $uyee->sabittelefond == 0) ? $uyee->sabit_telefon : '';
$demail     = ($uyee->email != '' AND $uyee->epostad == 0) ? $uyee->email : '';
$davatar    = ($uyee->avatar != '' AND $uyee->avatard == 0) ? 'uploads/thumb/'.$uyee->avatar : 'uploads/default-avatar.png';

$profil_link  = "profil/";
$profil_link  .= ($uyee->nick_adi == '') ? $uyee->id : $uyee->nick_adi;
}
}


$hit      = @$fonk->SayiDuzelt($sayfay->hit);

if($gayarlar->doviz == 1){
$xml        = @simplexml_load_file("https://www.tcmb.gov.tr/kurlar/today.xml");
if(count($xml->Currency)>0){
foreach ($xml->Currency as $Currency) {
if($Currency["Kod"] == "USD") {
$usd_DS   = $Currency->BanknoteSelling;
$usd_DA   = $Currency->BanknoteBuying;
}elseif($Currency["Kod"] == "EUR"){
$eur_DS   = $Currency->BanknoteSelling;
$eur_DA   = $Currency->BanknoteBuying;
}elseif($Currency["Kod"] == "GBP"){
$gbp_DS   = $Currency->BanknoteSelling;
$gbp_DA   = $Currency->BanknoteBuying;
}elseif($Currency["Kod"] == "CHF"){
$chf_DS   = $Currency->BanknoteSelling;
$chf_DA   = $Currency->BanknoteBuying;
}
}
}
}
  
?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=($sayfay->title == '') ? $sayfay->baslik : $sayfay->title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$sayfay->keywords;?>" />
<meta name="description" content="<?=$sayfay->description;?>" />
<meta name="robots" content="All" />
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<meta property="og:image" content="<?php echo "http://".$_SERVER['SERVER_NAME']; ?>/uploads/<?=$sayfay->resim;?>"/>
<meta property="og:title" content="<?=($sayfay->title == '') ? $sayfay->baslik : $sayfay->title;?>" />
<meta property="og:description" content="<?=$sayfay->description;?>" />
<!-- Meta Tags -->

<?php $category=true; include THEME_DIR."inc/head.php"; ?>

<link rel="stylesheet" type="text/css" href="<?=THEME_DIR;?>glib/pgwslideshow.min.css" />
<link rel="stylesheet" type="text/css" href="<?=THEME_DIR;?>glib/pgwslideshow_light.css" />

</head>
<body>
<? include THEME_DIR."inc/header.php"; ?>

<div class="headerbg" <?=($sayfay->resim2  != '') ? 'style="background-image: url(uploads/'.$sayfay->resim2.');"' : 'style="background-image: url(uploads/'.$gayarlar->bayiler_resim.');"'; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=$fonk->get_lang($sayfay->dil,"TX139");?></h1>
<div class="sayfayolu">
<a href="index.html"><?=$fonk->get_lang($sayfay->dil,"TX136");?></a>

<?if($sayfay->emlak_durum != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$gvn->PermaLink($sayfay->emlak_durum);?>"><?=$sayfay->emlak_durum;?></a>
<?}?>

<?if($sayfay->emlak_tipi != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$gvn->PermaLink($sayfay->emlak_tipi);?>"><?=$sayfay->emlak_tipi;?></a>
<?}?>

<?if($sayfay->konut_sekli != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$gvn->PermaLink($sayfay->konut_sekli);?>"><?=$sayfay->konut_sekli;?></a>
<?}?>

<?if($sayfay->konut_tipi != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$gvn->PermaLink($sayfay->konut_tipi);?>"><?=$sayfay->konut_tipi;?></a>
<?}?>

<?if($il != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$il_slug;?>"><?=$il;?></a>

<?if($ilce != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$il_slug;?>-<?=$ilce_slug;?>"><?=$ilce;?></a>

<?if($mahalle != ''){?>
 <i class="fa fa-caret-right" aria-hidden="true"></i> <a href="<?=$il_slug;?>-<?=$ilce_slug;?>-<?=$mahalle_slug;?>"><?=$mahalle;?></a>
<?}?>

<?}?>

<?}?>

</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<?php if($surevar == 0){ include THEME_DIR."ilan_detay_sure_doldu.php"; die(); } ?>

<div id="wrapper">

<div class="content" id="bigcontent">
<? include THEME_DIR."inc/sosyal_butonlar.php"; ?>

<div class="altbaslik">
<h4><strong><?=$sayfay->baslik;?></strong></h4>
</div>

<style>
.ilanyeniozellik {
padding: 0px 5px;
    /* background: green; */
    color: green;
    font-size: 12px;
    border: 1px solid green;
    margin-left: 2px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-top: -10px;
    position: absolute;
}
</style>


<?if($hesap->id == ''){?>
<div id="uyemsjgonder" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="#!" title="Close" class="close">X</a>
<h2><strong><?=$adsoyad;?></strong> / <?=$fonk->get_lang($sayfay->dil,"TX413");?></h2><br>
<center><strong><?=$fonk->get_lang($sayfay->dil,"TX414");?></strong>
<div class="clear"></div><br><br>
<a href="giris-yap" class="gonderbtn"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX356");?></a><div class="clearmob"></div> <span><?=$fonk->get_lang($sayfay->dil,"TX415");?></span> <a href="hesap-olustur" class="gonderbtn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX125");?></a>
<br><br><br>
</center>
<div class="clear"></div>
</div>
</div>
</div>

<div id="HataliBildir" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="#!" title="Close" class="close">X</a>
<h2><?=$fonk->get_lang($sayfay->dil,"TX428");?></h2><br>
<center><strong><?=$fonk->get_lang($sayfay->dil,"TX414");?></strong>
<div class="clear"></div><br><br>
<a href="giris-yap" class="gonderbtn"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX356");?></a><div class="clearmob"></div> <span><?=$fonk->get_lang($sayfay->dil,"TX415");?></span> <a href="hesap-olustur" class="gonderbtn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX125");?></a>
<br><br><br>
</center>
<div class="clear"></div>
</div>
</div>
</div>
<?}?>

<?if($hesap->id != ''){?>
<div id="uyemsjgonder" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="#!" title="Close" class="close">X</a>
<h2><strong><?=$adsoyad;?></strong> / <?=$fonk->get_lang($sayfay->dil,"TX413");?></h2>
<form action="ajax.php?p=mesaj_gonder&uid=<?=$uyee->id;?>&from=adv" method="POST" id="MesajGonderForm">
<textarea rows="3" name="mesaj" id="MesajYaz"><?php echo $fonk->get_lang($sayfay->dil,"TX412"); ?></textarea>
<input type="hidden" name="ilan_linki" value="<?php echo SITE_URL.$ilan_linki; ?>">
<a href="javascript:;" onclick="AjaxFormS('MesajGonderForm','MesajGonderSonuc');" style="float:right;" class="gonderbtn"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX405");?></a>
</form>
<div id="TamamPnc" style="display:none"><?=$fonk->get_lang($sayfay->dil,"TX423");?></div>
<div class="clear"></div>
<div id="MesajGonderSonuc" style="display:none"></div>
</div>
</div>
</div>


<div id="HataliBildir" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="#!" title="Close" class="close">X</a>
<h2><?=$fonk->get_lang($sayfay->dil,"TX428");?></h2>
<span style="    font-size: 13px;    margin-bottom: 15px;    float: left;"><?=$fonk->get_lang($sayfay->dil,"TX452");?></span>
<form action="ajax.php?p=hatali_bildir&id=<?=$sayfay->id;?>" method="POST" id="HataliBildirForm">
<textarea rows="3" name="mesaj" placeholder="<?=$fonk->get_lang($sayfay->dil,"TX450");?>"></textarea>
<br />
<a href="javascript:;" onclick="AjaxFormS('HataliBildirForm','HataliBildirFormSonuc');" style="float:right;" class="gonderbtn"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX405");?></a>
</form>
<div id="BiTamamPnc" style="display:none"><?=$fonk->get_lang($sayfay->dil,"TX449");?></div>
<div class="clear"></div>
<div id="HataliBildirFormSonuc" style="display:none"></div>
</div>
</div>
</div>
<?}?>

<ul class="tab">
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'detaylar')" id="defaultOpen"><i class="fa fa-info" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,'TX416');?></a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event,'ilan_video')"><i class="fa fa-video-camera" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,'TX417');?></a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'ilan_harita')"><i class="fa fa-map-marker" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,'TX418');?></a></li>
  <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'sokak_gorunumu')"><i class="fa fa-street-view" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,'TX419');?></a></li>
  
<div class="favyaz">
<script type="text/javascript">
function favEkle(id){
<?if($hesap->id == ''){?>
alert("<?=$fonk->get_lang($sayfay->dil,"TX434");?>");
<?}else{?>
$("#favOn").slideUp(300,function(){
$("#favOff").slideDown(300);
});
$.get("ajax.php?p=favori",{'id':id},function(data){
if(data != undefined){
if(data == 1){
// ok
}
}
});
<?}?>
}

function favCikar(id){
<?if($hesap->id == ''){?>
alert("<?=$fonk->get_lang($sayfay->dil,"TX434");?>");
<?}else{?>
$("#favOff").hide(1,function(){
$("#favOn").show(1);
});
$.get("ajax.php?p=favori",{'id':id},function(data){
if(data != undefined){
if(data == 1){
// ok
}
}
});
<?}?>
}
</script>
<?php
if($hesap->id != ''){
$favKontrol = $db->query("SELECT id FROM favoriler_19541956 WHERE acid=".$hesap->id." AND ilan_id=".$sayfay->id);
$favKontrol = $favKontrol->rowCount();
if($favKontrol>0){
$favNe    = 1;
}else{
$favNe    = 0;
}}else{
$favNe    = 0;
}

?>
<a href="javascript:void(0);" id="favOff" onclick="favCikar(<?=$sayfay->id;?>);"<?=($favNe==false) ? ' style="display:none"' : '';?>><i id="favyazaktif"  class="fa fa-heart" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX431");?></a>
<a href="javascript:void(0);" id="favOn" onclick="favEkle(<?=$sayfay->id;?>);"<?=($favNe==true) ? ' style="display:none"' : '';?>><i class="fa fa-heart-o" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX432");?></a>
<div class="desktopclear"></div>
<a onclick="window.print();" href="#!"><i class="fa fa-print" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX433");?></a>
</div>
</ul>


<div id="detaylar" class="tabcontent"><!-- detaylar start div -->


<div class="ilandetay">

<div class="ilanfotolar">

<div id="image-gallery" style="display:none">
<?php
	
$image_list = array();
$sql    = $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$sayfay->id." ORDER BY sira ASC");
if($sql->rowCount()>0){
  $image_list   = $sql->fetchAll();
}else{
  $qu   = $db->prepare("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=999 AND ilan_no=? ORDER BY id ASC");
  $qu->execute(array($sayfay->ilan_no));
  if($qu->rowCount()>0){
    while($qrow = $qu->fetch(PDO::FETCH_OBJ)){
      if(count($image_list)<1){
        $varmi    = $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$qrow->id." ORDER BY sira ASC");
        if($varmi->rowCount()>0){
          $image_list   = $varmi->fetchAll();
        }
      }
    }
  }
}

if(!$image_list){
  $image_list[] = [
    'id' => 0,
    'resim' => $sayfay->resim,
  ];
}

foreach($image_list AS $row){
?>
<a class="ilandetaybigfoto" data-exthumbimage="<?=$linkcek; ?>/uploads/<?=$row['resim'];?>" data-src="<?=$linkcek; ?>/uploads/<?=$row['resim'];?>" id="mega<?=$row['id'];?>">Mega Foto #<?=$row['id'];?></a>
<? } 
?>
</div>
  
    <div class="clearfix" >
                <ul id="image-slider" class="gallery list-unstyled cS-hidden" style="width:100%;">
        <?php
        if($image_list){
        foreach($image_list AS $row){
        ?>
        <li data-thumb="<?=$linkcek; ?>/uploads/thumb/<?=$row['resim'];?>" onclick="$('#mega<?=$row['id'];?>').click();">
          <img style="width:100%;cursor: crosshair;" src="<?=$linkcek; ?>/uploads/<?=$row['resim'];?>" />
        </li>
        <? } } ?>
                </ul>
            </div>
      
      

</div>
</div>


<style>
.ilanozellikler table tr td {padding:4px;}
</style>

<div class="ilanozellikler">
<table width="100%" border="0">

  <? if($sayfay->fiyat != '' AND $sayfay->fiyat != 0){ ?>
  <tr>
    <td colspan="2"><h3><strong><?=$fiyat.' '.$sayfay->pbirim; ?></strong></h3></td>
    </tr><? } ?>
   <tr>
    <td height="20" bgcolor="#eee" colspan="2"><h5>

  <? if($ulke != '' AND $ulke != "Türkiye"){?><a href="javascript:;"><?=$ulke;?></a> / <? } ?>
  <? if($il != ''){?><a href="<?=$search.$il_slug;?>"><?=$il;?></a>
  <? if($ilce != ''){?> / <a href="<?=$search.$il_slug."-".$ilce_slug;?>"><?=$ilce;?></a>
  <? if($mahalle != ''){?> / <a href="<?=$search.$il_slug."-".$ilce_slug."-".$mahalle_slug;?>"><?=$mahalle;?></a><?}?>
  <? if($mahalle == '' && $sayfay->semt != ''){?> / <a href="javascript:void(0);"><?=$sayfay->semt;?></a><?}?>
  <?}}?>
  </h5></td>
    </tr>
  <tr>
    <td width="52%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX140");?></td>
    <td width="50%" ><?=$sayfay->ilan_no;?></td>
  </tr>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX141");?></td>
    <td width="50%"><?=$tarihi[0].' '.$aylar[$tarihi[1]].' '.$tarihi[2];?></td>
  </tr>

  <? if($sayfay->emlak_durum != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX5311");?></td>
    <td width="50%"><?=$sayfay->emlak_durum;?></td>
  </tr>
  <? } ?> 
	

  <? if($sayfay->emlak_tipi != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX5411");?></td>
    <td width="50%"><?=$sayfay->emlak_tipi;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->konut_sekli != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX58");?></td>
    <td width="50%"><?=$sayfay->konut_sekli;?></td>
  </tr>
  <? } ?> 
 
  <? if($sayfay->konut_tipi != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX142");?></td>
    <td width="50%" ><?=$sayfay->konut_tipi;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->metrekare != '' OR $sayfay->metrekare != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX143");?></td>
    <td width="50%"><?=$sayfay->metrekare;?></td>
  </tr>
  <? } ?>

    <? if($sayfay->brut_metrekare != '' AND $sayfay->brut_metrekare != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX1431");?></td>
    <td width="50%"><?=$sayfay->brut_metrekare;?></td>
  </tr>
  <? } ?>

<? if($sayfay->emlak_tipi == $arsa){ ?>

  <? if($sayfay->metrekare_fiyat != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX327");?></td>
    <td width="50%"><?=$sayfay->metrekare_fiyat;?></td>
  </tr>
  <? } ?>


  <? if($sayfay->ada_no != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX328");?></td>
    <td width="50%"><?=$sayfay->ada_no;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->parsel_no != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX329");?></td>
    <td width="50%"><?=$sayfay->parsel_no;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->pafta_no != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX330");?></td>
    <td width="50%"><?=$sayfay->pafta_no;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->kaks_emsal != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX331");?></td>
    <td width="50%"><?=$sayfay->kaks_emsal;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->gabari != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX332");?></td>
    <td width="50%"><?=$sayfay->gabari;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->imar_durum != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX682");?></td>
    <td width="50%"><?=$sayfay->imar_durum;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->tapu_durumu != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX333");?></td>
    <td width="50%"><?=$sayfay->tapu_durumu;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->katk != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX334");?></td>
    <td width="50%"><?=$sayfay->katk;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->takas != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX336");?></td>
    <td width="50%"><?=$sayfay->takas;?></td>
  </tr>
  <? } ?>
<? } ?>

  <? if($sayfay->krediu != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX335");?></td>
    <td width="50%"><?=$sayfay->krediu;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->oda_sayisi != '' OR $sayfay->oda_sayisi != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX144");?></td>
    <td width="50%" ><?=$sayfay->oda_sayisi;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->bina_yasi != '' OR $sayfay->bina_yasi != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX145");?></td>
    <td width="50%"><?=$sayfay->bina_yasi;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->bulundugu_kat != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX146");?></td>
    <td width="50%" ><?=$sayfay->bulundugu_kat;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->bina_kat_sayisi != '' AND $sayfay->bina_kat_sayisi != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX147");?></td>
    <td width="50%"><?=$sayfay->bina_kat_sayisi;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->isitma != '' && $sayfay->emlak_tipi != $arsa){ ?>
    <tr>
      <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX148");?></td>
      <td width="50%"><?=$sayfay->isitma;?></td>
    </tr>
    <? } ?>
  
    <? if($sayfay->banyo_sayisi != '' AND $sayfay->banyo_sayisi != 0){ ?>
    <tr>
      <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX149");?></td>
      <td width="50%"><?=$sayfay->banyo_sayisi;?></td>
    </tr>
    <? } ?>
  
    <? if($sayfay->esyali != '' && $sayfay->emlak_tipi != $arsa){ ?>
    <tr>
      <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX150");?></td>
      <td width="50%" ><?=($sayfay->esyali == 1) ? "".$fonk->get_lang($sayfay->dil,"TX167")."" : "".$fonk->get_lang($sayfay->dil,"TX168")."";?></td>
    </tr>
    <? } ?>


  <? if($sayfay->kullanim_durum != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX151");?></td>
    <td width="50%"><?=$sayfay->kullanim_durum;?></td>
  </tr>
  <? } ?>

  <? if($sayfay->site_ici != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX152");?></td>
    <td width="50%" ><?=($sayfay->site_ici == 1) ? "".$fonk->get_lang($sayfay->dil,"TX167")."" : "".$fonk->get_lang($sayfay->dil,"TX168")."";?></td>
  </tr>
  <? } ?>

  <? if($aidat_int != '' OR $aidat_int != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX153");?></td>
    <td width="50%"><?=$aidat.' '.$sayfay->pbirim;?></td>
  </tr>
  <? } ?>
  
  <? if($sayfay->kimden != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX460");?></td>
    <td width="50%"><?=$sayfay->kimden;?></td>
  </tr>
  <? } ?>
  
  <? if($sayfay->yetkis != ''){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX624");?></td>
    <td width="50%"><?=$sayfay->yetkis;?></td>
  </tr>
  <? } ?>
  
   <? if($sayfay->yetki_bilgisi != '' OR $sayfay->yetki_bilgisi != 0){ ?>
  <tr>
    <td width="50%" style="font-weight:bolder;"><?=$fonk->get_lang($sayfay->dil,"TX1451");?></td>
    <td width="50%"><?=$sayfay->yetki_bilgisi;?></td>
  </tr>
  <? } ?>


  </table>

</div>



<!-- danisman start -->

<div class="danisman">
<h3 class="danismantitle"><?=($uyee->id == '' OR $uyee->turu==2 OR $uyee->turu==1) ? $fonk->get_lang($sayfay->dil,"TX155") : $fonk->get_lang($sayfay->dil,"TX154");?></h3>

<a href="<?=$profil_link;?>"><img src="https://www.turkiyeemlaksitesi.com.tr/<?=$davatar;?>" width="200" height="150"></a>

<h4><strong><a href="<?=$profil_link;?>"><?=$adsoyad;?><?php
$sql = $db->query("SELECT id, kid, adi, soyadi, avatar, avatard, nick_adi FROM hesaplar WHERE site_id_555=888 AND durum = 0 AND turu = 2 AND onecikar = 1 AND onecikar_btarih > NOW() ORDER BY RAND() LIMIT 0, 12");

?>
</a></strong></h4>
<?php
if($adsoyad != $uyee->unvan):
?>
	<span>
		<?=$uyee->dunvan;?>
	</span>
<?php endif;?>			

<div class="clear"></div>
<div class="iletisim" style="display: flex; justify-content: space-evenly;">
    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?= rawurlencode($uyee->telefon); ?>&text=<?= rawurlencode($link); ?>%20<?= rawurlencode('Bu ilan hakkında bilgi almak istiyorum');?>" class="whatsappbtn gonderbtn" style="width: 20px; height: 20px; margin-top: 15px; float: none; display: inline-block;">
        <img src="https://i.hizliresim.com/8wlrjtp.png" alt="WhatsApp" style="width: 100%; height: 100%;">
    </a>
    <a target="_blank" href="https://t.me/share/url?url=<?= rawurlencode($link); ?>&text=<?= rawurlencode($sayfay->baslik); ?>" class="telegrambtn gonderbtn" style="width: 20px; height: 20px; margin-top: 15px; float: none; display: inline-block;">
        <img src="https://i.hizliresim.com/cfgqfse.png" alt="Telegram" style="width: 100%; height: 100%;">
    </a>
</div>


<?php
if($uyee->id != ''){
$portfoyu = ($uyee->turu == 1 OR $uyee->turu == 2) ? '/portfoy' : '';
?>
<a href="<?=$profil_link.$portfoyu;?>" class="gonderbtn" target="_blank" style="font-size:14px;padding: 7px 0px;width:140px;margin-top: 15px;float:none;    display: inline-block;"><i class="fa fa-search" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX391");?></a><div class="clear"></div>

<?if($uyee->id != $hesap->id){?>
<?if($gayarlar->anlik_sohbet==1){?>
<a href="#uyemsjgonder" class="gonderbtn" style="font-size:14px;padding: 7px 0px;width:140px;margin-top: 5px;float:none;    display: inline-block;"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX392");?></a>
<div class="clear"></div>
<?}?>
<?}?>

<? } ?>
	
<? if($gsm != ''){ ?><h5 class="profilgsm"> <strong><a style="color:white;" <a href="tel:<?=$gsm;?>"><?=$gsm;?></a></strong> <span style="margin-left:5px;font-size:13px;"> <?=$fonk->get_lang($sayfay->dil,"TX156");?></span></h5><? } ?>

<? if($demail != ''){ ?><h5><strong><?=$fonk->get_lang($sayfay->dil,"TX158");?></strong><br><a href="mailto:<?=$demail;?>" target="_blank" ><?=$demail;?></a></h5><? } ?>

<div class="clear" style="margin-top:15px;"></div>
<a href="#HataliBildir" class="gonderbtn" style="font-size:13px;padding: 7px 0px;width:140px;margin-top: 5px;margin-bottom:10px;float:none;    display: inline-block;"><i class="fa fa-bell-o" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX428");?></a>

<div class="clear"></div>


</div>
<!-- danisman end -->


<div class="clear"></div>

<? if($fonk->bosluk_kontrol(strip_tags($sayfay->icerik)) == false){ ?>
<div class="ilanaciklamalar">
<h3><?=$fonk->get_lang($sayfay->dil,"TX161");?></h3>

<p><?=$sayfay->icerik;?></p>

</div>
<? } ?>

<?=str_replace("[hit]",$hit,$fonk->get_lang($sayfay->dil,"TX459"));?>

<?php
$delm1  = explode("<+>",$fonk->get_lang($sayfay->dil,"CEPHE"));
$delm2  = explode("<+>",$fonk->get_lang($sayfay->dil,"IC_OZELLIKLER"));
$delm3  = explode("<+>",$fonk->get_lang($sayfay->dil,"DIS_OZELLIKLER"));
$delm4  = explode("<+>",$fonk->get_lang($sayfay->dil,"ALTYAPI_OZELLIKLER"));
$delm5  = explode("<+>",$fonk->get_lang($sayfay->dil,"KONUM_OZELLIKLER"));
$delm6  = explode("<+>",$fonk->get_lang($sayfay->dil,"GENEL_OZELLIKLER"));
$delm7  = explode("<+>",$fonk->get_lang($sayfay->dil,"MANZARA_OZELLIKLER"));
$cdelm1 = count($delm1);
$cdelm2 = count($delm2);
$cdelm3 = count($delm3);
$cdelm4 = count($delm4);
$cdelm5 = count($delm5);
$cdelm6 = count($delm6);
$cdelm7 = count($delm7);

if($sayfay->cephe_ozellikler != '' OR $sayfay->ic_ozellikler != '' OR $sayfay->dis_ozellikler != '' OR $sayfay->altyapi_ozellikler != '' OR $sayfay->konum_ozellikler != '' OR $sayfay->genel_ozellikler != '' OR $sayfay->manzara_ozellikler != ''){
if($cdelm1 > 1 OR $cdelm2 > 1 OR $cdelm3 > 1 OR $cdelm4 > 0 OR $cdelm5 > 0 OR $cdelm6 > 0 OR $cdelm7 > 0){
?>
<div class="ilanaciklamalar">
<h3><?=$fonk->get_lang($sayfay->dil,"TX162");?></h3>

<? if($sayfay->emlak_tipi == $arsa){ ?>

    <?php
    if($cdelm4 > 1){
    $ielm = explode("<+>",$sayfay->altyapi_ozellikler);
    ?>
    <div class="ilanozellik">
    <h4><?=$fonk->get_lang($sayfay->dil,"TX323");?></h4>
    <?php
    foreach($delm4 as $val){
        if(in_array($val,$ielm)){
            ?>
            <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?=$val;?> </span>
            <?
        }
    }
    ?>
    </div>
    <? } ?>

    <?php
    if($cdelm5 > 1){
    $ielm = explode("<+>",$sayfay->konum_ozellikler);
    ?>
    <div class="ilanozellik">
    <h4><?=$fonk->get_lang($sayfay->dil,"TX324");?></h4>
    <?php
    foreach($delm5 as $val){
        if(in_array($val,$ielm)){
            ?>
            <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?=$val;?> </span>
            <?
        }
    }
    ?>
    </div>
    <? } ?>


    <?php
    if($cdelm6 > 1){
    $ielm = explode("<+>",$sayfay->genel_ozellikler);
    ?>
    <div class="ilanozellik">
    <h4><?=$fonk->get_lang($sayfay->dil,"TX325");?></h4>
    <?php
    foreach($delm6 as $val){
        if(in_array($val,$ielm)){
            ?>
            <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?=$val;?> </span>
            <?
        }
    }
    ?>
    </div>
    <? } ?>

    <?php
    if($cdelm7 > 1){
    $ielm = explode("<+>",$sayfay->manzara_ozellikler);
    ?>
    <div class="ilanozellik">
    <h4><?=$fonk->get_lang($sayfay->dil,"TX326");?></h4>
    <?php
    foreach($delm7 as $val){
        if(in_array($val,$ielm)){
            ?>
            <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?=$val;?> </span>
            <?
        }
    }
    ?>
    </div>
    <? } ?>

<? }else{ // arsa değilse?>

<?php
if ($cdelm1 > 0) { // Cephe özellikleri aktifse göster
    $ielm = explode("<+>", $sayfay->cephe_ozellikler);
    ?>
    <div class="ilanozellik">
        <h4><?= $fonk->get_lang($sayfay->dil, "TX163"); ?></h4>
        <?php
        foreach ($delm1 as $val) {
            if (in_array($val, $ielm)) {
                ?>
                <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?= $val; ?> </span>
                <?
            } 
        }
        ?>
    </div>
<? } ?>


<?php
if ($cdelm2 > 1) {
    $ielm = explode("<+>", $sayfay->ic_ozellikler);
    $aktifOzellikler = array(); // Aktif özellikleri tutmak için bir dizi oluşturun

    foreach ($delm2 as $val) {
        if (in_array($val, $ielm)) {
            $aktifOzellikler[] = $val; // Aktif özellikleri diziye ekleyin
        }
    }

    if (!empty($aktifOzellikler)) { // Aktif özellikler varsa, div'i görüntüleyin
?>
        <div class="ilanozellik">
            <h4><?= $fonk->get_lang($sayfay->dil, "TX164"); ?></h4>
            <?php
            foreach ($aktifOzellikler as $val) {
            ?>
                <span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?= $val; ?> </span>
            <?php
            }
            ?>
        </div>
<?php
    }
}
?>


  <?php
  if($cdelm3 > 1){
  $ielm = explode("<+>",$sayfay->dis_ozellikler);
  ?>
  <div class="ilanozellik">
  <h4><?=$fonk->get_lang($sayfay->dil,"TX165");?></h4>
  <?php
  foreach($delm3 as $val){
  if(in_array($val,$ielm)){
  ?><span id="ozellikaktif"><i class="fa fa-check" aria-hidden="true"></i><?=$val;?> </span><?
  }
  }
  ?>
  </div>
  <? } ?>


<? } ?>

</div><!-- İlan özellikler div end -->

<? } } ?>


<div class="clear"></div>

</div>
</div>

<div class="clear"></div>




<div id="ilan_video" class="tabcontent" style="text-align:center;">
<?if($sayfay->video == ''){?>
<h4><?=$fonk->get_lang($sayfay->dil,"TX420");?></h4>
<?}else{?>
<video width="70%" height="500" controls>
  <source src="https://www.turkiyeemlaksitesi.com.tr/uploads/videos/<?=$sayfay->video;?>" type="video/mp4"><?=$fonk->get_lang($sayfay->dil,"VIDEO_SUPPORT");?></video>
<?}?>

<div class="clear"></div>
</div>

<div id="ilan_harita" class="tabcontent"><!-- maps harita start -->
<? if($sayfay->maps != '' AND strlen($sayfay->maps) <50){?>

<?php
    $coords = $sayfay->maps;
    list($lat,$lng) = explode(",", $coords);
?>
<div id="map" style="width: 100%; height: 500px"></div>
<input type="hidden" value="<?php echo $lat; ?>" id="g_lat">
<input type="hidden" value="<?php echo $lng; ?>" id="g_lng">

<script type="text/javascript">
      function initMap() {
    var g_lat = parseFloat(document.getElementById("g_lat").value);
    var g_lng = parseFloat(document.getElementById("g_lng").value);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat:g_lat,lng:g_lng}
        });
        var geocoder = new google.maps.Geocoder();
    
    var marker = new google.maps.Marker({
            position:{
              lat:g_lat,
              lng:g_lng
            },
            map:map
          });
     
      }  
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gayarlar->google_api_key; ?>&callback=initMap"></script>





<div class="clear"></div>
<? }else{?>
<h4><?=$fonk->get_lang($sayfay->dil,"TX421");?></h4>
<? }?>
</div><!-- maps harita end -->

<div id="sokak_gorunumu" class="tabcontent">
<? if($sayfay->maps != '' AND strlen($sayfay->maps) <50){?>
<iframe  width="100%"  height="500"  frameborder="0" style="border:0"  src="https://www.google.com/maps/embed/v1/streetview?key=<?php echo $gayarlar->google_api_key; ?>&location=<?=$sayfay->maps;?>&heading=235&pitch=10&fov=90" allowfullscreen>
</iframe>
<? }else{?>
<h4><?=$fonk->get_lang($sayfay->dil,"TX421");?></h4>
<? }?>
<div class="clear"></div>
</div>

</div>

<?php
if($gayarlar->reklamlar == 1){ // Eğer reklamlar aktif ise...
$detect   = (!isset($detect)) ? new Mobile_Detect : $detect;
$rtipi    = 5;
$reklamlar  = $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1)");
$rcount   = $reklamlar->rowCount();
$order    = ($rcount>1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
$reklam   = $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) ".$order." LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
if($rcount>0){
?><!-- 728 x 90 Reklam Alanı -->
<div class="ad728home">
<?=($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu;?>
</div>
<!-- 728 x 90 Reklam Alanı END-->
<? }} // Eğer reklamlar aktif ise... ?>

<?if($gayarlar->doviz == 1 || $gayarlar->kredih == 1){?>
<div id="wrapper">

<div class="dovizkredi">
<?if($gayarlar->doviz == 1){?>
<div class="dovizkurlari">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><h4><strong><?=$fonk->get_lang($sayfay->dil,"TX461");?></strong></h4></td>
    <td align="center"><strong><?=$fonk->get_lang($sayfay->dil,"TX462");?></strong></td>
    <td align="center"><strong><?=$fonk->get_lang($sayfay->dil,"TX463");?></strong></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX464");?></td>
    <td align="center"><?=$usd_DA;?></td>
    <td align="center"><?=$usd_DS;?></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX465");?></td>
    <td align="center"><?=$eur_DA;?></td>
    <td align="center"><?=$eur_DS;?></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX466");?></td>
    <td align="center"><?=$gbp_DA;?></td>
    <td align="center"><?=$gbp_DS;?></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX467");?></td>
    <td align="center"><?=$chf_DA;?></td>
    <td align="center"><?=$chf_DS;?></td>
  </tr>
</table>
</div>
<?}?>
	
<?if($gayarlar->kredih == 1){?>
<div class="kredihesaplama">
<script type="text/javascript"> 
Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

 function DovizKontrol(x,y){
  sonuc = true;
  if (x == "vade"){
  vade = y;
  if (isNaN(vade)){
  sonuc = false;
  }
  } else if (x == "tutar"){
  if (isNaN(tutar)) {
  sonuc = false;
  }
  } else if (x == "faiz") {
  fayiz = y;
  if (isNaN(fayiz)) {
  sonuc = false;
  }
  }else{
  if (isNaN(faiz)) {
  sonuc = false;
  }
  } 
  return sonuc;
  }
  
  function KrediHesapla(){
  
  $("#error_sonuc,#sonuc").fadeOut(300);
  var sonuchtml,odeme_plani,hata,banka;
  vade    = $("#vade").val();
  tutar   = $("#tutar").val();
  faiz    = $("#faiz").val();
  
  if(faiz == 0){
  faiz    = $("#faiz_diger").val();
  }

  faiz = faiz.replace(",",".");

  var cevir;
  if(tutar.length == 9 || tutar.length == 10){
    cevir = true;
    tutar = tutar.replace(".","");
    tutar = tutar.replace(".","");
    tutar = parseFloat(tutar);
  }else{
    cevir = false;
  }
  
  tur     = $("input[name=turu]:checked").val();
  vadeKont  = DovizKontrol('vade',vade);
  tutarKont = DovizKontrol('tutar',tutar);
  faizKont  = DovizKontrol('faiz',faiz);

  
  if ( (vade == '' || vade == undefined) || (tutar == '' || tutar == undefined) || (faiz == '' || faiz == undefined || faiz == 0) ) {
  hata = '<span class="error"><?=$fonk->get_lang($sayfay->dil,"TX468");?></span>';
  } else if (vadeKont == false || tutarKont == false || faizKont == false) {
  hata = '<span class="error"><?=$fonk->get_lang($sayfay->dil,"TX469");?></span>';
  } else {
  hata  = '';
  banka = $("#faiz option:selected").text();
  
  z     = (faiz/100);
  tip     = "Konut Kredisi";
 
  taksit = (tutar * z)/(1 - 1 / (Math.pow(1+z,vade)));
  //taksit = Math.round(taksit*100)/100;
  
  toplam = taksit*vade;
  //toplam = Math.round(toplam*100)/100;
  
  if(cevir){
    taksit2   = taksit.formatMoney(2, '.', ',');
    toplam2   = toplam.formatMoney(2, '.', ',');
  }else{

  var taksit_str  = taksit.toString(); 
  yakala      = taksit_str.substr(0,2);
  if(yakala == '0.'){
  taksit_str = taksit_str.substr(2,5);
  taksit2  = taksit_str.substr(0,3)+"."+taksit_str.substr(3,2);
  }else{
  taksit2 =  taksit.toFixed(3);
  }
  toplam2   = toplam.toFixed(3);

  }

  var banka_str = banka.replace(".",",");
  var faiz_str = faiz.replace(".",",");
  sonuchtml =
 '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">'+
  '<tr>'+
    '<td width="50%"><?=$fonk->get_lang($sayfay->dil,"TX508");?></td>'+
    '<td><strong>'+tutar+' TL</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td width="50%"><?=$fonk->get_lang($sayfay->dil,"TX509");?></td>'+
    '<td><strong>'+vade+' Ay</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td><?=$fonk->get_lang($sayfay->dil,"TX510");?></td>'+
    '<td><strong>'+banka_str+'</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td><?=$fonk->get_lang($sayfay->dil,"TX510");?></td>'+
    '<td><strong>'+faiz_str+'</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td><?=$fonk->get_lang($sayfay->dil,"TX511");?></td>'+
    '<td><strong>'+taksit2+' TL</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td><?=$fonk->get_lang($sayfay->dil,"TX512");?></td>'+
    '<td><strong>'+toplam2+' TL</strong></td>'+
  '</tr>'+
  '<tr>'+
    '<td><a href="javascript:GeriDon();" class="gonderbtn"><i class="fa fa-chevron-left" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX515");?></a></td>'+
    '<td></td>'+
  '</tr>'+
  '</table>';
  
  /*
  odeme_plani = '<table class="table table-striped">'+
  '<thead>'+
  '<tr>'+
  '<th><?=$fonk->get_lang($sayfay->dil,"TX509");?></th>'+
  '<th><?=$fonk->get_lang($sayfay->dil,"TX511");?></th>'+
  '<th><?=$fonk->get_lang($sayfay->dil,"TX514");?></th>'+
  '</tr>'+
  '</thead>';
  
  kalan=toplam;
  for (var i = 1; i<=vade; i++) {
  kalan = Math.round((kalan-taksit)*100)/100;
  kalan = kalan.toFixed(3);
  odeme_plani += '<tr>'+
  '<td>'+i+'. Ay</td>'+
  '<td>'+taksit2+'  TL</td>'+
  '<td>'+kalan+' TL</td>'+
  '</tr>'; 
  }
  odeme_plani += '</table>';
  */
  
  }
  
  
  if(hata == ''){
  $("#odeme_plani").html(odeme_plani);
  $("#sonuc").html(sonuchtml);
  $("#HesaplamaForm,#error_sonuc").slideUp(300,function(){
  $("#sonuc").slideDown(300);
  });
  } else {
  $("#error_sonuc").html(hata);
  $("#error_sonuc").fadeIn(300);
  }
  
  }
  
  function GeriDon(){
  $("#error_sonuc,#sonuc").slideUp(300,function(){
  $("#HesaplamaForm").slideDown(300);
  });
  }
  
  function FaizSelected(durum){
  if(durum == 0){
  $("#faiz_diger").slideDown(500,function(){
  $("#faiz_diger").focus();
  });
  } else {
  $("#faiz_diger").slideUp(500);
  }
  }
</script>


<!--div id="odeme_plan" class="modalDialog">
<div>
<div style="padding:20px;">
<a href="#!" title="Close" class="close">X</a>
<h2>Ödeme Planı</h2><br>

<div id="odeme_plani"></div>

<div class="clear"></div>
</div>
</div>
</div-->


<div id="HesaplamaForm">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><h4><strong><?=$fonk->get_lang($sayfay->dil,"TX470");?></strong></h4></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX471");?></td>
    <td><input name="tutar" id="tutar" type="text" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"></td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX472");?></td>
    <td>
    <input name="vade" id="vade" type="text">
    </td>
  </tr>
  <tr>
    <td><?=$fonk->get_lang($sayfay->dil,"TX510");?></td>
    <td>
  <select name="faiz" id="faiz" onchange="FaizSelected(this.options[this.selectedIndex].value);">
  <?php
  $bankalar = explode(",",$fonk->get_lang($sayfay->dil,"BANKA_FAIZLER"));
  foreach($bankalar as $row){
  $parc   = explode("=",$row);
  ?><option value="<?=$parc[1];?>"><?=$parc[0];?> (%<?=$parc[1];?>)</option>
    <?
  }
  ?>
    <option value="0"><?=$fonk->get_lang($sayfay->dil,"TX516");?></option>
  </select>
  <div class="clear"></div>
  <input type="text" style="margin-top:8px; display:none" name="faiz_diger" id="faiz_diger">
  </td>
  </tr>
  
  
  <tr>
    <td colspan="2" align="right" style="border:none"><a style="float:right;margin-left:10px;" class="gonderbtn" href="javascript:KrediHesapla();"><i class="fa fa-calculator" aria-hidden="true"></i> <?=$fonk->get_lang($sayfay->dil,"TX474");?></a>
    <div id="error_sonuc" style="display:none"></div>
    </td>
  </tr>
</table>

</div>
<div id="sonuc" style="display:none"></div>
</div>
<?}?>
</div>
<?}?>

</div>

</div>
<!-- content end -->

<?php
$benzeri  = ($sayfay->il_id != 0) ? "t1.il_id=".$sayfay->il_id." " : '';
$benzeri  .= ($sayfay->ilce_id != 0) ? "OR t1.ilce_id=".$sayfay->ilce_id." " : '';
$benzeri  .= ($sayfay->mahalle_id != 0) ? "OR t1.mahalle_id=".$sayfay->mahalle_id." " : '';

$sql    = $db->query("SELECT DISTINCT t1.id,t1.url,t1.fiyat,t1.baslik,t1.resim,t1.il_id,t1.ilce_id,t1.emlak_durum,t1.pbirim,t1.emlak_tipi,t1.ilan_no FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t1.id=t2.ilan_id AND t2.durum=1 WHERE (t1.btarih>NOW() OR t2.btarih>NOW()) AND t1.site_id_555=999 AND t1.tipi=4 AND t1.durum=1 AND t1.id!=".$sayfay->id." AND (".$benzeri.") GROUP BY t1.ilan_no ORDER BY RAND() LIMIT 0,10");
if($sql->rowCount()>0){
?>
<!-- Benzer İlanlar -->
<div id="wrapper"> 
<div class="content" id="bigcontent">
<div class="altbaslik">
<div id="pager4" class="pager"></div>
<h4 id="sicakfirsatlar"><i class="fa fa-clock-o" aria-hidden="true"></i> <strong><a><?=$fonk->get_lang($sayfay->dil,"TX475");?></a></strong></h4>
</div>
<div class="list_carousel">
        <ul id="foo4">
        
    <?php
    while($row  = $sql->fetch(PDO::FETCH_OBJ)){

      $id     = $row->id;
      $row_lang = $db->query("SELECT t1.id,t1.url,t1.fiyat,t1.baslik,t1.resim,t1.il_id,t1.ilce_id,t1.emlak_durum,t1.pbirim,t1.emlak_tipi,t1.ilan_no FROM sayfalar AS t1 WHERE t1.site_id_555=999 AND t1.ilan_no=".$row->ilan_no." AND t1.dil='".$dil."' ");
      if($row_lang->rowCount()>0){
        $row = $row_lang->fetch(PDO::FETCH_OBJ);
        $row->id = $id;
      }


    $link   = ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
    if($row->fiyat != 0){
    $fiyat_int    = $gvn->para_int($row->fiyat);
    $fiyat      = $gvn->para_str($fiyat_int);
    }
    $sc_il        = $db->query("SELECT il_adi FROM il WHERE id=".$row->il_id)->fetch(PDO::FETCH_OBJ);
    $sc_ilce      = $db->query("SELECT ilce_adi FROM ilce WHERE id=".$row->ilce_id)->fetch(PDO::FETCH_OBJ);
    ?>
    <li>
    <a href="<?=$link;?>">
    <div class="kareilan">
   <span class="ilandurum" <?php echo ($row->emlak_durum == $emstlk) ? 'id="satilik"' : ''; echo ($row->emlak_durum == $emkrlk) ? 'id="kiralik"' : ''; ?>><?=$row->emlak_durum;?>
			/  <?=$row->emlak_tipi;?>
			</span>
    <img title="Sıcak Fırsat" alt="Sıcak Fırsat" src="<?=$linkcek; ?>/uploads/thumb/<?=$row->resim;?>" width="234" height="201">
    <div class="fiyatlokasyon" <? echo ($row->emlak_durum == $emkrlk) ? 'id="lokkiralik"' : ''; ?>>
    <? if($row->fiyat != '' OR $row->fiyat != 0){ ?><h3><?=$fiyat;?> <?=$row->pbirim;?></h3><? } ?> 
    <h4><?=$sc_il->il_adi;?> / <?=$sc_ilce->ilce_adi;?></h4>
    </div>
    <div class="kareilanbaslik">
    <h3><?=$fonk->kisalt($row->baslik,0,45);?><?=(strlen($row->baslik) > 45) ? '...' : '';?></h3>
    </div> 
    </div>
    </a>
    </li>
    <? } ?>
</div>
</div>
</div>
</div>
<div class="clear"></div>
<!-- Benzer İlanlar END-->
<? } ?>
<? include THEME_DIR."inc/footer.php"; ?>
<?php if(!defined("THEME_DIR")){die();}?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX649");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" />
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<?php include THEME_DIR."inc/head.php"; ?>

</head>
<body>

<? include THEME_DIR."inc/header.php"; ?>


<div class="headerbg" style="background-image: url(uploads/911da78222.jpg);">
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX649");?></h1>
<div class="sayfayolu">
<span><?=dil("TX650");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div class="clear"></div>

<div id="wrapper">
<div class="content" id="bigcontent">
<div class="clearmob" style="margin-top:20px;"></div>


<?php
$qry		= $pagent->sql_query("SELECT id,kid,adi,soyadi,avatar,avatard,nick_adi FROM hesaplar WHERE site_id_555=999 AND durum=0 AND turu=2 ORDER BY CASE WHEN onecikar_btarih>NOW() THEN 1 ELSE 2 END,id DESC",$gvn->rakam($_GET["git"]),12);
$query 		= $db->query($qry['sql']);

if($query->rowCount() > 0 ){
?>
<div class="list_carousel" id="anadanismanlar">
				<ul id="foo55">
<?php
while($row		= $query->fetch(PDO::FETCH_OBJ)){
$plink			= "profil/";
$plink			.= ($row->nick_adi == '') ? $row->id : $row->nick_adi;
$kid			= $row->kid;
$kurumsal		= $db->prepare("SELECT adi,soyadi,unvan FROM hesaplar WHERE site_id_555=999 AND id=?");
$kurumsal->execute(array($kid));
if($kurumsal->rowCount()>0){
$kurumsal		= $kurumsal->fetch(PDO::FETCH_OBJ);
$kurumsal		= ($kurumsal->unvan != '') ? $kurumsal->unvan : $kurumsal->adi." ".$kurumsal->soyadi;
}
$avatar			= ($row->avatar == '' OR $row->avatard==1) ? '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' : '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/'.$row->avatar;
?>
<li><a href="<?=$plink;?>">
<div class="anadanisman">
<div class="danismanfotoana" style="background-image: url(<?=$avatar;?>);"></div>
<div class="danismanbilgisi">
<h4><?=$row->adi." ".$row->soyadi;?></h4>
<?if($fonk->bosluk_kontrol($kurumsal)==false){?><h5><?=$kurumsal;?></h5><?}?>
</div>
</div></a></li>
<? } ?>


</ul>
</div>

<div class="clear"></div>
<div class="sayfalama">
<?php echo $pagent->listele('danismanlar?git=',$gvn->zrakam($_GET["git"]),$qry['basdan'],$qry['kadar'],'class="sayfalama-active"',$query); ?>
</div>


<? }else{ ?>
<h4 style="color:red"><?=dil("TX623");?></h4>
<? } ?>

</div>


<div class="clear"></div>
</div>


<? include THEME_DIR."inc/footer.php"; ?>
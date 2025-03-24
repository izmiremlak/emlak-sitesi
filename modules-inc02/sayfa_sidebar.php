<h2><i class="fa fa-bullhorn" aria-hidden="true"></i> <a href="haber-ve-duyurular"><?=dil("TX104");?></a></h2>
<div class="sidelinks">
<?php
$sqlx		= $db->query("SELECT * FROM sayfalar WHERE site_id_555=888 AND tipi=2 AND dil='".$dil."' ORDER BY id DESC LIMIT 0,5");
while($row	= $sqlx->fetch(PDO::FETCH_OBJ)){
$link		= ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
?>
<a href="<?=$link;?>"><i class="fa fa-caret-right" aria-hidden="true"></i><?=$row->baslik;?></a>
<? } ?>
</div>

<div class="clear"></div>

<h2><i class="fa fa-rss" aria-hidden="true"></i> <a href="yazilar"><?=dil("TX105");?></a></h2>
<div class="sidelinks">
<?php
$sqlx		= $db->query("SELECT * FROM sayfalar WHERE site_id_555=888 AND tipi=1 AND dil='tr' ORDER BY id DESC LIMIT 0,5");
while($row	= $sqlx->fetch(PDO::FETCH_OBJ)){
$link		= ($dayarlar->permalink == 'Evet') ? $row->url.'.html' : 'index.php?p=sayfa&id='.$row->id;
?>
<a href="<?=$link;?>"><i class="fa fa-caret-right" aria-hidden="true"></i><?=$row->baslik;?></a>
<? } ?>
</div>
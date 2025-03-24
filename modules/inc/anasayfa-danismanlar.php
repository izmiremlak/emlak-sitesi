<?php
$sql			= $db->query("SELECT id,kid,adi,soyadi,avatar,avatard,nick_adi FROM hesaplar WHERE site_id_555=888 AND durum=0 AND turu=2 AND onecikar=1 AND onecikar_btarih>NOW() ORDER BY RAND() LIMIT 0,12");
if($sql->rowCount()>0){
?><!-- Öne Çıkan Danışmanlar -->
<div id="wrapper">
<div class="content" id="bigcontent" style="margin-bottom:10px;margin-top:10px;">
<div class="altbaslik">
<div class="nextprevbtns">
<span id="slider-next"><a id="prev5" class="bx-prev" href="" style="display: inline;"><i id="prevnextbtn" class="fa fa-angle-left"></i></a></span>
<span id="slider-prev"><a id="next5" class="bx-next" href="" style="display: inline;"><i id="prevnextbtn" class="fa fa-angle-right"></i></a></span>
</div>
<h4 id="sicakfirsatlar"><strong><a href="danismanlar"><?=dil("TX477");?></a></strong></h4>
</div>

<div class="list_carousel" id="anadanismanlar">
				<ul id="foo5">
                

<?php
while($row		= $sql->fetch(PDO::FETCH_OBJ)){
$plink			= "profil/";
$plink			.= ($row->nick_adi == '') ? $row->id : $row->nick_adi;
$kid			= $row->kid;
$kurumsal		= $db->prepare("SELECT adi,soyadi,unvan FROM hesaplar WHERE site_id_555=888 AND id=?");
$kurumsal->execute(array($kid));
if($kurumsal->rowCount()>0){
$kurumsal		= $kurumsal->fetch(PDO::FETCH_OBJ);
$kurumsal_name  = ($kurumsal->unvan != '') ? $kurumsal->unvan : $kurumsal->adi." ".$kurumsal->soyadi;
}else{
	$kurumsal_name = "";
}
$avatar			= ($row->avatar == '' OR $row->avatard==1) ? 'https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' : 'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/'.$row->avatar;
?>
<li><a href="<?=$plink;?>">
<div class="anadanisman">
<div class="danismanfotoana" style="background-image: url(<?=$avatar;?>);"></div>
<div class="danismanbilgisi">
<h4><?=$row->adi." ".$row->soyadi;?></h4>
<?if($kurumsal_name != ''){?><h5><?=$kurumsal_name;?></h5><?}?>
</div>
</div></a>
</li>
<? } ?>


</div>
</div>
</div>
</div>
<div class="clear"></div>
<!-- Öne Çıkan Danışmanlar END --><?}?>
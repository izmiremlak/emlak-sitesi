<div class="danisman">
<h3 class="danismantitle"><?=($uyee->id == '' OR $uyee->turu==2 OR $uyee->turu==1) ? $fonk->get_lang($sayfay->dil,"TX155") : $fonk->get_lang($sayfay->dil,"TX154");?></h3>

<a href="<?=$profil_link;?>"><img src="https://www.turkiyeemlaksitesi.com.tr/<?=$davatar;?>" width="200" height="150"></a>

<h4><strong><a href="<?=$profil_link;?>"><?=$adsoyad;?></a></strong></h4>
<?php
if($adsoyad != $uyee->unvan):
?>
	<span>
		<?=$uyee->unvan;?>
	</span>
<?php endif;?>			

<div class="clear"></div>
	<div class="iletisim" style="display: flex; justify-content: space-evenly;"> 
	<a  target="_blank" href="https://api.whatsapp.com/send?phone=<?=rawurlencode($uyee->telefon);?>&text=<?=rawurlencode($link);?>%20<?=rawurlencode('Bu ilan hakkında bilgi almak istiyorum');?>" class="whatsappbtn gonderbtn" style="font-size:14px;padding: 5px 25px;margin-top: 15px;float:none;display: inline-block;"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
	<a  target="_blank" href="https://t.me/share/url?url=<?=rawurlencode($link);?>&text=<?=rawurlencode($sayfay->baslik);?>" class="telegrambtn gonderbtn" style="font-size:14px;padding: 5px 25px;margin-top: 15px;float:none;display: inline-block;"><i class="fa fa-telegram" aria-hidden="true"></i></a>
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
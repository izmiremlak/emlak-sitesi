<?php

if($gayarlar->anlik_sohbet==0){
header("Location:hesabim");
die();
}

$uturu	= explode(",",dil("UYELIK_TURLERI"));
$bid	= $hesap->id;
$uid	= $gvn->zrakam($_GET["uid"]);

include "methods/chat.lib.php";

?><div class="headerbg" <?=($gayarlar->belgeler_resim  != '') ? 'style="background-image: url(uploads/'.$gayarlar->belgeler_resim.');"' : ''; ?>>
<div id="wrapper">
<div class="headtitle">
<h1><?=dil("TX426");?></h1>
<div class="sayfayolu">
<span><?=dil("TX427");?></span>
</div>
</div>

</div>
<div class="headerwhite"></div>
</div>

<div id="wrapper">
<div class="clear"></div>
<div class="uyepanel">
<div class="sidebar" id="msjkisiler">
<i class="fa fa-search" aria-hidden="true" id="msjaraicon"></i>
<input name="msjara" type="text" id="AramaKutusu" placeholder="<?=dil("TX400");?>" value="">


<div id="ContactMessagesBox" class="showscroll">

<div id="ContactList"></div>

</div><!-- sol tarafa scroll için bir div end -->


</div>

<div class="content" id="uyemesajlari">

<div class="uyedetay">
<div class="mesajlasmalar">


<!-- DEFAULT AÇILIŞ -->
<div id="default_acilis" <?=($uid!=0) ? 'style="display:none"' : '';?>>
<?=dil("TX397");?>
</div>
<!-- DEFAULT AÇILIŞ -->

<!-- MesajlasmaContent Start -->
<div id="MesajlasmaContent" <?=($uid == 0) ? 'style="display:none"' : '';?>>

<div class="uyemsjprofili">
<img src="<?=$uyavatar;?>" id="UyeAvatar" width="100" height="100" alt="">
<h4><strong id="UyeAdiSoyadi"><?=$uyadsoyad;?></strong><br><span id="UyeTuru">(<?=$uyturu;?> <?=dil("TX384");?>)</span></h4>

<a href="<?=$uyeProLink;?>" id="UyeProLink" class="gonderbtn"><i class="fa fa-eye" aria-hidden="true"></i> <?=dil("TX401");?></a>


<a href="javascript:;" class="gonderbtn" id="EngelButon" onclick="EngelDurum();" <?=($KarsiEngel == 1) ? 'style="display:none"' : '';?>><i class="fa fa-ban" aria-hidden="true"></i> <?=($BenEngel==1) ? dil("TX402") : dil("TX403");?></a>
<a href="javascript:;" class="gonderbtn" id="GorusmeSilButon" onclick="GorusmeyiSil();" <?=($isileti==0) ? 'style="display:none"' : '';?>><i class="fa fa-trash"></i> <?=dil("TX404");?></a>
</div>

<div id="MessageBox" class="showscroll">

<div id="MessagesList"></div>

<div id="scrollbottom"></div>
</div>


<div class="uyemsjarea" id="MesajlasAlani" <?=($KarsiEngel==1 || $BenEngel==1) ? 'style="display:none"' : ''; ?>>
<form action="ajax.php?p=mesaj_gonder&uid=<?=$uid;?>" method="POST" id="MesajGonderForm">
<textarea  rows="3" name="mesaj" id="MesajYaz"></textarea>
<a href="javascript:;" onclick="AjaxFormS('MesajGonderForm','MesajGonderSonuc');" style="float:right;" class="gonderbtn"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?=dil("TX405");?></a>
<div id="MesajGonderSonuc" style="display:none"></div>
</form>
</div>

<div id="MesajEngeli" <?=($KarsiEngel==1 || $BenEngel==1) ? 'style="display:block"' : 'style="display:none"'; ?>><?=dil("TX406");?></div>

<style>
#MesajEngeli {    text-align: center;
    margin-top: 35px;
    font-weight: bold;}
</style>

</div><!-- MesajlasmaContent End -->


<!-- sağ mesajlaşma tarafı end -->
</div>
</div>

</div>
<div class="clear"></div>
</div>
</div>
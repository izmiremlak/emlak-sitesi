<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+905541229945", // WhatsApp numarası
            call_to_action: "", // Görüntülenecek yazı
            position: "left", // Sağ taraf için 'right' sol taraf için 'left'
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>

<style>
    a.gflag {
        vertical-align: middle;
        font-size: 24px;
        float: left;
        margin-top: 3px;
        background-repeat: no-repeat;
        background-image: url(https://www.izmiremlakbirligi.com.tr/uploads/images/24.png);
        padding: 0px !important;
    }
</style>
<div class="langs-bar" style="display: flex; justify-content: start; flex-wrap: wrap; gap: 5px;background-color: #185aa3; padding: 5px;" >
    <a href="/#" onclick="doGTranslate('tr/tr');return false;" title="Türkçe" class="gflag nturl" style="background-position:  -100px -500px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Türkçe">
    </a> 
    <a href="/#" onclick="doGTranslate('tr|en');return false;" title="English" class="gflag nturl" style="background-position: -0px -0px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="English">
    </a>
    <a href="/#" onclick="doGTranslate('tr|de');return false;" title="German" class="gflag nturl" style="background-position: -300px -100px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="German">
    </a>
    <a href="/#" onclick="doGTranslate('tr|fr');return false;" title="French" class="gflag nturl" style="background-position: -200px -100px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="French">
    </a>
    <a href="/#" onclick="doGTranslate('tr|ar');return false;" title="Arabic" class="gflag nturl" style="background-position: -100px -0px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Arabic">
    </a>
    <a href="/#" onclick="doGTranslate('tr|bg');return false;" title="Bulgarian" class="gflag nturl" style="background-position: -200px -0px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Bulgarian">
    </a>
    <a href="/#" onclick="doGTranslate('tr|zh-CN');return false;" title="Chinese (Simplified)" class="gflag nturl" style="background-position: -300px -0px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Chinese (Simplified)">
    </a>
    <a href="/#" onclick="doGTranslate('tr|el');return false;" title="Greek" class="gflag nturl" style="background-position: -400px -100px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Greek">
    </a>
    <a href="/#" onclick="doGTranslate('tr|it');return false;" title="Italian" class="gflag nturl" style="background-position: -600px -100px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Italian">
    </a>
    <a href="/#" onclick="doGTranslate('tr|ru');return false;" title="Russian" class="gflag nturl" style="background-position: -500px -200px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Russian">
    </a>
    <a href="/#" onclick="doGTranslate('tr|es');return false;" title="Spanish" class="gflag nturl" style="background-position: -600px -200px;">
        <img src="/uploads/images/blank.png" height="24" width="24" alt="Spanish">
    </a>
</div>

<div class="header" style="top: auto;">
    <div id="google_translate_element2" style="display: none;"> </div>

<script type="text/javascript">
    function googleTranslateElementInit2() { 
        new google.translate.TranslateElement({ 
            pageLanguage: 'tr', 
            autoDisplay: false 
        }, 'google_translate_element2'); 
    }
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Güvenli bir şekilde eval fonksiyonunu kullanmaktan kaçınıyoruz
        const doGTranslate = (a) => {
            const googleTranslateElement = document.getElementById('google_translate_element2');
            if (a.value) a = a.value;
            if (a === '') return;
            const b = a.split('|')[1];
            let selectElem = null;
            const selects = document.getElementsByTagName('select');
            for (let i = 0; i < selects.length; i++) {
                if (selects[i].className.includes('goog-te-combo')) {
                    selectElem = selects[i];
                    break;
                }
            }
            if (document.getElementById('google_translate_element2') === null || selectElem === null || selectElem.length === 0 || selectElem.className.length === 0) {
                setTimeout(() => { doGTranslate(a); }, 500);
            } else {
                selectElem.value = b;
                fireEvent(selectElem, 'change');
                fireEvent(selectElem, 'change');
            }
        };

        const fireEvent = (element, event) => {
            if (document.createEvent) {
                const evt = document.createEvent('HTMLEvents');
                evt.initEvent(event, true, true);
                element.dispatchEvent(evt);
            } else {
                const evt = document.createEventObject();
                element.fireEvent('on' + event, evt);
            }
        };
    });
</script>
	
<div id="wrapper">

<? if($hesap->id == ""){ ?>
<a class="gonderbtn" id="ilanverbtn" href="admin/turkiyeTR.php"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=dil("TX356");?></a> 
<?if($gayarlar->uyelik == 1){?><a class="gonderbtn" id="ilanverbtn" href="hesap-olustur"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=dil("TX125");?></a><?}?>
<? }else{ ?>
<a class="gonderbtn" id="ilanverbtn" href="logout.php"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=dil("TX112");?></a>
<a class="gonderbtn" id="ilanverbtn" href="uye-paneli"><span style="    margin-left: -29px;    position: absolute;    margin-top: -15px;display:none" class="msjvar mbildirim">0</span><i class="fa fa-user" aria-hidden="true"></i> <?=dil("TX90");?></a>
<? } ?>


<? if($dayarlar->facebook != '' OR $dayarlar->instagram != '' OR $dayarlar->twitter != ''){ ?>
<div class="headsosyal">
<? if($dayarlar->facebook != ''){ ?><a target="_blank" href="<?=$dayarlar->facebook;?>"><i class="fa fa-facebook" aria-hidden="true"></i></a><? } ?>
<? if($dayarlar->twitter != ''){ ?><a target="_blank" href="<?=$dayarlar->twitter;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a><? } ?>
<? if($dayarlar->instagram != ''){ ?><a target="_blank" href="<?=$dayarlar->instagram;?>"><i class="fa fa-instagram" aria-hidden="true"></i></a><? } ?>
</div>
<? } ?>

<?php
$diller		= $db->query("SELECT kisa_adi,gosterim_adi FROM diller_19541956 WHERE durum=0 ORDER BY sira ASC");
$dilcnt = $diller->rowCount();
if($dilcnt > 1 ){
?>
<div class="languages" >
<?php

//$ahrefd = $_SERVER["REQUEST_URI"];
//$ahrefd .= (stristr($ahrefd,"?")) ? "&" : "?";
$ahrefd	= "index.php?";

$di 	= 0;
while($row		= $diller->fetch(PDO::FETCH_OBJ)){
$di 	+=1;
?>
<a href="<?=$ahrefd;?>dil=<?=$row->kisa_adi;?>"><?=($row->kisa_adi == $dil) ? '<strong>'.$row->gosterim_adi.'</strong>' : $row->gosterim_adi; ?></a> <?=($di != $dilcnt) ? ' / ' : '';?>
<?
}
?>
</div>
<? } ?>

<?if($dayarlar->telefon != ''){?>
<div class="headinfo">
<h3><?=dil("TX91");?> / <strong><a href="tel:<?=$dayarlar->telefon;?>"><?=$dayarlar->telefon;?></a></strong></h3>
</div>
<?}?>

</div>

<div class="clear"></div>

<div class="moblogo">
<a href="index.html"><img src="uploads/thumb/<?=$gayarlar->logo;?>" title="logo" alt="logo" width="auto" height="80">
</div>

<style>

</style>

<div class="menu" >
<div id="wrapper"> <a href="index.html"><img title="logo" alt="logo" src="uploads/thumb/<?=$gayarlar->logo;?>" width="auto" height="80" class="logo"></a>
<div class="menuAc">≡ MENU</div>
<? $fonk->menu_listesi();?>
</div>
</div>

<? if($p == '' AND $gayarlar->urun_siparis == 1){ ?>

<div class="homearama">
<div id="wrapper">
<h3 class="animated fadeInDown"><?=dil("TX92");?></h3>
<h4  class="animated fadeInUp"><?=dil("TX93");?></h4>

<div class="homearamaselect">
<form action="ajax.php?p=ilanlar" method="POST" id="IlanlarAramaFormHeader">
<?php
$emlkdrm	= dil("EMLK_DRM");
if($emlkdrm != ''){
?>
<select name="emlak_durum" id="leftradius">
<option value=""><?=dil("TX94");?></option>
<?php
$parc		= explode("<+>",$emlkdrm);
foreach($parc as $val){
?><option <?=($val == $emlak_durum) ? 'selected' : '';?>><?=$val;?></option><?
}
?>
</select>
<? } ?>

<?php
$emlktp		= dil("EMLK_TIPI");
if($emlktp != ''){
?>
<select name="emlak_tipi">
        <option value=""><?=dil("TX95");?></option>
		<?php
		$parc		= explode("<+>",$emlktp);
		foreach($parc as $val){
		?><option <?=($val == $emlak_tipi) ? 'selected' : '';?>><?=$val;?></option><?
		}
		?>
</select>
<? } ?>


<?php
$ulkeler	= $db->query("SELECT * FROM ulkeler_19541956 ORDER BY id ASC");
$ulkelerc	= $ulkeler->rowCount();
if($ulkelerc>1){
?>
<select name="ulke_id" onchange="ajaxHere('ajax.php?p=il_getir&ulke_id='+this.options[this.selectedIndex].value,'hdil');">
        <option value=""><?=dil("TX348");?></option>
        <?php
		while($row	= $ulkeler->fetch(PDO::FETCH_OBJ)){
		?><option value="<?=$row->id;?>"><?=$row->ulke_adi;?></option><?
		}
		?>
</select>
<?}?>


<select name="il" id="hdil" onchange="ajaxHere('ajax.php?p=ilce_getir&varsa=1&il_id='+this.options[this.selectedIndex].value,'hdilce');">
        <option value=""><?=dil("TX96");?></option>
        <?php
		if($ulkelerc<2){
		$ulke		= $ulkeler->fetch(PDO::FETCH_OBJ);
		$sql		= $db->query("SELECT id,il_adi FROM il WHERE ulke_id=".$ulke->id." ORDER BY id ASC");
		while($row	= $sql->fetch(PDO::FETCH_OBJ)){
		?><option value="<?=$row->id;?>" <?=($row->id == $il) ? 'selected' : '';?>><?=$row->il_adi;?></option><?
		}
		}
		?>
</select>


<select name="ilce" id="hdilce">
        <option value=""><?=dil("TX97");?></option>
</select>

<a href="javascript:AjaxFormS('IlanlarAramaFormHeader','IlanlarAramaFormHeader_sonuc');" class="homearabtn"><i class="fa fa-search" aria-hidden="true"></i> <?=dil("TX98");?></a>
</form>
<div id="IlanlarAramaFormHeader_sonuc" style="display:none"></div>

<div class="clearmob"></div>
</div>

</div>
</div>
<? } ?>
</div>
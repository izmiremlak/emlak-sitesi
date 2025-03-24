<?php if(!defined("THEME_DIR")){die();} if($hesap->id != ''){
header("Location:uye-paneli");
die();
}

if($gayarlar->uyelik == 0){
header("Location:giris-yap");
die();
}

?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX125");?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?=$dayarlar->keywords;?>" />
<meta name="description" content="<?=$dayarlar->description;?>" /> 
<meta name="robots" content="All" />  
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<? include THEME_DIR."inc/head.php"; ?>

<script>
var vid = document.getElementById("bgvid");
var pauseButton = document.querySelector("#polina button");

if (window.matchMedia('(prefers-reduced-motion)').matches) {
    vid.removeAttribute("autoplay");
    vid.pause();
    pauseButton.innerHTML = "Paused";
}

function vidFade() {
  vid.classList.add("stopfade");
}

vid.addEventListener('ended', function()
{
// only functional if "loop" is removed 
vid.pause();
// to capture IE10
vidFade();
}); 


pauseButton.addEventListener("click", function() {
  vid.classList.toggle("stopfade");
  if (vid.paused) {
    vid.play();
    pauseButton.innerHTML = "Pause";
  } else {
    vid.pause();
    pauseButton.innerHTML = "Paused";
  }
})
</script>
</head>
<body id="uyegirispage">

<video poster="modules/images/uyeolgirisbg.jpg" id="bgvid" playsinline autoplay muted loop>
<source src="modules/images/uyeolgirisbg.mp4" type="video/mp4">
</video>

<div id="wrapper">

<div class="uyeolgirislogo">

 <a href="index.html"><img title="logo" alt="logo" src="uploads/thumb/<?=$gayarlar->footer_logo;?>" width="auto" height="80" class=""></a>
 <h1><?=dil("TX125");?></h1>
</div>

<div class="uyeolgirisyap">

<div class="uyeolgirisslogan"><h4><?=dil("TX358");?></strong></h4><br><br>
<a href="girisyap" class="gonderbtn"><?=dil("TX359");?></a>
</div>


<div class="uyeol">
<div style="padding:20px;">
<form action="ajax.php?p=kaydol" method="POST" id="KaydolForm">

<style>

</style>

<!-- SMS ONAY -->
<div id="Gonay" style="display:none;">
<table width="100%" border="0">
  <tr>
    <td align="center" style="border:none;" >
    <h3><strong><?=dil('TX378');?></strong></h3><br>
    <h4 style="font-size: 18px;    font-weight: 100;"><?=dil('TX379');?></h4><br>
    <input name="scode" type="text" value="" style="width:208px;margin-bottom:25px;padding:11px;" placeholder="<?=dil('TX383');?>">
    <br>
    <a href="javascript:;" onClick="AjaxFormS('KaydolForm','Gonay_snc');" class="mobilonaybtn"><i style="margin-right:5px;" class="fa fa-check"></i> <?=dil('TX380');?></a>
    <div class="clear"></div><br>
	<div id="Gonay_snc" style="display:none"></div>
    <br>
    <a href="iletisim" target="_blank"><i class="fa fa-caret-right" aria-hidden="true"></i> <?=dil('TX381');?></a> <br><br>
    <strong><a href="javascript:;" onclick="GeriDon();"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?=dil('TX382');?></a> </strong>
	</td>
    </tr>
</table>
</div>
<!-- SMS ONAY -->


<!-- Uyelik start -->
<div id="uyelik">
<table width="100%" border="0">
  <tr>
    <td colspan="2"><h4><i class="fa fa-user-plus" aria-hidden="true"></i> <strong><?=dil("TX125");?></strong></h4></td>
  </tr>
  
  <tr>
    <td colspan="2" height="50">
    <span style="margin-right:20px;font-weight:bold;margin-bottom:7px;float:left;"><?=dil("TX350");?></span>

    <input id="turu_0" class="radio-custom" name="turu" value="0" type="radio" style="width:25px;">
    <label for="turu_0" class="radio-custom-label" style="margin-right: 28px;" ><span class="checktext"><?=dil("TX351");?></span></label>
		
    <input id="turu_1" class="radio-custom" name="turu" value="1" type="radio" style="width:25px;">
    <label for="turu_1" class="radio-custom-label"style="margin-right: 28px;" ><span class="checktext"><?=dil("TX352");?></span></label>
    <!-- 
    <input id="turu_2" class="radio-custom" name="turu" value="2" type="radio" style="width:25px;">
    <label for="turu_2" class="radio-custom-label"style="margin-right: 28px;" ><span class="checktext"><?=dil("TX357");?></span></label>
     -->
	</td>
  </tr>
  
  <tr>
    <td><?=dil("TX126");?></td>
    <td><input name="adsoyad" type="text"></td>
  </tr>
  <tr>
    <td><?=dil("TX127");?></td>
    <td><input name="email" type="text"></td>
  </tr>
  
  <tr>
    <td><?=dil("TX128");?></td>
    <td><input name="telefon" type="text" id="gsm" placeholder="<?=($gayarlar->sms_aktivasyon==1) ? dil("TX373") : '';?>"></td>
  </tr>
  
  <?if($gayarlar->tcnod==1){?>
  <tr class="turu_0">
    <td><?=dil("TX364");?></td>
    <td><input name="tcno" type="text" id="tcno" maxlength="11" placeholder=""></td>
  </tr>
  <?}?>
  
  <tr class="turu_1" style="display:none">
    <td><?=dil("TX366");?></td>
    <td><input name="unvan" type="text" id="unvan" placeholder=""></td>
  
  <tr class="turu_1" style="display:none">
    <td><?=dil("TX367");?></td>
    <td><input name="vergi_no" type="text" id="vergi_no" placeholder=""></td>
  </tr>
  
  <tr class="turu_1" style="display:none">
    <td><?=dil("TX368");?></td>
    <td><input name="vergi_dairesi" type="text" id="vergi_dairesi" placeholder=""></td>
  </tr>
  
	
  <?if($gayarlar->adresd==1){?>
  <tr>
    <td><?=dil("TX365");?></td>
    <td><input name="adres" type="text" id="adres" placeholder=""></td>
  </tr>
  <?}?>
  
  
     <tr>
    <td><?=dil("TX129");?></td>
    <td><input name="parola" type="password"></td>
    </tr>
    <tr>
    <td><?=dil("TX130");?></td>
    <td><input name="parola_tekrar" type="password"></td>
    </tr>
     <tr>
       <td colspan="2">
       <input id="checkbox-5" class="checkbox-custom" name="sozlesme" value="1" type="checkbox"  style="width:100px;">
	   <label for="checkbox-5" class="checkbox-custom-label"><span class="checktext"><a target="_blank" href="<?=dil("TX131HF");?>"><?=dil("TX131");?></a></span></label>
       </td>
     </tr>
 <tr>
    <td style="border:none" colspan="2">
    <div class="clear" style="margin-bottom: 15px;"></div>
	<center>
	<!--a href="javascript:;" style="float:none;" onclick="AjaxFormS('KaydolForm','KaydolForm_Snc');" class="btn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=dil("TX132");?></a-->
    <button type="button" style="float:none;" onclick="AjaxFormS('KaydolForm','KaydolForm_Snc');" class="btn"><i class="fa fa-user-plus" aria-hidden="true"></i> <?=dil("TX132");?></button>
	<div class="clear"></div>
	<div id="KaydolForm_Snc" align="center" style="display:none;font-weight:bold;"></div>
    </center>
	
	
	</td>
  </tr>
  </table>
</div>
<!-- UYELIK END -->


</form>
<div id="TamamPnc" style="display:none">
<!-- TAMAM MESAJ -->
<div style="margin-top:30px;margin-bottom:70px;text-align:center;" id="BasvrTamam">
<i style="font-size:80px;color:green;" class="fa fa-check"></i>
<h4 style="color:green;font-weight:bold;"><?=dil("TX133");?></h4>
<br/>
<h5><?=dil("TX134");?></h5>
</div>
<!-- TAMAM MESAJ -->
</div>


<script type="text/javascript">
function GeriDon(){
$("#KaydolForm").attr("action","ajax.php?p=kaydol");
$("#Gonay").slideUp(500,function(){
$("#uyelik").slideDown(500);
});
}

$(document).ready(function(){
$(".turu_1").fadeOut(250);

$("input[name='turu']").change(function(){
var turu = $(this).val();
if(turu == 0 || turu == 2){
$(".turu_1").fadeOut(250);
$(".turu_0").fadeIn(250);
}else if(turu == 1){
$(".turu_1").fadeIn(250);
$(".turu_0").fadeOut(250);
}

});
});
</script>

</div>
</div>
</div>

</div>

<? include THEME_DIR."inc/footer.php"; ?>
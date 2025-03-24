<?php if(!defined("THEME_DIR")){die();} if($hesap->id != ''){
header("Location:uye-paneli");
}


$referer		= $gvn->html_temizle($_SERVER["HTTP_REFERER"]);
$referer		= ($referer == '') ? ORGIN_URL.ltrim($gvn->html_temizle($_SERVER["REQUEST_URI"]),"/") : $referer;
if(stristr($referer,$domain) AND $referer != ''){
setcookie("login_redirect",$referer,time()+60*60);
}
?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?=dil("TX356");?></title>
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
 <h1><?=dil("TX3562");?></h1>
</div>

<div class="uyeolgirisyap">

<div class="uyeolgirisslogan"><h4><?=dil("TX360");?><?=($gayarlar->uyelik==1) ? dil("TX651") : '';?></h4>

<?if($gayarlar->uyelik==1){?><br><br>
<a href="hesap-olustur" class="gonderbtn"><?=dil("TX361");?></a><?}?>
</div>


<div class="uyeol" style="margin-top:50px;margin-bottom:50px;">
<div style="padding:20px;">
<script type="text/javascript">
$(document).ready(function() {
        $("#GirisForm").bind("keypress", function(e) {
            if (e.keyCode == 13) {
            $("#GirisForm .btn").click();
            }
        });
    });
</script>
<form action="ajax.php?p=giris" method="POST" id="GirisForm">
<table width="100%" border="0">
  <tr>
    <td colspan="2"><h4><i class="fa fa-sign-in" aria-hidden="true"></i> <strong><?=dil("TX114");?></strong></h4></td>
  </tr>
  <tr>
    <td><?=dil("TX116");?></td>
    <td><input name="email" type="text"></td>
    </tr>
     <tr>
    <td><?=dil("TX117");?></td>
    <td><input name="parola" type="password"></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
       <td>
       <input id="checkbox-4" class="checkbox-custom" name="otut" value="1" type="checkbox" checked="" style="width:100px;">
	   <label for="checkbox-4" class="checkbox-custom-label"><span class="checktext"><?=dil("TX118");?></span></label>
       <a class="sifreunuttulink" href="javascript:;" onclick="sifre_unuttu();"><?=dil("TX119");?></a>
       </td>
     </tr>
 <tr>
    <td style="border:none" colspan="2">
	
	<div style="  width: 55%;  font-size: 14px;    float: left;" id="GirisForm_Snc" style="display:none"></div>
	
    <button type="button" onclick="AjaxFormS('GirisForm','GirisForm_Snc');" class="btn"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=dil("TX120");?></button>
	
	</td>
  </tr>
  </table>
  </form>

<script type="text/javascript">
$(document).ready(function() {
        $("#SifreUnuttum").bind("keypress", function(e) {
            if (e.keyCode == 13) {
            $("#SifreUnuttum .btn").click();
            }
        });
    });
</script>
<form action="ajax.php?p=sfunuttum" method="POST" id="SifreUnuttum" style="display:none">
<table width="100%" border="0">
  <tr>
    <td colspan="2"><h4><i class="fa fa-sign-in" aria-hidden="true"></i> <strong><?=dil("TX122");?></strong></h4></td>
  </tr>
  <tr>
    <td><?=dil("TX116");?></td>
    <td><input name="email" type="text"></td>
    </tr>
     <tr>
       <td>&nbsp;</td>
       <td>
       <a class="sifreunuttulink" href="javascript:;" onclick="giris_yap();"><?=dil("TX123");?></a>
       </td>
     </tr>
 <tr>
    <td style="border:none" colspan="2">
	
	<div id="SifreUnuttum_Snc" style=" width: 55%;  font-size: 14px;    float: left;display:none"></div>
	
	<button type="button" onclick="AjaxFormS('SifreUnuttum','SifreUnuttum_Snc');" class="btn"><i class="fa fa-sign-in" aria-hidden="true"></i> <?=dil("TX124");?></a>
	
	</td>
  </tr>
  </table>
</form>

<script type="text/javascript">
function sifre_unuttu(){
$('#GirisForm').slideUp(500,function(){
$('#SifreUnuttum').slideDown(500);
});
}

function giris_yap(){
$('#SifreUnuttum').slideUp(500,function(){
$('#GirisForm').slideDown(500);
});
}
</script>
</div>
</div>
</div>

</div>

<? include THEME_DIR."inc/footer.php"; ?>
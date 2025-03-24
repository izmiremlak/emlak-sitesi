<? if($dayarlar->verification != ''){ echo $dayarlar->verification; } ?>

<link rel="canonical" href="<?=REQUEST_URL;?>" />
<!-- Css -->
<link rel="stylesheet" type='text/css' href="<?=THEME_DIR;?>css/stylex.css"/>
<link rel="stylesheet" type="text/css" href="<?=THEME_DIR;?>css/extralayers.css" media="none" onload="if(media!='all')media='all'"/>	
<link rel="stylesheet" type="text/css" href="<?=THEME_DIR;?>rs-plugin/css/settings.css" media="none" onload="if(media!='all')media='all'"/>
<link rel="stylesheet" type='text/css' href="<?=THEME_DIR;?>css/font-awesome.min.css" media="none" onload="if(media!='all')media='all'"/>
<link rel="stylesheet" type='text/css' href="<?=THEME_DIR;?>css/ionicons.min.css" media="none" onload="if(media!='all')media='all'"/>
<link rel="stylesheet" type='text/css' href="<?=THEME_DIR;?>css/animate.css" media="none" onload="if(media!='all')media='all'"/>
<link rel='stylesheet' type='text/css' href="<?=THEME_DIR;?>css/prettyPhoto.css" media="none" onload="if(media!='all')media='all'">


<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' media="none" onload="if(media!='all')media='all'">

<link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,400,700&amp;subset=latin-ext" rel="stylesheet" media="none" onload="if(media!='all')media='all'">

<!-- Css -->

<? if(($p == 'sayfa' AND $sayfay->tipi == 4) || ($p == 'sayfa' AND $sayfay->tipi == 5)){ ?>
<link href="<?=THEME_DIR;?>lightgallery/css/lightgallery.css" rel="stylesheet">
<link href="<?=THEME_DIR;?>lightslider/css/lightslider.css" rel="stylesheet" />
<? }elseif($p == 'uye_paneli' && ($_GET["rd"] == 'ilan_duzenle' || $_GET["rd"] == 'ilan_olustur')){ ?>
<link rel="stylesheet" href="<?=THEME_DIR;?>nestable/css/components/nestable.almost-flat.min.css" />
<link rel="stylesheet" href="<?=THEME_DIR;?>nestable/css/components/nestable.min.css" />
<link rel="stylesheet" href="<?=THEME_DIR;?>nestable/css/components/nestable.gradient.min.css" />
<? } ?>

<style type="text/css">div.hbcne{position:fixed;z-index:4000;}div.hgchd{top:0px;left:0px;} div.hbcne{_position:absolute;}div.hgchd{_bottom:auto;_top:expression(ie6=(document.documentElement.scrollTop+document.documentElement.clientHeight – 52+"px") );}</style><div id="izmirtr" style="background-color:#ffffff;width:100%;height:100%;padding-top:20%;" class="hbcne hgchd">
<center><a style="font-family:Arial;font-size:19px;color:#ff0000;"></a><br/><br/>
<img style="padding:0px;margin:0px;background-color:transparent;border:none;" src="<?=THEME_DIR;?>images/loading.gif" alt="Loading..." title="yükleniyor" width="auto" height="auto"/></center></div>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {setTimeout('document.getElementById("izmirtr").style.display="none"', 100);});
</script>

<!--
<script>(function(){"use strict";var c=[],f={},a,e,d,b;if(!window.jQuery){a=function(g){c.push(g)};f.ready=function(g){a(g)};e=window.jQuery=window.$=function(g){if(typeof g=="function"){a(g)}return f};window.checkJQ=function(){if(!d()){b=setTimeout(checkJQ,100)}};b=setTimeout(checkJQ,100);d=function(){if(window.jQuery!==e){clearTimeout(b);var g=c.shift();while(g){jQuery(g);g=c.shift()}b=f=a=e=d=window.checkJQ=null;return true}return false}}})();</script>
-->
<script src="<?=THEME_DIR;?>js/jquery-2.2.4.min.js"></script>
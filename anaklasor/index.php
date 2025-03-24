<?php include "functions.php";

istatistik_fonksiyonu();


if(!stristr($_SERVER["SERVER_NAME"],"www.") AND $gayarlar->site_www==1){
header('Location: http://www.'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
}
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' AND $gayarlar->site_ssl==1){
header('Location: https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
}


$tp		= $gvn->harf_rakam($_GET["p"]);
$p 		= $tp;
$pdir	= THEME_DIR;

if(empty($tp)){
include $pdir.'index.php';
}elseif(file_exists($pdir.$tp.'.php')){
include $pdir.$tp.'.php';
}else{
include "404.php";
}

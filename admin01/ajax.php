<?php include "../functions.php";

$p		= $gvn->harf_rakam($_GET["p"]);
$pdir	= 'ajax/'.$p.'.php';

if($p != 'login' AND $p != 'forget_password' AND $hesap->tipi == 0){
die($fonk->ajax_hata("Hata!"));
}

if($p != 'login' AND $p != 'forget_password' AND $p != 'ilce_getir' AND $p != 'ilce_getir_string' AND $hesap->tipi == 2){
die($fonk->ajax_hata("Demo versiyonda işlem yapamazsınız."));
}

if($_FILES){
foreach($_FILES as $key => $value){
$fi     = $value;
$uzanti = $fonk->uzanti($fi["name"]);
$exs    = array(".php",".html",".htaccess",".ini",".conf");
if(in_array($uzanti,$exs)){
$fonk->ajax_hata("Bu dosya sitenize zarar verebildiği için yüklenemedi.",4000);
die();
}
}
}


if(file_exists($pdir)){
require $pdir;
}else{
echo 'File Not Found';
}

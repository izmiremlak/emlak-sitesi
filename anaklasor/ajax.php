<?php include "functions.php";

$p		= $gvn->harf_rakam($_GET["p"]);
$pdir	= THEME_DIR.'ajax/'.$p.'.php';

$stadrs	= $_SERVER["SERVER_NAME"];
if(strstr($stadrs,"izmirtr.com")){
if($p == 'giris' OR $p == 'sube_bayi_getir' OR $p == 'ilce_getir' OR $p == 'il_getir' OR $p == 'mahalle_getir' OR $p == 'ilanlar' OR $p == 'ilanlar2' OR $p == 'mesajlar_bildirim' OR $p == 'mesajlar_kisiler' OR (($p == 'rotate' || $p == 'ilan_galeri_resim_yukle') && $hesap->tipi == 1)){ 
}else{
die('<span class="error">Demo versiyonda işlem yapamazsınız.</span>');
}
}


if(file_exists($pdir)){
require $pdir;
}else{
echo 'File Not Found ';
}
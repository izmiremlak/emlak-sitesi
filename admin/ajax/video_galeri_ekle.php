<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$kategori_id= $gvn->zrakam($_POST["kategori_id"]);
$youtube	= $gvn->html_temizle($_POST["youtube"]);
$kesyou 	= substr($youtube,32,100);
$resim 		= 'http://i1.ytimg.com/vi/'.$kesyou.'/hqdefault.jpg';

if($fonk->bosluk_kontrol($baslik) == true OR $fonk->bosluk_kontrol($youtube) == true ){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


$ekle			= $db->prepare("INSERT INTO video_galeri SET sira=?,baslik=?,youtube=?,resim=?,dil=?,kategori_id=? ");
$ekle->execute(array($sira,$baslik,$youtube,$resim,$dil,$kategori_id));

if($ekle){
$fonk->ajax_tamam("Video Galeri Eklendi.");
$fonk->yonlendir("index.php?p=video_galeri",3000);
}


}
} 
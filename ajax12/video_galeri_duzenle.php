<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM video_galeri WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$kategori_id= $gvn->zrakam($_POST["kategori_id"]);
$youtube	= $gvn->html_temizle($_POST["youtube"]);
$kesyou 	= substr($youtube,32,100);
$resim 		= 'http://i1.ytimg.com/vi/'.$kesyou.'/hqdefault.jpg';



if($fonk->bosluk_kontrol($baslik) == true OR $fonk->bosluk_kontrol($youtube) == true ){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}


if($youtube != $snc->youtube){
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","<?=$resim;?>");
});
</script><?
}


$updt			= $db->prepare("UPDATE sira=?,baslik=?,youtube=?,resim=?,kategori_id=? WHERE id=".$snc->id);
$updt->execute(array($sira,$baslik,$youtube,$resim,$kategori_id));

if($updt){ 
$fonk->ajax_tamam("Video Galeri Güncellendi.");
}


}
}
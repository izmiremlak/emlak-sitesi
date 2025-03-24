<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM diller_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
$dili		= $snc->kisa_adi;
}else{
die();
}

$baska_dil	= $db->query("SELECT id,kisa_adi FROM diller_19541956 WHERE id!=".$id);
if($baska_dil->rowCount()<1){
die($fonk->ajax_hata("Sileceğiniz dil dışında başka dil olmadığından dil silinemez!"));
}
$baska_dili = $baska_dil->fetch(PDO::FETCH_OBJ)->kisa_adi;


try{$db->query("DELETE FROM ayarlar_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM galeri_foto WHERE site_id_555=999 AND dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM kategoriler_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM mail_sablonlar_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM menuler_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM referanslar_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM sayfalar WHERE site_id_555=888 AND dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM slider_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM subeler_bayiler_19541956  WHERE dil='".$dili."'");}catch(PDOException $e){}
try{$db->query("DELETE FROM sehirler_19541956 WHERE dil='".$dili."'");}catch(PDOException $e){}


$db->query("DELETE FROM diller_19541956 WHERE id=".$id);
unlink("../".THEME_DIR."diller/".$snc->kisa_adi.".txt");
$fonk->ajax_tamam("Dil Silindi.");
setcookie("dil",$baska_dili,time()+60*60*24*7);
$fonk->yonlendir("index.php");

}
<?php
if(!$_POST){
    die("Post gelmedi");
}

$id     = $gvn->rakam($_GET["id"]);
if($id == '' || !is_numeric($id) || strlen($id) > 15 || $hesap->id == ''){
    die("Geçersiz kimlik");
}

$sorgula        = $db->prepare("SELECT * FROM galeri_foto WHERE site_id_555=999 AND id=? AND sayfa_id!=0 ");
$sorgula->execute(array($id));
if($sorgula->rowCount()<1){
    die("Geçersiz görsel");
}
$gorsel         = $sorgula->fetch(PDO::FETCH_OBJ);

$snc            = $db->prepare("SELECT acid,id FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND id=?");
$snc->execute(array($gorsel->sayfa_id));
if($snc->rowCount(4)<1){
    die("Geçersiz ilan");
}
$snc             = $snc->fetch(PDO::FETCH_OBJ);

if($hesap->tipi != 1){
$acc		= $db->query("SELECT id,kid FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$kid		= $acc->kid;
if($snc->acid != $hesap->id AND $hesap->id != $kid){
	die("Geçersiz yetki");
}
}

$derece       = $gvn->sayi($_POST["rotate"]);
if($derece == '' || strlen($derece)==1 || strlen($derece)>4 || $derece > 360 || $derece < -360){
    die("Lütfen döndürün!");
}


$dhyphen        = str_replace("-","",$derece);

if($derece < 0){
    $before = $derece;
    $derece = 360 - $dhyphen;
}


$gorsel_adi     = $gorsel->resim;
$uzanti 	    = $fonk->uzanti($gorsel_adi);
$radi 		    = str_replace($uzanti,"",$gorsel_adi);
$original_name  = $radi."_original".$uzanti;
$watermark		= ($gayarlar->stok == 1) ? 'watermark.png' : '';

$ayarla         = $fonk->gorsel_ayarla("uploads",$original_name,"",false,false,false,$derece);

$ayarla = $fonk->gorsel_ayarla("uploads",$original_name,$radi,false,$gorsel_boyutlari['foto_galeri']['orjin_x'],$gorsel_boyutlari['foto_galeri']['orjin_y'],false,$watermark);

$ayarla = $fonk->gorsel_ayarla("uploads",$original_name,$radi,true,$gorsel_boyutlari['foto_galeri']['thumb_x'],$gorsel_boyutlari['foto_galeri']['thumb_y'],false,$watermark);

if($ayarla){
    echo "OK";
}
<?php

if($hesap->id == ''){

die();

}



$id			= $gvn->rakam($_GET["id"]);

$snc		= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");

$snc->execute(array($id));



if($snc->rowCount() > 0 ){

$snc		= $snc->fetch(PDO::FETCH_OBJ);

}else{

die("403 Forbidden!");

}



$multi			= $db->query("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no." ORDER BY id ASC");

$multict		= $multi->rowCount();

$multif			= $multi->fetch(PDO::FETCH_OBJ);

$multidids		= $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;

$mulid 			= ($multict>1 && $snc->id == $multif->id) ? " IN(".$multidids.")" : "=".$snc->id;

$mulidx 		= ($multict>1) ? " IN(".$multidids.")" : "=".$snc->id;





$ilan_aktifet	= ($hesap->tipi==1) ? 1 : $hesap->ilan_aktifet;

$acc			= $db->query("SELECT id,kid,ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);

$kid			= $acc->kid;

if($snc->acid != $hesap->id AND $hesap->id != $kid){

die();

}

$kurumsal		= $db->prepare("SELECT ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=?");

$kurumsal->execute(array($kid));

if($kurumsal->rowCount()>0){

$ilan_aktifet	= ($kurumsal->ilan_aktifet == 0) ? $ilan_aktifet : $kurumsal->ilan_aktifet;

}



$ilan_resim_limit	= $hesap->ilan_resim_limit;

## Paket için gerekli kontroller start ##

if($hesap->kid == 0 && $hesap->turu == 0){ // Bireysel



$acids				= $hesap->id;

$pkacid				= $acids;



}elseif($hesap->kid == 0 && $hesap->turu == 1){ // Kurumsal



$dids			= $db->query("SELECT kid,id,GROUP_CONCAT(id SEPARATOR ',') AS danismanlar_19541956 FROM hesaplar WHERE site_id_555=999 AND kid=".$hesap->id)->fetch(PDO::FETCH_OBJ);

$danismanlar	= $dids->danismanlar;

$acids			= ($danismanlar == '') ? $hesap->id : $hesap->id.','.$danismanlar;

$pkacid			= $hesap->id;



}elseif($hesap->kid != 0 && $hesap->turu == 2){ // Danışman



$kurumsal			= $db->query("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=".$hesap->kid);

if($kurumsal->rowCount()>0){



$kurumsal			= $kurumsal->fetch(PDO::FETCH_OBJ);

$dids				= $db->query("SELECT kid,id,GROUP_CONCAT(id SEPARATOR ',') AS danismanlar_19541956 FROM hesaplar WHERE site_id_555=999 AND kid=".$kurumsal->id)->fetch(PDO::FETCH_OBJ);

$danismanlar		= $dids->danismanlar;

$acids				= ($danismanlar == '') ? $kurumsal->id : $kurumsal->id.','.$danismanlar;

$pkacid				= $kurumsal->id;

$ilan_resim_limit	+= $kurumsal->ilan_resim_limit;

}else{

$acids				= $hesap->id;

$pkacid				= $acids;

}

}else{

$acids				= $hesap->id;

$pkacid				= $acids;

}

## Paket için gerekli kontroller end ##



$paketi				= $db->query("SELECT * FROM upaketler_19541956 WHERE acid=".$pkacid." AND durum=1 AND btarih>NOW()");

if($paketi->rowCount()>0){

$paketi				=  $paketi->fetch(PDO::FETCH_OBJ);

$ilan_resim_limit	= ($paketi->ilan_resim_limit == 0) ? 99999 : $paketi->ilan_resim_limit;

}



$yfotolar		= $db->query("SELECT id FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$snc->id." ORDER BY sira ASC");

$yfotolarcnt	= $yfotolar->rowCount();





$ilan_resim_limit	-= $yfotolarcnt;







if($ilan_resim_limit <1){

die();

}





if($ilan_aktifet == 0 && $snc->durum != 0){

$hesapp			= $hesap;

$adsoyad		= $hesapp->adi;

$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';

$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;

$fonk->bildirim_gonder(array($adsoyad,$snc->id,$snc->baslik,date("d.m.Y H:i")),"onay_bekleyen_ilan",$hesapp->email,$hesapp->telefon);

}







if($_FILES){





$max_size				= 99999999999; // Yüklyeyeceği her resim için max 2Mb boyut siniri aşarsa resim yüklenmez!

$allow_exten			= array('.jpg','.jpeg','.png'); // İzin verilen uzantılar...

$file					= $_FILES["file"];



$tmp	= $file["tmp_name"]; // Kaynak çekiyoruz

$adi	= $file["name"]; // Dosya adını alıyoruz..

$size	= $file["size"]; // Boyutunu alıyoruz

$uzanti	= $fonk->uzanti($adi); // Uzantısını alıyoruz

if($size <= $max_size){ // Boyutu max boyutu geçmiyorsa devam ediyoruz

if(in_array($uzanti,$allow_exten)){ // izin verilen uzantılarda ise devam ediyoruz

$watermark		= ($gayarlar->stok == 1) ? 'watermark.png' : '';

$exmd			= strtolower(substr(md5(uniqid(rand())), 0,12));

$randnm			= $snc->url."-".$exmd.$uzanti;

$resim			= $fonk->resim_yukle(true,$file,$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['thumb_x'],$gorsel_boyutlari['foto_galeri']['thumb_y'],true,$watermark,true); // Küçük

$resim			= $fonk->resim_yukle(false,$file,$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['orjin_x'],$gorsel_boyutlari['foto_galeri']['orjin_y'],true,$watermark,true); // Büyük boy

if($resim != ''){ // Eğer resim yüklenmişse...

$db->query("INSERT INTO galeri_foto SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_333=333,site_id_335=335,site_id_334=334,site_id_306=306,site_id_222=222,site_id_111=111,sayfa_id='".$snc->id."',resim='".$resim."',dil='".$dil."' ");

$db->query("UPDATE sayfalar SET durum='".$ilan_aktifet."' WHERE site_id_555=000 AND id".$mulidx);

echo $resim;



if($snc->resim == '' || $snc->resim == 'default_ilan_resim.jpg'){

    $db->query("UPDATE sayfalar SET resim='".$resim."' WHERE site_id_555=000 AND id".$mulidx);

}



}else{ // Eğer resim yüklenmişse...

echo "görsel yüklenemedi!";

}

}else{ // izin verilen uzantılarda ise devam ediyoruz end

echo "Geçersiz uzanti.";

}

}else{

echo "Max boyutu aştı.";

}



} // Eğer resim varsa
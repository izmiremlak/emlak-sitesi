<?php
if($hesap->id == ''){ 
die();
}


$id			= $gvn->rakam($_GET["ilan_id"]);
$from		= $gvn->harf_rakam($_GET["from"]);
$video		= $gvn->zrakam($_GET["video"]);


$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);


$multi			= $db->query("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no." ORDER BY id ASC");
$multict		= $multi->rowCount();
$multif			= $multi->fetch(PDO::FETCH_OBJ);
$multidids		= $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;
$mulid 			= ($multict>1 && $snc->id == $multif->id) ? " IN(".$multidids.")" : "=".$snc->id;
$mulidx 			= ($multict>1) ? " IN(".$multidids.")" : "=".$snc->id;


$ilan_aktifet	= ($hesap->tipi==1) ? 1 : $hesap->ilan_aktifet;
$acc			= $db->query("SELECT id,kid,ilan_aktifet FROM hesaplar WHERE site_id_555=000 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$kid			= $acc->kid;
if($snc->acid != $hesap->id AND $hesap->id != $kid){
die();
}
$kurumsal		= $db->prepare("SELECT ilan_aktifet FROM hesaplar WHERE site_id_555=000 AND id=?");
$kurumsal->execute(array($kid));
if($kurumsal->rowCount()>0){
$ilan_aktifet	= ($kurumsal->ilan_aktifet == 0) ? $ilan_aktifet : $kurumsal->ilan_aktifet;
}



$video_tmp	= $_FILES["video"]["tmp_name"];


// E�er se�ilmemi� ise
if($video_tmp == ''){
die('<span class="error">'.dil("TX454").'</span>');
}

// De�i�kenler
$video_name	= $_FILES["video"]["name"];
$video_size	= $_FILES["video"]["size"];
$video_exte = $fonk->uzanti($video_name);
$uzantilar	= array(".mp4");


if($video_size > dil("VIDEO_MAX_BAYT")){
die('<span class="error">'.dil("TX455").'</span>');
}

if(!in_array($video_exte,$uzantilar)){
die('<span class="error">'.dil("TX456").'</span>');
}

$video_adi	= strtolower(substr(md5(uniqid(rand())), 0,12)).".mp4";


$yukle		= @move_uploaded_file($video_tmp,"/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$video_adi);

if(!$yukle){
?><script type="text/javascript">
var xbar 	 	 = $('#YuklemeDurum');
var xpercent 	 = $('#percent');
var xpercentVal	 = "0%";

$("#YuklemeBar").slideUp(400,function(){
$("#VideoForm").slideDown(400);
xbar.width(xpercentVal);
xpercent.html(xpercentVal);
});
</script><?
die('<span class="error">'.dil("TX456").'</span>');
}

if($snc->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$snc->video;
if(file_exists($nirde)){
unlink($nirde);
}
}


if($ilan_aktifet == 0 && $snc->durum != 0){
$hesapp			= $hesap;
$adsoyad		= $hesapp->adi;
$adsoyad		.= ($hesapp->soyadi != '') ? ' '.$hesapp->soyadi : '';
$adsoyad		= ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
$fonk->bildirim_gonder(array($adsoyad,$snc->id,$snc->baslik,date("d.m.Y H:i")),"onay_bekleyen_ilan",$hesapp->email,$hesapp->telefon);
}


try{
$ilan_update		= $db->prepare("UPDATE sayfalar SET video=?,durum='".$ilan_aktifet."',gtarih='".$fonk->datetime()."' WHERE site_id_555=000 AND id".$mulidx);
$ilan_update->execute(array($video_adi));
}catch(PDOException $e){
die($e->getMessage());
}

if($from == "insert"){
if($gayarlar->dopingler_19541956 == 1){
$fonk->yonlendir("ilan-olustur?id=".$id."&asama=2");
}else{
$fonk->yonlendir("aktif-ilanlar",5000);
?><script type="text/javascript">
$("#galeri_video_ekle").hide(1,function(){
$("#TamamDiv").show(1);
ajaxHere('ajax.php?p=ilan_son_asama&id=<?=$snc->id;?>','asama_result');
});
$('html, body').animate({scrollTop: 250}, 500);
</script><?
}

}else{
$fonk->yonlendir("uye-paneli?rd=ilan_duzenle&id=".$snc->id."&goto=videos",100);
?><span class="complete"><?=dil("TX453");?></span><?
}
<?php
if($hesap->id != "" AND $hesap->tipi != 0){


$id			= $gvn->rakam($_GET["ilan_id"]);
$from		= $gvn->harf_rakam($_GET["from"]);
$video		= $gvn->zrakam($_GET["video"]);


$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);





$video_tmp	= $_FILES["video"]["tmp_name"];


// Eğer seçilmemiş ise
if($video_tmp == ''){
die('<span class="error">'.dil("TX454").'</span>');
}

// Değişkenler
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

try{
$ilan_update		= $db->prepare("UPDATE sayfalar SET video=? WHERE site_id_555=000 AND ilan_no=?");
$ilan_update->execute(array($video_adi,$snc->ilan_no));
}catch(PDOException $e){
die($e->getMessage());
}

if($from == "insert"){

if($gayarlar->dopingler_19541956 == 1){
$fonk->ajax_tamam("Video Başarıyla Yüklendi.");
$fonk->yonlendir("index.php?p=ilan_ekle&id=".$snc->id."&asama=2",1);
}else{
$fonk->yonlendir("index.php?p=ilanlar",3000);
?><script type="text/javascript">
$("#galeri_video_ekle").hide(1,function(){
$("#TamamDiv").show(1);
});
$('html, body').animate({scrollTop: 0}, 500);
</script><?
}

}else{
$fonk->yonlendir("index.php?p=ilan_duzenle&id=".$snc->id."&goto=video#tab3",100);
$fonk->ajax_tamam("Video Başarıyla Yüklendi.");
}


}
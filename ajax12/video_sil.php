<?php
if($hesap->id == ''){ 
die();
}

$id			= $gvn->rakam($_GET["ilan_id"]);

$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);

if($snc->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$snc->video;
if(file_exists($nirde)){
unlink($nirde);
}
}

$db->query("UPDATE sayfalar SET video='' WHERE site_id_555=999 AND id=".$id);

?><script type="text/javascript">
$("#VideoVarContent").slideUp(300,function(){
$("#galeri_video_ekle").slideDown(300);
});
$('html, body').animate({scrollTop: 0}, 500);
</script><?
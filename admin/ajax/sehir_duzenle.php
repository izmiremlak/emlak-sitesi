<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM sehirler_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$ulke_id		= $gvn->zrakam($_POST["ulke_id"]);
$il				= $gvn->zrakam($_POST["il"]);
$ilce			= $gvn->zrakam($_POST["ilce"]);
$mahalle		= $gvn->zrakam($_POST["mahalle"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$emlak_durum	= $gvn->html_temizle($_POST["emlak_durum"]);

if($il == 0 OR $fonk->bosluk_kontrol($emlak_durum) == true){
die($fonk->ajax_uyari("Lütfen il ve Emlak durum alanlarını seçiniz"));
}


$full_slug		= "";
if($il != 0){
$ilim			= $db->query("SELECT slug FROM il WHERE id=".$il)->fetch(PDO::FETCH_OBJ);
$slug			= $ilim->slug;
$full_slug		.= "-".$slug;
}
if($ilce != 0){
$ilcem			= $db->query("SELECT slug FROM ilce WHERE id=".$ilce)->fetch(PDO::FETCH_OBJ);
$slug			= $ilcem->slug;
$full_slug		.= "-".$slug;
}

if($mahalle != 0){
$mahallem		= $db->query("SELECT slug FROM mahalle_koy WHERE id=".$mahalle)->fetch(PDO::FETCH_OBJ);
$slug			= $mahallem->slug;
$full_slug		.= "-".$slug;
}


$full_slug		= trim($full_slug,"-");
if($full_slug == ''){
$full_slug		= md5(time());
}else{
$full_slug		.= "-".time();
}

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1tmp != ""){
$randnm			= $full_slug.$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['sehirler']['thumb_x'],$gorsel_boyutlari['sehirler']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['sehirler']['orjin_x'],$gorsel_boyutlari['sehirler']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE sehirler_19541956 SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}
}

$updt			= $db->prepare("UPDATE sehirler_19541956 SET ulke_id=?,il=?,ilce=?,mahalle=?,sira=?,emlak_durum=? WHERE id=".$snc->id);
$updt->execute(array($ulke_id,$il,$ilce,$mahalle,$sira,$emlak_durum));




if($updt){
$fonk->ajax_tamam("Başarıyla Güncellendi.");
}


}
}
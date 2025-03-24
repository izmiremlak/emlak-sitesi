<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM musteri_yorumlar WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$adsoyad		= $gvn->html_temizle($_POST["adsoyad"]);
$firma			= $gvn->html_temizle($_POST["firma"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$mesaj			= $_POST["mesaj"];


if($fonk->bosluk_kontrol($adsoyad) == true OR $mesaj == ''){
die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
}

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];


if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['musteri_yorumlar']['thumb_x'],$gorsel_boyutlari['musteri_yorumlar']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['musteri_yorumlar']['orjin_x'],$gorsel_boyutlari['musteri_yorumlar']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE musteri_yorumlar SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","../uploads/thumb/<?=$resim;?>");
});
</script><?
} 

}




$updt			= $db->prepare("UPDATE musteri_yorumlar SET adsoyad=?,mesaj=?,sira=?,firma=? WHERE id=".$id);
$updt->execute(array($adsoyad,$mesaj,$sira,$firma));

if($updt){
$fonk->ajax_tamam("İşlem Tamamlandı.");
}


}
}
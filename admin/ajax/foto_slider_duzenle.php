<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM slider_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}




$baslik		= $gvn->html_temizle($_POST["baslik"]);
$sira		= $gvn->zrakam($_POST["sira"]);
$aciklama	= $gvn->html_temizle($_POST["aciklama"]);
$link		= $gvn->html_temizle($_POST["link"]);

$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];



if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',$gorsel_boyutlari['slider']['thumb_x'],$gorsel_boyutlari['slider']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['slider']['orjin_x'],$gorsel_boyutlari['slider']['orjin_y']);

if($resim){
$avgn			= $db->prepare("UPDATE slider_19541956 SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Resim Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","../uploads/thumb/<?=$resim;?>");
});
</script><?
}
}else{
$fonk->ajax_hata('Resim Güncellenemedi. Bir hata oluştu!');
}



}


$updt			= $db->prepare("UPDATE slider_19541956 SET baslik=:baslik,sira=:sira,aciklama=:aciklamax,link=:linkx WHERE id=:ids");
$updt->execute(array(
'baslik' => $baslik,
'sira' => $sira,
'aciklamax' => $aciklama,
'linkx' => $link,
'ids' => $snc->id
));

if($updt){
$fonk->ajax_tamam("Slayt Güncellendi.");
}


}
}
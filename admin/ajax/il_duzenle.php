<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM il WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$il_adi			= $gvn->html_temizle($_POST["il_adi"]);
$anasayfa		= $gvn->zrakam($_POST["anasayfa"]);


if($fonk->bosluk_kontrol($il_adi) == true){
die($fonk->ajax_hata("Lütfen il adı yazınız."));
}


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

$resim2tmp		= $_FILES['resim2']["tmp_name"];
$resim2nm		= $_FILES['resim2']["name"];

if($resim1tmp != ""){
$randnm			= $snc->slug.$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',$gorsel_boyutlari['sehirler']['orjin_x'],$gorsel_boyutlari['sehirler']['orjin_y']);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE il SET resim=:image WHERE id=:id");
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


$sql			= $db->prepare("UPDATE il SET il_adi=?,anasayfa=? WHERE id=".$snc->id);

  $sql->execute(array($il_adi,$anasayfa));
    
	

if($sql){
$fonk->ajax_tamam("Şehir Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}
}
<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM diller_19541956 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$adi			= $gvn->html_temizle($_POST["adi"]);
$kisa_adi		= $gvn->html_temizle($_POST["kisa_adi"]);
$gosterim_adi	= $gvn->html_temizle($_POST["gosterim_adi"]);
$sira			= $gvn->zrakam($_POST["sira"]);
$degiskenler	= stripslashes($_POST["degiskenler"]);
$durum    		= $gvn->zrakam($_POST["durum"]);


if($fonk->bosluk_kontrol($adi) == true){
die($fonk->ajax_hata("Lütfen dil adını boş yazmayınız."));
}


$resim1tmp		= $_FILES['resim']["tmp_name"];
$resim1nm		= $_FILES['resim']["name"];

if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'resim',$randnm,'../uploads',false,false);
$resim			= $fonk->resim_yukle(false,'resim',$randnm,'../uploads',false,false);

## veritabanı işlevi
$avgn			= $db->prepare("UPDATE diller_19541956 SET resim=:image WHERE id=:id");
$avgn->execute(array('image' => $resim, 'id' => $snc->id));
if($avgn){
$fonk->ajax_tamam('Simge Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim_src').attr("src","../uploads/thumb/<?=$resim;?>");
});
</script><?
}

}



file_put_contents("../".THEME_DIR."diller/".$snc->kisa_adi.".txt",$degiskenler);

$sql			= $db->prepare("UPDATE diller_19541956 SET adi=?,gosterim_adi=?,sira=?,durum=? WHERE id=".$snc->id);
  $sql->execute(array($adi,$gosterim_adi,$sira,$durum));


if($sql){
$fonk->ajax_tamam("Dil Güncellendi.");
}else{
$fonk->ajax_hata("Bir hata oluştu.");
}




}
}

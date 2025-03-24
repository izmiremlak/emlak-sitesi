<?php
if($_FILES){
if($hesap->id != "" AND $hesap->tipi != 0){



$resim1tmp		= $_FILES['resim1']["tmp_name"];
$resim1nm		= $_FILES['resim1']["name"];

$resim2tmp		= $_FILES['resim2']["tmp_name"];
$resim2nm		= $_FILES['resim2']["name"];

$resim3tmp		= $_FILES['resim3']["tmp_name"];
$resim3nm		= $_FILES['resim3']["name"];

$resim4tmp		= $_FILES['resim4']["tmp_name"];
$resim4nm		= $_FILES['resim4']["name"];

$resim5tmp		= $_FILES['resim5']["tmp_name"];
$resim5nm		= $_FILES['resim5']["name"];

$resim6tmp		= $_FILES['resim6']["tmp_name"];
$resim6nm		= $_FILES['resim6']["name"];

$resim7tmp		= $_FILES['resim7']["tmp_name"];
$resim7nm		= $_FILES['resim7']["name"];

$resim8tmp		= $_FILES['resim8']["tmp_name"];
$resim8nm		= $_FILES['resim8']["name"];

$resim9tmp		= $_FILES['resim9']["tmp_name"];
$resim9nm		= $_FILES['resim9']["name"];

$resim10tmp		= $_FILES['resim10']["tmp_name"];
$resim10nm		= $_FILES['resim10']["name"];

$resim11tmp		= $_FILES['resim11']["tmp_name"];
$resim11nm		= $_FILES['resim11']["name"];

$resim12tmp		= $_FILES['resim12']["tmp_name"];
$resim12nm		= $_FILES['resim12']["name"];

$resim13tmp		= $_FILES['resim13']["tmp_name"];
$resim13nm		= $_FILES['resim13']["name"];



if($resim1tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(false,'resim1',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET bayiler_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Bayiler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim1_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Bayiler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim2tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim2nm);
$resim			= $fonk->resim_yukle(false,'resim2',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET subeler_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Şubeler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim2_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Şubeler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim3tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim3nm);
$resim			= $fonk->resim_yukle(false,'resim3',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET belgeler_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Belgeler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim3_src').attr("src","/../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Belgeler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim4tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim4nm);
$resim			= $fonk->resim_yukle(false,'resim4',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET ekatalog_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim4_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim5tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim5nm);
$resim			= $fonk->resim_yukle(false,'resim5',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET foto_galeri_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim5_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}

if($resim6tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim6nm);
$resim			= $fonk->resim_yukle(false,'resim6',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET video_galeri_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim6_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim7tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim7nm);
$resim			= $fonk->resim_yukle(false,'resim7',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET referanslar_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Referanslar Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim7_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Referanslar Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim8tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim8nm);
$resim			= $fonk->resim_yukle(false,'resim8',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET haber_ve_duyurular_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Haberler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim8_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Haberler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}

if($resim9tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim9nm);
$resim			= $fonk->resim_yukle(false,'resim9',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET yazilar_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Duyurular Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim9_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Duyurular Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}


if($resim10tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim10nm);
$resim			= $fonk->resim_yukle(false,'resim10',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET hizmetler_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Hizmetler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim10_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Hizmetler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}

if($resim11tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim11nm);
$resim			= $fonk->resim_yukle(false,'resim11',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET projeler_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Projeler Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim11_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Projeler Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}

if($resim12tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim12nm);
$resim			= $fonk->resim_yukle(false,'resim12',$randnm,'../uploads',$gorsel_boyutlari['headerbg']['orjin_x'],$gorsel_boyutlari['headerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET iletisim_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('İletişim Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim12_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('İletişim Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}

if($resim13tmp != ""){
$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim13nm);
$resim			= $fonk->resim_yukle(false,'resim13',$randnm,'../uploads',$gorsel_boyutlari['footerbg']['orjin_x'],$gorsel_boyutlari['footerbg']['orjin_y']);
if($resim){
$avgn			= $db->query("UPDATE gayarlar_19541956 SET footer_resim='".$resim."' ");
if($avgn){$fonk->ajax_tamam('Footer Arkaplan Görseli Güncellendi');
?><script type="text/javascript">
$(document).ready(function(){
$('#resim13_src').attr("src","../uploads/<?=$resim;?>");
});
</script><?
}}else{$fonk->ajax_hata('Footer Arkaplan Görseli Güncellenemedi. Bir hata oluştu!');}
}



}
}
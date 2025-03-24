<?php
if($hesap->id != "" AND $hesap->tipi != 0){
if($_FILES){
$resim1tmp		= $_FILES['file']["tmp_name"];
$resim1nm		= $_FILES['file']["name"];

$randnm			= strtolower(substr(md5(uniqid(rand())), 0,10)).$fonk->uzanti($resim1nm);
$resim			= $fonk->resim_yukle(true,'file',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['thumb_x'],$gorsel_boyutlari['foto_galeri']['thumb_y']);
$resim			= $fonk->resim_yukle(false,'file',$randnm,'/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads',$gorsel_boyutlari['foto_galeri']['orjin_x'],$gorsel_boyutlari['foto_galeri']['orjin_y']);

$db->query("INSERT INTO galeri_foto SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_333=333,site_id_335=335,site_id_334=334,site_id_306=306,site_id_222=222,site_id_111=111,resim='".$resim."',dil='".$dil."' ");


}
}
?>
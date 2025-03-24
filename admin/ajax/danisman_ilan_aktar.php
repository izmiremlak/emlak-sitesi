<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$danisman_id			= $gvn->zrakam($_POST["danisman_id"]);
$danisman_yeni_id		= $gvn->zrakam($_POST["danisman_yeni_id"]);

if($danisman_id == 0 || $danisman_yeni_id == 0){
die($fonk->ajax_hata("Lütfen seçim yapınız..."));
}

$kac					= $db->query("SELECT id FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND danisman_id=".$danisman_id)->rowCount();
if($kac<1){
die($fonk->ajax_hata("Danışmanın ilanı yok."));
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{
$query				= $db->prepare("UPDATE sayfalar SET danisman_id=?,acid=? WHERE site_id_555=000 AND danisman_id=?");
$query->execute(array(0,$danisman_yeni_id,$danisman_id));
}catch(PDOException $e){
die($e->getMessage());
}

echo $kac." adet ilan başarıyla aktarıldı.";


}
}
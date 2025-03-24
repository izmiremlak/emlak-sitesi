<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($hesap->id == ''){
die();
}
$id				= $gvn->rakam($_GET["id"]);

$kontrol		= $db->prepare("SELECT id FROM sayfalar WHERE site_id_555=999 AND id=? AND tipi=4");
$kontrol->execute(array($id));

if($kontrol->rowCount()==0){
die();
}
$ilan			= $kontrol->fetch(PDO::FETCH_OBJ);

$favKontrol	= $db->query("SELECT id FROM favoriler_19541956 WHERE acid=".$hesap->id." AND ilan_id=".$id);
if($favKontrol->rowCount()>0){
$neid		= $favKontrol->fetch(PDO::FETCH_OBJ);
$neid		= $neid->id;
try{
$db->query("DELETE FROM favoriler_19541956 WHERE id=".$neid);
echo 1;
}catch(PDOException $e){
echo 0;
}
}else{
try{
$db->query("INSERT INTO favoriler_19541956 SET acid='".$hesap->id."',ilan_id='".$id."',tarih='".$fonk->datetime()."' ");
echo 1;
}catch(PDOException $e){
echo 0;
}
}
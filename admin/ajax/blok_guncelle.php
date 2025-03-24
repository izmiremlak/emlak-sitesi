<?php
if($hesap->id != "" AND $hesap->tipi != 0){
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if($_POST){
foreach ($_POST['value'] as $key=>$row){
$keys 	= $key+1;
$id 	= $row['id']+1;
$blok = $row['name'];
$sira = $keys;
try{
$updt = $db->query("UPDATE ayarlar_19541956 SET ".$blok."_sira='".$sira."' WHERE dil='".$dil."' ");
}catch(PDOException $e){
  die($e->getMessage());
}
} // foreach

#$fonk->ajax_tamam("Ayarlar Kaydedildi.");

} // post end



}

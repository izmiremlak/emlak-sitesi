<?php
if($hesap->id == ''){ 
die();
}

$id			= $gvn->rakam($_GET["ilan_id"]);
$from		= $gvn->harf_rakam($_GET["from"]);
$photos		= $gvn->zrakam($_GET["photos"]);

$kontrol	= $db->prepare("SELECT id,resim,ilan_no,acid FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);

$ilan_aktifet	= ($hesap->tipi==1) ? 1 : $hesap->ilan_aktifet;
$acc			= $db->query("SELECT id,kid,ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=".$snc->acid)->fetch(PDO::FETCH_OBJ);
$kid			= $acc->kid;
if($snc->acid != $hesap->id AND $hesap->id != $kid){
die();
}
$kurumsal		= $db->prepare("SELECT ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=?");
$kurumsal->execute(array($kid));
if($kurumsal->rowCount()>0){
$ilan_aktifet	= ($kurumsal->ilan_aktifet == 0) ? $ilan_aktifet : $kurumsal->ilan_aktifet;
}


$multi			= $db->query("SELECT id,ilan_no FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no." ORDER BY id ASC");
$multict		= $multi->rowCount();
$multif			= $multi->fetch(PDO::FETCH_OBJ);
$multidids		= $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=000 AND ilan_no=".$snc->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;
$mulid 			= ($multict>1 && $snc->id == $multif->id) ? " IN(".$multidids.")" : "=".$snc->id;
$mulidx 			= ($multict>1) ? " IN(".$multidids.")" : "=".$snc->id;



if($from == "nestable"){

foreach ($_POST['value'] as $key=>$row){
$keys 	= $key+1;
$id 	= $row['id']+1;
$idi 	= $row['idi'];
$sira = $keys;
try{
$updt = $db->prepare("UPDATE galeri_foto SET sira=? WHERE site_id_555=999 AND id=? AND sayfa_id=? ");
$updt->execute(array($sira,$idi,$snc->id));
}catch(PDOException $e){
  die($e->getMessage());
}
} // foreach

die();
}



if($from == "insert"){
$yfotolar	= $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$snc->id." AND dil='".$dil."' ORDER BY sira ASC");
}else{
if(!$_POST){
die();
}
}



if($_POST){

$kapak		= strtolower($gvn->html_temizle($_POST["kapak"]));
if(stristr($kapak,"http://")){
die();
}
$siralar	= $_POST["sira"];
$cnt		= count($siralar);

if($kapak != '' AND $kapak != $snc->resim){
$gunc		= $db->prepare("UPDATE sayfalar SET resim=? WHERE site_id_555=000 AND id".$mulidx);
$gunc->execute(array($kapak));
}


/*foreach($siralar as $id=>$sira){
$sira		= $gvn->zrakam($sira);
$id			= $gvn->rakam($id);
$db->query("UPDATE galeri_foto SET sira='".$sira."' WHERE site_id_555=999 AND id=".$id);

}*/

} // Eğer post varsa


if($from == "insert"){
#if($photos>0){
$fonk->yonlendir("ilan-olustur?id=".$snc->id."&asama=1",1);


/*
}else{
$fonk->yonlendir("ilan-olustur?id=".$snc->id,1);
}*/
}else{
#$fonk->yonlendir("uye-paneli?rd=ilan_duzenle&id=".$snc->id."&goto=photos",100);
?><span class="complete"><?=dil("TX347");?></span><?
}
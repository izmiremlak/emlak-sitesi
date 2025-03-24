<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!$_POST){die();}

if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["ilan_id"]);
$from		= $gvn->harf_rakam($_GET["from"]);

$snc		= $db->prepare("SELECT id,resim,ilan_no FROM sayfalar WHERE site_id_555=000 AND id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}

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


$kapak		= $gvn->html_temizle($_POST["kapak"]);
$siralar	= $_POST["sira"];
$cnt		= count($siralar);

if($kapak != '' AND $kapak != $snc->resim){
try{
  $gunc		= $db->prepare("UPDATE sayfalar SET resim=? WHERE site_id_555=000 AND ilan_no=?");
  $gunc->execute(array($kapak,$snc->ilan_no));
}catch(PDOException $e){
die($e->getMessage());
}

}


/*foreach($siralar as $id=>$sira){
$sira		= $gvn->rakam($sira);
$id			= $gvn->rakam($id);
$db->query("UPDATE galeri_foto SET sira='".$sira."' WHERE site_id_555=999 AND id=".$id);

}*/

if($from == "insert"){

$fonk->yonlendir("index.php?p=ilan_ekle&id=".$snc->id."&asama=1",1);

}else{
$fonk->ajax_tamam("Galeri Güncellendi!");
$fonk->yonlendir("index.php?p=ilan_duzenle&id=".$snc->id."&goto=photos#tab2",1000);
}

}
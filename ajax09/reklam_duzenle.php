<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$id			= $gvn->rakam($_GET["id"]);
$snc		= $db->prepare("SELECT * FROM reklamlar_19561954 WHERE id=:ids");
$snc->execute(array('ids' => $id));

if($snc->rowCount() > 0 ){
$snc		= $snc->fetch(PDO::FETCH_OBJ);
}else{
die();
}


$baslik			= $gvn->html_temizle($_POST["baslik"]);
$tipi			= $gvn->zrakam($_POST["tipi"]);
$kodu			= $_POST["kodu"];
$mobil_kodu		= $_POST["mobil_kodu"];
$durum			= $gvn->zrakam($_POST["durum"]);
$suresiz		= $gvn->zrakam($_POST["suresiz"]);
$btarih			= $gvn->html_temizle($_POST["btarih"]);
$btarih			= ($btarih == '') ? date("Y-m-d") : date("Y-m-d",strtotime($btarih))." 23:59:59";
$tarih			= $fonk->datetime();


try{
$query			= $db->prepare("UPDATE reklamlar_19561954 SET baslik=?,tipi=?,kodu=?,mobil_kodu=?,durum=?,suresiz=?,btarih=? WHERE id=".$id);
$query->execute(array($baslik,$tipi,$kodu,$mobil_kodu,$durum,$suresiz,$btarih));
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Reklam güncellendi.");
$fonk->yonlendir("index.php?p=reklamlar",1000);


}
}
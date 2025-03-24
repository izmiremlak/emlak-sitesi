<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$baslik		= $_POST["baslik"];
$link		= $_POST["link"];
$sira		= $_POST["sira"];
$count		= count($baslik);

$db->query("DELETE FROM referanslar_19541956 WHERE dil='".$dil."' ");

for($i=0; $i<=$count; $i++){
$adi		= $gvn->html_temizle($baslik[$i]);
$website	= $gvn->html_temizle($link[$i]);
$siraa		= $gvn->zrakam($sira[$i]);
if($adi != ''){
$ekle		= $db->prepare("INSERT INTO referanslar_19541956 SET adi=?,sira=?,website=?,dil=?");
$ekle->execute(array($adi,$siraa,$website,$dil));
}
}

$fonk->ajax_tamam("Seo linkler başarıyla güncellendi.");

}
}
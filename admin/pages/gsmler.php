<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$data		= $_POST["gonderilenler"];


$numaralar		= str_replace("\n","<br />",$data);
$phones			= explode("<br />",$numaralar);
$numaralarx		= array();
foreach($phones as $gsm){
$gsm			= $gvn->rakam($gsm);
$gsm				= trim($gsm);
if($gsm != "" AND is_numeric($gsm)){
$gsm				= (substr($gsm,0,3) == '+90') ? '0'.substr($gsm,3,20) : $gsm;
$gsm				= (substr($gsm,0,2) == '90') ? '0'.substr($gsm,2,20) : $gsm;
$gsm				= (substr($gsm,0,1) != 0) ? '0'.$gsm : $gsm;
if(strlen($gsm) == 11){
if(!in_array($gsm,$numaralarx)){
$numaralarx[] 		= $gsm;
}
}
}
}

$bulten				= @implode(",",$numaralarx);

$guncel				= $db->prepare("UPDATE gayarlar_19541956 SET bulten_gsm=?");
$guncel->execute(array($bulten));

$fonk->ajax_tamam("Data başarıyla güncellendi.");


}
}
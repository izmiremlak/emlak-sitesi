<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$data		= $_POST["gonderilenler"];

$emails			= explode("\n",$data);
$emaillerx		= array();
foreach($emails as $eml){
$eml			= $gvn->html_temizle($eml);
$eml			= trim($eml);
if($eml != ""){
if(!in_array($eml,$emaillerx)){
if($gvn->eposta_kontrol($eml)){
$emaillerx[] 		= $eml; 
}
}
}
} 

$bulten				= @implode(",",$emaillerx);

$guncel				= $db->prepare("UPDATE gayarlar_19541956 SET bulten_email=?");
$guncel->execute(array($bulten));

$fonk->ajax_tamam("Data başarıyla güncellendi.");


}
}
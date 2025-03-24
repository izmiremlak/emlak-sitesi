<?php
if(!isset($_POST)){
die(); exit;
}

$email		= $gvn->html_temizle($_POST["email"]);
$gsmx		= $gvn->rakam($_POST["gsm"]);


if($email == '' AND $gsmx == ''){
die('<span class="error">'.dil("TX4").'</span>');
}



if($gsmx != ''){


$numaralar		= str_replace(",","<br />",$gayarlar->bulten_gsm);
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



$gsmx			= trim($gsmx);
if($gsmx != "" AND is_numeric($gsmx)){
$gsmx				= (substr($gsmx,0,3) == '+90') ? '0'.substr($gsmx,3,20) : $gsmx;
$gsmx				= (substr($gsmx,0,2) == '90') ? '0'.substr($gsmx,2,20) : $gsmx;
$gsmx				= (substr($gsmx,0,1) != 0) ? '0'.$gsmx : $gsmx;
if(strlen($gsmx) == 11){
if(in_array($gsmx,$numaralarx)){
die('<span class="error">'.dil("TX5").'</span>');
}else{
$numaralarx[] 		= $gsmx;
}
}else{
die('<span class="error">'.dil("TX6").'</span>');
}
}else{
die('<span class="error">'.dil("TX6").'</span>');
}

$bulten_gsm			= @implode(",",$numaralarx);
$update				= $db->prepare("UPDATE gayarlar_19541956 SET bulten_gsm=? ");
$update->execute(array($bulten_gsm));

} // eğer gsm yazmışsa




if($email != ''){

$epostalar		= str_replace(",","<br />",$gayarlar->bulten_email);
$emails			= explode("<br />",$epostalar);
$emaillerx		= array();
foreach($emails as $eml){
$eml			= $gvn->html_temizle($eml);
$eml			= trim($eml);
if($eml != ""){
if(!in_array($eml,$emaillerx)){
$emaillerx[] 		= $eml; 
}
}
}



$email				= trim($email);
if($email != ""){
if(!$gvn->eposta_kontrol($email)){
die('<span class="error">'.dil("TX8").'</span>');
}else{
if(in_array($email,$emaillerx)){
die('<span class="error">'.dil("TX9").'</span>');
}else{
$emaillerx[] 		= $email;
}
}
}

$bulten_email		= @implode(",",$emaillerx);
$update				= $db->prepare("UPDATE gayarlar_19541956 SET bulten_email=? ");
$update->execute(array($bulten_email));

} // Eğer email yazmışsa 




?><script type="text/javascript">
$("#bulten_form").slideUp(700,function(){
$("#BultenTamam").slideDown(800);
});
</script><?


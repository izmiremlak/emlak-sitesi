<?php

Class pagenate {

function sql_query($sql,$git,$limit,$execute = false){ 
global $db,$gvn;
$git	= (strlen($git)>=11) ? 1 : $git;
$git  	= $gvn->rakam($git);
$limit  = $gvn->rakam($limit);
	if(!is_numeric($git) or $git == 0 or $git < 1){
	$git = 1;
	}
	
	if(is_array($execute)){
	$qrr			= $db->prepare($sql);
	$qrr->execute($execute);
	}else{
	$qrr			= $db->query($sql);
	}
	$count 			= $qrr->rowCount();
	$toplamsayfa    = ceil($count / $limit);
	$baslangic  = ($git-1)*$limit;
	if($git-5 < 1){
	$basdan 		= 1;
	}else{
	$basdan 		= $git-3;
	}
	if($git+5 > $toplamsayfa){
	$kadar 			= $toplamsayfa;
	}else{
	$kadar 			= $git+3;
	}
	if($git > $toplamsayfa){
	$git 		= $toplamsayfa;
	}
	if($git < 1){
	$git 		= 1;
	}
	return array(
	'sql' => $sql.' LIMIT '.$baslangic.','.$limit.' ',
	'basdan' => $basdan,
	'kadar' => $kadar,
	'baslangic' => $baslangic,
	'toplam' => $count
	);
	
	}
function listele($base_url,$git,$basdan,$kadar,$active_class,$sorgu){
global $gvn;
$git 		= $gvn->rakam($git);

if($git == '' or $git == 0){
$git = 1;
}
if($kadar > 0 ){
?>
 <span><a href="<? echo $base_url; ?><? echo $git-1; ?>"><?=(dil('PGN2') == '') ? 'Önceki' : dil('PGN2');?></a></span>
 <?php
 for($i=$basdan; $i<=$kadar; $i++){
 if($i != ''){
 ?>
 <span <? if($git == $i){ echo $active_class; } ?>><a href="<? echo $base_url; ?><? echo $i; ?>"><? echo $i; ?></a></span> 
 <?
 }
 }
 ?>
 <span><a href="<? echo $base_url; ?><? if($git+1 > $kadar ){ echo $kadar; }else{ echo $git+1; } ?>"><?=(dil('PGN3') == '') ? 'Sonraki' : dil('PGN3');?></a></span> 
<?
} // EĞER  VARSA LİSTELENECEK ÖĞLE
} // fonksiyon kapanisi <MTQ4Mw==>
}
?>
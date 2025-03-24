<?php
if($hesap->id == ''){
die();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id			= $gvn->rakam($_GET["id"]);
$from		= $gvn->harf_rakam($_GET["from"]);
$doping		= $_POST["doping"];


$kontrol	= $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if($kontrol->rowCount() < 1){
	die();
}
$snc		= $kontrol->fetch(PDO::FETCH_OBJ);


$cdoping	= count($doping);
if($doping == '' || $cdoping==0){
die('<span class="error">'.dil("TX525").'</span>');
}




list($dzaman1a,$dzaman1b) = explode("|",$gayarlar->dzaman1);
list($dzaman2a,$dzaman2b) = explode("|",$gayarlar->dzaman2);
list($dzaman3a,$dzaman3b) = explode("|",$gayarlar->dzaman3);
list($dzaman4a,$dzaman4b) = array("100","yillik");




$customs = array(
"ilan_id" => $id
);
foreach($doping as $k=>$v){
if(is_numeric($k) && is_numeric($v) && strlen($v)==1 && $v > 0 && $v <5){
$sga		= $db->prepare("SELECT id,fiyat1,fiyat2,fiyat3,adi FROM doping_ayarlar_19541956 WHERE id=?");
$sga->execute(array($k));
if($sga->rowCount()==0){
die('<span class="error">Your select option is invalid.</span>');
}else{
$di			= $sga->fetch(PDO::FETCH_ASSOC);

## Eğer aynı dopingten varsa ve süresi bitmemişse... ##
$isdoping	= $db->prepare("SELECT id FROM dopingler_19541956 WHERE ilan_id=? AND did=? AND btarih > NOW();");
$isdoping->execute(array($snc->id,$k));
if($isdoping->rowCount()>0){
die('<span class="error">"'.$di["adi"].'" dopingi zaten ilanınızda aktif kullanılıyor.</span>');
}


$customs["dopingler_19541956"][] = array(
'did' => $k,
'adi' => $di["adi"],
'sure' => ${"dzaman".$v."a"},
'periyod' => ${"dzaman".$v."b"}
);
}
}
}



$custom			= $customs;
$odeme_yontemi	= "Yok";
$tarih			= $fonk->datetime();
$durum			= 1;
$hesap_id		= $hesap->id;

try{
$group		= $db->prepare("INSERT INTO dopingler_group_19541956 SET acid=?,ilan_id=?,tutar=?,tarih=?,odeme_yontemi=?,durum=?");
$group->execute(array($hesap_id,$custom["ilan_id"],$custom["toplam_tutar"],$tarih,$odeme_yontemi,$durum));
$gid		= $db->lastInsertId();
}catch(PDOException $e){
die($e->getMessage());
}

$dopingler_19541956		= $custom["dopingler_19541956"];
foreach($dopingler_19541956 as $dop){
$expiry			= "+".$dop["sure"];
$expiry			.= ($dop["periyod"] == "gunluk") ? ' day' : '';
$expiry			.= ($dop["periyod"] == "aylik") ? ' month' : '';
$expiry			.= ($dop["periyod"] == "yillik") ? ' year' : '';
$btarih			= date("Y-m-d",strtotime($expiry))." 23:59:59";
try{
$olustur	= $db->prepare("INSERT INTO dopingler_19541956 SET acid=?,ilan_id=?,did=?,tutar=?,adi=?,sure=?,periyod=?,tarih=?,btarih=?,durum=?,gid=?");
$olustur->execute(array($hesap_id,$custom["ilan_id"],$dop["did"],0,$dop["adi"],$dop["sure"],$dop["periyod"],$tarih,$btarih,$durum,$gid));
}catch(PDOException $e){
die($e->getMessage());
}
}






if($from == "insert"){
$fonk->yonlendir("index.php?p=ilanlar",5000);
?><script type="text/javascript">
$(document).ready(function(){
$(".ilanasamax").removeAttr("id");
$(".islem_tamam").attr("id","asamaaktif");
});
$("#doping_ekle").hide(1,function(){
$("#TamamDiv").show(1);
});
$('html, body').animate({scrollTop: 0}, 500);
</script><?
}else{
$fonk->yonlendir("index.php?p=ilan_duzenle&id=".$id."&goto=doping#tab4",1000);
$fonk->ajax_tamam("Doping Ayarlandı.");
}



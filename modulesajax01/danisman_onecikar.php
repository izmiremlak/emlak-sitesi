<?php
if($hesap->id == ''){
die();
}

if($hesap->turu != 1){
die();
}

$id				= $gvn->rakam($_GET["id"]);


$kontrol		= $db->prepare("SELECT id,avatar,onecikar,onecikar_btarih FROM hesaplar WHERE site_id_555=999 AND id=? AND kid=?");
$kontrol->execute(array($id,$hesap->id));

if($kontrol->rowCount()==0){
die();
}

$danisman		= $kontrol->fetch(PDO::FETCH_OBJ);


if($danisman->onecikar == 1){
$bugun			= date("Y-m-d");
$dkgun			= $fonk->gun_farki($danisman->onecikar_btarih,$bugun);
if($dkgun<0){
$fonk->yonlendir("danisman-one-cikar?id=".$id);
die();
}elseif($dkgun>=0){
die();
}
}else{
$oncpaket		= $db->query("SELECT id,danisman_onecikar,danisman_onecikar_sure,danisman_onecikar_periyod FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND danisman_onecikar=1 AND danisman_onecikar_use=1");
if($oncpaket->rowCount()>0){
$fonk->yonlendir("danisman-one-cikar?id=".$id);
die();
}else{
$paketegore		= $db->query("SELECT id,danisman_onecikar,danisman_onecikar_sure,danisman_onecikar_periyod FROM upaketler_19541956 WHERE acid=".$hesap->id." AND durum=1 AND danisman_onecikar=1 AND btarih>NOW()");
if($paketegore->rowCount()>0){
$paket				= $paketegore->fetch(PDO::FETCH_OBJ);
$paketegore			= $paket;
$danisman_onecikar_sure 	= ($paketegore->danisman_onecikar_sure == 0) ? 120 : $paketegore->danisman_onecikar_sure;
$danisman_onecikar_periyod  = ($paketegore->danisman_onecikar_sure == 0) ? "yillik" : $paketegore->danisman_onecikar_periyod;

$expiry			= "+".$danisman_onecikar_sure;
$expiry			.= ($danisman_onecikar_periyod == "gunluk") ? ' day' : '';
$expiry			.= ($danisman_onecikar_periyod == "aylik") ? ' month' : '';
$expiry			.= ($danisman_onecikar_periyod == "yillik") ? ' year' : '';
$btarih			= date("Y-m-d",strtotime($expiry))." 23:59:59";

$daUpdate		= $db->query("UPDATE hesaplar SET onecikar=1,onecikar_btarih='".$btarih."' WHERE site_id_555=999 AND id=".$id);
$pakUpdate		= $db->query("UPDATE upaketler_19541956 SET danisman_onecikar_use='1' WHERE site_id_555=999 AND id=".$paket->id);

}else{
$fonk->yonlendir("danisman-one-cikar?id=".$id);
die();
}
}
}


$fonk->yonlendir("eklenen-danismanlar",1);
?>
<script type="text/javascript">
$(function(){
$("#RoketButon<?=$id;?>").hide(500);
});
</script>
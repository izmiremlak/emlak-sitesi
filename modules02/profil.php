<?php if(!defined("THEME_DIR")){die();}
$how		= $gvn->harf_rakam($_GET["how"]);
$on			= $gvn->harf($_GET["on"]);
if(is_numeric($how)){
$kontrol	= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=? AND durum=0");
$kontrol->execute(array($how));
}else{
$kontrol	= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND nick_adi=? AND durum=0");
$kontrol->execute(array($how));
}

if($kontrol->rowCount()>0){
$profil		= $kontrol->fetch(PDO::FETCH_OBJ);
}else{
include "404.php";
die();
}
$name		= $profil->adi." ".$profil->soyadi;
$avatar	= ($profil->avatar == '' OR $profil->avatard==1) ? 'https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' :'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/'.$profil->avatar;
$uturu	= explode(",",dil("UYELIK_TURLERI"));

$uyelink				= SITE_URL."profil/";
$uyelink				.= ($profil->nick_adi == '') ? $profil->id : $profil->nick_adi;


$name	= ($profil->unvan != '') ? $profil->unvan : $profil->adi." ".$profil->soyadi;


if($profil->turu==1){
$danismanlari	= $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND turu=2 AND durum=0 AND kid=".$profil->id)->rowCount();
$maps			= $profil->maps;
$adres			= $profil->adres;

if($profil->il_id != 0){
$ili		= $db->prepare("SELECT il_adi FROM il WHERE id=?");
$ili->execute(array($profil->il_id));
if($ili->rowCount()>0){
$il_adi		= $ili->fetch(PDO::FETCH_OBJ)->il_adi;
}
}

if($profil->ilce_id != 0){
$ilcei		= $db->prepare("SELECT ilce_adi FROM ilce WHERE id=?");
$ilcei->execute(array($profil->ilce_id));
if($ilcei->rowCount()>0){
$ilce_adi	= $ilcei->fetch(PDO::FETCH_OBJ)->ilce_adi;
}
}

if($profil->mahalle_id != 0){
$mahallei	= $db->prepare("SELECT mahalle_adi FROM mahalle_koy WHERE id=?");
$mahallei->execute(array($profil->mahalle_id));
if($mahallei->rowCount()>0){
$mahalle_adi= $mahallei->fetch(PDO::FETCH_OBJ)->mahalle_adi;
}
}

}elseif($profil->turu == 2){
$kurumsal		= $db->prepare("SELECT id,maps,il_id,ilce_id,mahalle_id,adres,unvan,nick_adi FROM hesaplar WHERE site_id_555=999 AND id=?");
$kurumsal->execute(array($profil->kid));
if($kurumsal->rowCount()>0){
$kurumsal		= $kurumsal->fetch(PDO::FETCH_OBJ);

$maps			= $kurumsal->maps;
$adres			= $kurumsal->adres;

if($kurumsal->il_id != 0){
$ili		= $db->prepare("SELECT il_adi FROM il WHERE id=?");
$ili->execute(array($kurumsal->il_id));
if($ili->rowCount()>0){
$il_adi		= $ili->fetch(PDO::FETCH_OBJ)->il_adi;
}
}

if($kurumsal->ilce_id != 0){
$ilcei		= $db->prepare("SELECT ilce_adi FROM ilce WHERE id=?");
$ilcei->execute(array($kurumsal->ilce_id));
if($ilcei->rowCount()>0){
$ilce_adi	= $ilcei->fetch(PDO::FETCH_OBJ)->ilce_adi;
}
}

if($kurumsal->mahalle_id != 0){
$mahallei	= $db->prepare("SELECT mahalle_adi FROM mahalle_koy WHERE id=?");
$mahallei->execute(array($kurumsal->mahalle_id));
if($mahallei->rowCount()>0){
$mahalle_adi= $mahallei->fetch(PDO::FETCH_OBJ)->mahalle_adi;
}
}


}
}

if($profil->turu == 1 || $profil->turu == 2){
include THEME_DIR."profil_kurumsal.php";
}else{
include THEME_DIR."profil_bireysel.php";
}
<?php if(!defined("SERVER_HOST")){die();}


if(strlen($uid)>11){
$uid	= 0;
}

if($uid == $bid){
$uid	= 0;
}



if($uid!=0 AND $uid != $bid){
$uyeKontrol		= $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=?");
$uyeKontrol->execute(array($uid));
if($uyeKontrol->rowCount()>0){
$uye			= $uyeKontrol->fetch(PDO::FETCH_OBJ);
$uyavatar		= ($uye->avatar == '' OR $uye->avatard==1) ? 'uploads/default-avatar.png' : 'uploads/thumb/'.$uye->avatar;
$uyturu			= $uturu[$uye->turu];

$uyadsoyad		= $uye->adi;
$uyadsoyad		.= ($uye->soyadi != '') ? ' '.$uye->soyadi : '';
$uyadsoyad		= ($uye->unvan != '') ? $uye->unvan : $uyadsoyad;

$uyeProLink		= "profil/";
$uyeProLink		.= ($uye->nick_adi == '') ? $uye->id : $uye->nick_adi;

$KarsiEngel		= 0; // Karşı Taraf Engeli
$BenEngel		= 0; // Benim Taraf Engeli
$ilkSohbet		= 1; // İlk kez bir biriyle sohbet edeceklerse
$isileti		= 0; // iletisi var mı 0 yok 1 var.

// Karşı Taraf Engellemişmi Kontrol Ediyoruz...
$kEngelKont		= $db->prepare("SELECT id,tarih FROM engelli_kisiler_19541956 WHERE kim=? AND kimi=?");
$kEngelKont->execute(array($uid,$bid));
if($kEngelKont->rowCount()>0){
$KarsiEngel		= 1;
}

// Benim Taraf Engelledim mi Kontrol Ediyoruz...
$bEngelKont		= $db->prepare("SELECT id,tarih FROM engelli_kisiler_19541956 WHERE kim=? AND kimi=?");
$bEngelKont->execute(array($bid,$uid));
if($bEngelKont->rowCount()>0){
$BenEngel		= 1;
}

// Yeni mi mesajlaşacaklar onu kontrol ediyoruz...
/*
Eğer yeni mesajlaşacaksalar görüşmeyi sil butonu display:none olması gerekiyor...
*/
$MesajLine 	= $db->prepare("SELECT * FROM mesajlar_19541956 WHERE (kimden=:bana AND kime=:ona) OR (kimden=:ona AND kime=:bana)");
$MesajLine->execute(array('bana' => $bid, 'ona' => $uid));
if($MesajLine->rowCount()>0){
$MesajLine	= $MesajLine->fetch(PDO::FETCH_OBJ);
$ilkSohbet	= 0;

$mesajiler	= $db->query("SELECT DISTINCT mi.id FROM mesaj_iletiler_19541956 AS mi INNER JOIN mesajlar_19541956 AS mr ON mi.mid=mr.id WHERE mi.mid=".$MesajLine->id." AND ((mi.asil=0 AND mr.kime=".$bid.") OR (mi.gsil=0 AND mr.kimden=".$bid.")) LIMIT 0,1");
if($mesajiler->rowCount()>0){
$isileti	= 1;
}

}


// Bildirim bolonunu güncelliyoruz...
if($ilkSohbet==0){
$db->query("UPDATE mesaj_iletiler_19541956 SET durum='1' WHERE mid=".$MesajLine->id." AND gid!=".$bid." AND durum=0");
}


}else{
$uid			= 0;
}
}
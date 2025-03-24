<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type:application/json; Charset=utf-8");
if($hesap->id != ''){
$bid		= $hesap->id;
$bildirim	= 0;
$data	= array('bildirim' => $bildirim);

if($gayarlar->anlik_sohbet==1){
try{
$kisilerListe	= $db->prepare("SELECT DISTINCT mr.id FROM mesajlar_19541956 AS mr INNER JOIN mesaj_iletiler_19541956 AS mi ON mi.mid = mr.id WHERE (mr.kimden=:idim OR mr.kime=:idim) AND ( (mr.kime=:idim AND mi.asil=0) OR (mr.kimden=:idim AND mi.gsil=0))");
$kisilerListe->execute(array('idim' => $bid));
}catch(PDOException $e){
die($e->getMessage());
}

while($row  = $kisilerListe->fetch(PDO::FETCH_OBJ)){
$bsayi		= $db->query("SELECT COUNT(id) AS kac FROM mesaj_iletiler_19541956 WHERE mid=".$row->id." AND gid!=".$bid." AND durum=0")->fetch(PDO::FETCH_OBJ)->kac;
$bildirim	+=$bsayi;
}

$data['bildirim'] = $bildirim;
}


echo json_encode($data);
}
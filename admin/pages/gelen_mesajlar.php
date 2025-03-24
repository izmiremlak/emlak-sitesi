<?php header("Content-Type:application/json; Charset=utf8");
if($hesap->id != ""){
$data		= array();

$sorgu		= $db->query("SELECT * FROM mail_19541956 ORDER BY durum ASC, tarih DESC ");
while($msg	= $sorgu->fetch(PDO::FETCH_OBJ)){

$data['data'] 	= array(
'<div class="checkbox checkbox-primary"><input name="id[]" id="check'.$msg->id.'" type="checkbox"><label for="check'.$msg->id.'"></label></div>',
'<a href="#"><i class="fa fa-circle text-info m-r-15"></i>'.$msg->adsoyad.'</a>',
$msg->telefon,
$msg->email,
$msg->tarih,
'Kontrol Code',
);

}

echo json_encode($data);
}
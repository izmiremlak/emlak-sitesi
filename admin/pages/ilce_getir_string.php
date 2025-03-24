<?php
$il			= $gvn->html_temizle($_GET["il_adi"]);

?><option value="">İlçe</option><?

if($il == ''){
die(); exit;
}


$kontrol	= $db->prepare("SELECT * FROM il WHERE il_adi=?");
$kontrol->execute(array($il));

if($kontrol->rowCount() < 1){
die(); exit;
}
$il			= $kontrol->fetch(PDO::FETCH_OBJ);


$ilceler	= $db->query("SELECT * FROM ilce WHERE il_id=".$il->id." ORDER BY ilce_adi ASC");
while($row	= $ilceler->fetch(PDO::FETCH_OBJ)){
?><option><?=$row->ilce_adi;?></option><?
}
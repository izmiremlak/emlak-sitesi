<?php
$il			= $gvn->rakam($_GET["il_id"]);
$varsa		= $gvn->zrakam($_GET["varsa"]);

?><option value=""><?=dil("TX56");?></option><?

if($il == ''){
die(); exit;
}


$kontrol	= $db->prepare("SELECT * FROM il WHERE id=?");
$kontrol->execute(array($il));

if($kontrol->rowCount() < 1){
die(); exit;
}
$il			= $kontrol->fetch(PDO::FETCH_OBJ);


$ilceler	= $db->query("SELECT * FROM ilce WHERE il_id=".$il->id." ORDER BY ilce_adi ASC");

while($row	= $ilceler->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>"><?=$row->ilce_adi;?></option><?
}
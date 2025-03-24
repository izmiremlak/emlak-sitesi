<?php
$ilce		= $gvn->rakam($_GET["ilce_id"]);
$varsa		= $gvn->zrakam($_GET["varsa"]);

?><option value=""><?=dil("TX266");?></option><?

if($ilce == ''){
die(); exit;
}


$kontrol	= $db->prepare("SELECT * FROM ilce WHERE id=?");
$kontrol->execute(array($ilce));

if($kontrol->rowCount() < 1){
die(); exit;
}
$ilce		= $kontrol->fetch(PDO::FETCH_OBJ);
$semtler	= $db->query("SELECT * FROM semt WHERE ilce_id=".$ilce->id." ORDER BY semt_adi ASC");

if($semtler->rowCount()>0){
while($srow	= $semtler->fetch(PDO::FETCH_OBJ)){
$mahalleler	= $db->query("SELECT * FROM mahalle_koy WHERE semt_id=".$srow->id." AND ilce_id=".$ilce->id." ORDER BY mahalle_adi ASC");
if($mahalleler->rowCount()>0){
?><optgroup label="<?=$srow->semt_adi;?>"><?
while($row	= $mahalleler->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>"><?=$row->mahalle_adi;?></option><?
}
}
?></optgroup><?
}
}else{
$mahalleler	= $db->query("SELECT * FROM mahalle_koy WHERE ilce_id=".$ilce->id." ORDER BY mahalle_adi ASC");
while($row	= $mahalleler->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>"><?=$row->mahalle_adi;?></option><?
}
}

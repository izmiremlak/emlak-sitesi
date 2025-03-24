<?php
$ulke_id		= $gvn->rakam($_GET["ulke_id"]);

?><option value=""><?=dil('TX264');?></option><?

if($ulke_id == ''){
die(); exit;
}


$kontrol	= $db->prepare("SELECT * FROM ulkeler_19541956 WHERE id=?");
$kontrol->execute(array($ulke_id));

if($kontrol->rowCount() < 1){
die(); exit;
}
$ulke		= $kontrol->fetch(PDO::FETCH_OBJ);


$iller		= $db->query("SELECT * FROM il WHERE ulke_id=".$ulke->id." ORDER BY il_adi ASC");
while($row	= $iller->fetch(PDO::FETCH_OBJ)){
?><option value="<?=$row->id;?>"><?=$row->il_adi;?></option><?
}
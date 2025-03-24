<?php
if($hesap->id == ''){
die();
}
$id				= $gvn->rakam($_GET["id"]);

$kontrol		= $db->prepare("SELECT id FROM favoriler_19541956 WHERE id=? AND acid=? ");
$kontrol->execute(array($id,$hesap->id));

if($kontrol->rowCount()==0){
die();
}
$favori			= $kontrol->fetch(PDO::FETCH_OBJ);





$db->query("DELETE FROM favoriler_19541956 WHERE id=".$id);

?>
<script type="text/javascript">
$(function(){
$("#row_<?=$id;?>").css({"background-color" : '#EFCFCF'});
 $("#row_<?=$id;?>").animate({opacity : 0.1},1000,function(){
 $("#row_<?=$id;?>").fadeOut(100);
 });
});
</script>
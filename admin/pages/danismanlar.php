<?php
if($hesap->id != "" AND $hesap->tipi != 0){

$sil			= $gvn->rakam($_GET["sil"]);
if($sil != ""){
$db->query("DELETE FROM danismanlar_19541956 WHERE id=".$sil." ");
}
$id				= $sil;

?>
<script type="text/javascript">
$(document).ready(function(){
$("#danisman<?=$id;?>").fadeOut(500,function(){
$("#danisman<?=$id;?>").remove();
});
});
</script>
<?
$fonk->ajax_tamam("Danışman Silindi");
}
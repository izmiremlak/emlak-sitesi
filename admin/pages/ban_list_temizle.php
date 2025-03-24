<?php
if($hesap->id != "" AND $hesap->tipi != 0){

try{
$gunc		= $db->query("DELETE FROM sgonderiler_19541956");
}catch(PDOException $e){
die($e->getMessage());
}

$fonk->ajax_tamam("Başarılı bir şekilde temizlendi.");

}
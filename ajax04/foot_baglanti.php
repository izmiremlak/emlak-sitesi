<?php
if($_POST){
if($hesap->id != "" AND $hesap->tipi != 0){

$foot_link1			= $gvn->html_temizle($_POST["foot_link1"]);
$foot_link2			= $gvn->html_temizle($_POST["foot_link2"]);
$foot_link3			= $gvn->html_temizle($_POST["foot_link3"]);
$foot_link4			= $gvn->html_temizle($_POST["foot_link4"]);
$foot_link5			= $gvn->html_temizle($_POST["foot_link5"]);
$foot_link6			= $gvn->html_temizle($_POST["foot_link6"]);
$foot_link7			= $gvn->html_temizle($_POST["foot_link7"]);

$foot_text1			= $gvn->html_temizle($_POST["foot_text1"]);
$foot_text2			= $gvn->html_temizle($_POST["foot_text2"]);
$foot_text3			= $gvn->html_temizle($_POST["foot_text3"]);
$foot_text4			= $gvn->html_temizle($_POST["foot_text4"]);
$foot_text5			= $gvn->html_temizle($_POST["foot_text5"]);
$foot_text6			= $gvn->html_temizle($_POST["foot_text6"]);
$foot_text7			= $gvn->html_temizle($_POST["foot_text7"]);


$foot_sayfa1			= $gvn->zrakam($_POST["foot_sayfa1"]);
$foot_sayfa2			= $gvn->zrakam($_POST["foot_sayfa2"]);
$foot_sayfa3			= $gvn->zrakam($_POST["foot_sayfa3"]);
$foot_sayfa4			= $gvn->zrakam($_POST["foot_sayfa4"]);
$foot_sayfa5			= $gvn->zrakam($_POST["foot_sayfa5"]);
$foot_sayfa6			= $gvn->zrakam($_POST["foot_sayfa6"]);
$foot_sayfa7			= $gvn->zrakam($_POST["foot_sayfa7"]);




$guncelle = $db->prepare("UPDATE ayarlar_19541956 SET foot_link1=?,foot_link2=?,foot_link3=?,foot_link4=?,foot_link5=?,foot_link6=?,foot_link7=?,foot_text1=?,foot_text2=?,foot_text3=?,foot_text4=?,foot_text5=?,foot_text6=?,foot_text7=?,foot_sayfa1=?,foot_sayfa2=?,foot_sayfa3=?,foot_sayfa4=?,foot_sayfa5=?,foot_sayfa6=?,foot_sayfa7=? WHERE dil='".$dil."'");
$guncelle->execute(array($foot_link1,$foot_link2,$foot_link3,$foot_link4,$foot_link5,$foot_link6,$foot_link7,$foot_text1,$foot_text2,$foot_text3,$foot_text4,$foot_text5,$foot_text6,$foot_text7,$foot_sayfa1,$foot_sayfa2,$foot_sayfa3,$foot_sayfa4,$foot_sayfa5,$foot_sayfa6,$foot_sayfa7));


if($guncelle){
$fonk->ajax_tamam("Bilgiler Güncellendi. ");
}else{
$fonk->ajax_hata("Bir Hata Oluştu!");
}



}
}
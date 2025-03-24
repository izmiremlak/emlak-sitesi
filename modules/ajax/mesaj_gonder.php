<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($gayarlar->anlik_sohbet == 0){
die();
}

$bid	  = $hesap->id;
$basd	  = $hesap->adi." ".$hesap->soyadi;
$uid	  = $gvn->zrakam($_GET["uid"]);
$mesaj  = $_POST["mesaj"];
$ilink	= $gvn->mesaj(htmlspecialchars($_POST["ilan_linki"],ENT_QUOTES));
$mesaj  .= "\n\n".dil("ILAN_LINKI").": ".$ilink;
$mesaj	= $gvn->mesaj(htmlspecialchars($mesaj,ENT_QUOTES));
$tarih	= $fonk->datetime();
$ipi	= $fonk->IpAdresi();
$from	= $gvn->harf($_GET["from"]);

include "methods/chat.lib.php";

if($uid == 0){
die('<span class="error">'.dil("TX409").'</span>');
}

if($KarsiEngel==1 || $BenEngel==1){
die('<span class="error">'.dil("TX410").'</span>');
}


if($fonk->bosluk_kontrol($mesaj)==true){
die();
}


if($ilkSohbet==1){
try{
$MesajLineOlustur	= $db->prepare("INSERT INTO mesajlar_19541956 SET kimden=?,kime=?,tarih=?,starih=?");
$MesajLineOlustur->execute(array($bid,$uid,$tarih,$tarih));
}catch(PDOException $e){
die($e->getMessage());
}
$mid		= $db->lastInsertId();
$MesajLine 	= $db->prepare("SELECT * FROM mesajlar_19541956 WHERE id=?");
$MesajLine->execute(array($mid));
if($MesajLine->rowCount()>0){
$MesajLine	= $MesajLine->fetch(PDO::FETCH_OBJ);
$ilkSohbet	= 0;
}
}



try{
$iletiGonder	= $db->prepare("INSERT INTO mesaj_iletiler_19541956 SET mid=?,gid=?,ileti=?,tarih=?,ip=?");
$iletiGonder->execute(array($MesajLine->id,$bid,$mesaj,$tarih,$ipi));
}catch(PDOException $e){
die($e->getMessage());
}
$db->query("UPDATE mesajlar_19541956 SET starih='".$tarih."' WHERE id=".$MesajLine->id);

if($from == ''){?>
<script type="text/javascript">
$("#MesajYaz").val('');
ArayuzYukle();
</script><?
}elseif($from == "adv"){

$adsoyad		= $hesap->adi;
$adsoyad		.= ($hesap->soyadi != '') ? ' '.$hesap->soyadi : '';
$adsoyad		= ($hesap->unvan != '') ? $hesap->unvan : $adsoyad;
$uyebm			= $gvn->rakam($_COOKIE["uyebm"]);
if($uyebm == '' || $uyebm != $uid){
// admin eposta text
$aetxt = '
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" style="border-bottom-width: 1px;border-bottom-style: dotted;border-bottom-color: #CCC;padding:3px;" scope="col"><h3 style="font-size:20px; font-family:Calibri, Helvetica, sans-serif; color:#D4701A; font-weight:bold;"><img src="'.SITE_URL.'uploads/thumb/'.$gayarlar->logo.'" /></h3>
    <h3 style="font-size:20px; font-family:Calibri, Helvetica, sans-serif; color:#00599D; font-weight:bold;">Bilgilendirme</h3></td>
  </tr>
  <tr>
    <td style="border-bottom-width: 1px;border-bottom-style: dotted;border-bottom-color: #CCC;padding:3px;" scope="col"><p><span style="font-size:14px; font-family:Calibri, Helvetica, sans-serif; color:#D4701A; font-weight:bold;"><br>
      Sn. '.$uyadsoyad.',</span><br>
        <br>
      <span style="font-size:14px; font-family:Calibri, Helvetica, sans-serif;">Bir kullanıcımız size  mesaj gönderdi. Detaylı bilgi ve mesajı yanıtlamak için üye panelinizin &quot;Mesajlarım&quot; bölümünü ziyaret edebilirsiniz.</span></p>
      <p><strong><span style="font-family: Calibri, Helvetica, sans-serif; font-size: 14px; color: #D4701A">Detaylar;<br>
        ----------------------------
        </span></strong><span style="font-family: Calibri, Helvetica, sans-serif; font-size: 14px"><br>
        Adı Soyadı: 
        '.$adsoyad.'<br>
        Telefon: 
        '.$hesap->telefon.'<br>
        E-Posta: '.$hesap->email.'<br>
        <br>
        Mesajı: 
'.$mesaj.'<br>
<br>
<strong><span style="font-family: Calibri, Helvetica, sans-serif; font-size: 14px; color: #D4701A">---------------------------- </span></strong></span></p>
      <p><span style="font-size:14px; font-family:Calibri, Helvetica, sans-serif;">İyi Çalışmalar,<br>
        www.'.str_replace("www.","",$_SERVER["SERVER_NAME"]).' <br>
      </span></p>
    </td>
  </tr>
</table>
';
$aegonder			= $fonk->mail_gonder('Mesajınız var.',$uye->email,$aetxt);
if($aegonder){
setcookie("uyebm",$uid,time()+60*5);
}
}

?>
<script>
$("#MesajGonderForm").slideUp(500,function(){
$("#TamamPnc").slideDown(500);
});
</script>
<?
}


<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
header("Content-Type:application/json; Charset=utf-8");

if($gayarlar->anlik_sohbet==0){
die();
}

function link_convert($value,$noreferer=false)
        {
            $protocols = array('http', 'mail');
            $attributes = array();

            $attributes["target"] = "_blank";

            if($noreferer){
                $attributes["referrerpolicy"] = "no-referrer";
            }

            // Link attributes
            $attr = '';
            foreach ($attributes as $key => $val) {
                $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
            }

            $links = array();

            // Extract existing links and tags
            $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);

            // Extract text links for each protocol
            foreach ((array)$protocols as $protocol) {
                switch ($protocol) {
                    case 'http':
                    case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
                    case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
                    case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
                    default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
                }
            }

            // Insert all link
            return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}

$uturu		= explode(",",dil("UYELIK_TURLERI"));
$bid		= $hesap->id;
$basd		= dil("TX422");
$bildirim	= 0;
$uid	= $gvn->zrakam($_GET["uid"]);
$ara	= $gvn->html_temizle($_GET["arama"]);
$data	= array(
'kisiler',
'sohbet',
'bildirim' => $bildirim
);

include "methods/chat.lib.php";

// Sol taraf kişi listesi
if($fonk->bosluk_kontrol($ara)==true){ // Eğer arama olmuyorsa...
try{
$kisilerListe	= $db->prepare("SELECT DISTINCT mr.* FROM mesajlar_19541956 AS mr INNER JOIN mesaj_iletiler_19541956 AS mi ON mi.mid = mr.id WHERE (mr.kimden=:idim OR mr.kime=:idim) AND ( (mr.kime=:idim AND mi.asil=0) OR (mr.kimden=:idim AND mi.gsil=0)) ORDER BY mr.starih ASC");
$kisilerListe->execute(array('idim' => $bid));
}catch(PDOException $e){
die($e->getMessage());
}


$say		= $kisilerListe->rowCount();
// Kişileri döngüye alıyoruz...
while($row  = $kisilerListe->fetch(PDO::FETCH_OBJ)){
$say		-=1;
$acid		= ($row->kimden != $bid) ? $row->kimden : 0;
$acid		= ($row->kime != $bid) ? $row->kime : $acid;
$account	= $db->query("SELECT id,adi,soyadi,avatar,avatard,unvan FROM hesaplar WHERE site_id_555=999 AND id=".$acid)->fetch(PDO::FETCH_OBJ);
$avatar		= ($account->avatar == '' OR $account->avatard==1) ? 'uploads/default-avatar.png' : 'uploads/thumb/'.$account->avatar;
$adsoyad	= ($account->unvan != '') ? $account->unvan : $account->adi." ".$account->soyadi;

$bsayi		= $db->query("SELECT COUNT(id) AS kac FROM mesaj_iletiler_19541956 WHERE mid=".$row->id." AND gid!=".$bid." AND durum=0")->fetch(PDO::FETCH_OBJ)->kac;
$bildirim	+=$bsayi;

$mesaji		= $db->query("SELECT ileti FROM mesaj_iletiler_19541956 WHERE mid=".$row->id." ORDER BY id DESC LIMIT 0,1")->fetch(PDO::FETCH_OBJ)->ileti;
$mesaji		= str_replace(array("\n","<br />"),"",$mesaji);

$counter	= ($bsayi>0) ? '<span class="msjvar">'.$bsayi.'</span>' : '';
$aktifet	= ($uid == $account->id) ? ' id="mesajkisiaktif"' : '';
$active		= ($uid == $account->id) ? 'mesajkisiaktif' : '';
$mesaj 		= $fonk->kisalt($mesaji,0,63);
$mesaj		.= (strlen($mesaji)>63) ? '...' : '';
$data['kisiler']['k'.$acid] = array(
'active' => $active,
'sira' => $say,
'icerik' => '<a href="javascript:;" id="k'.$acid.'" onclick="SohbetGoster('.$acid.');">
<div class="mesajkisi"'.$aktifet.'>
'.$counter.'
<img src="'.$avatar.'" width="50" height="50" alt="">
<div class="mesajkisiinfo">
<h4>'.$adsoyad.'</h4>
<p>'.$mesaj.'</p>
</div>
</div></a>');
}
$data['bildirim'] = $bildirim;
} // Eğer arama olmuyorsa...

if($fonk->bosluk_kontrol($ara)==false){ // Eğer varsa arama isteği

try{

$adsoyad			= $ara;
$ayr				= @explode(" ",$adsoyad);
$soyadi				= end($ayr);
array_pop($ayr);
$adi				= implode(" ",$ayr);


$kisilerListe	= $db->prepare("SELECT id,adi,soyadi,avatar,avatard,tipi,unvan FROM hesaplar WHERE site_id_555=999 AND (tipi=0 AND adi LIKE :adi AND soyadi LIKE :soyadi) OR (tipi=0 AND adi LIKE :ara OR soyadi LIKE :ara OR email LIKE :ara OR unvan LIKE :ara) ORDER BY adi DESC");
$kisilerListe->execute(array('adi' => "%".$adi."%",'soyadi' => "%".$soyadi."%",'ara' => "%".$ara."%"));
}catch(PDOException $e){
die($e->getMessage());
}

// Kişileri döngüye alıyoruz...
while($row  = $kisilerListe->fetch(PDO::FETCH_OBJ)){
if($row->tipi==0 AND $row->id != $hesap->id){
$account	= $row;
$avatar		= ($account->avatar == '' OR $account->avatard==1) ? 'uploads/default-avatar.png' : 'uploads/thumb/'.$account->avatar;
$adsoyad	= ($account->unvan != '') ? $account->unvan : $account->adi." ".$account->soyadi;
$acid		= $account->id;

$aktifet	= ($uid == $acid) ? ' id="mesajkisiaktif"' : '';
$data['kisiler']['k'.$row->id] = array(
'icerik' => '<a href="javascript:;" id="k'.$acid.'" onclick="SohbetGoster('.$acid.');">
<div class="mesajkisi"'.$aktifet.'>
<img src="'.$avatar.'" width="50" height="50" alt="">
<div class="mesajkisiinfo">
<h4>'.$adsoyad.'</h4>
</div>
</div></a>');
}
}


} // Eğer varsa arama isteği


if($uid!=0){ // Eğer üye seçmişse...

$data['sohbet']['avatar'] = $uyavatar; // avatar resimi degisecek.
$data['sohbet']['adsoyad'] = $uyadsoyad; // adı soyadı degisecek
$data['sohbet']['uyeturu'] = '('.$uyturu.' '.dil("TX384").')'; // uye turu degisecek
$data['sohbet']['uyeprolink'] = $uyeProLink; // profil linki değişecek
$data['sohbet']['engelbutonu'] = ($KarsiEngel == 1) ? 1 : 0; // 1 ise display none olacak
$data['sohbet']['benEngel'] = ($BenEngel == 1) ? 1 : 0; // 1 ise engeli kaldır 0 ise engelle
$data['sohbet']['grsmesilbuton'] = ($isileti==0) ? 1 : 0; // 1 ise display none olacak

// Iletileri Yükleyelim...
if($ilkSohbet==0){ // Daha önce sohbet etmişlerse çekelim...

$miletiler = $db->query("SELECT DISTINCT mi.* FROM mesaj_iletiler_19541956 AS mi INNER JOIN mesajlar_19541956 AS mr ON mi.mid=mr.id WHERE mi.mid=".$MesajLine->id." AND ((mi.asil=0 AND mr.kime=".$bid.") OR (mi.gsil=0 AND mr.kimden=".$bid.")) ORDER BY id ASC");
while($row	   	= $miletiler->fetch(PDO::FETCH_OBJ)){
$benyazdm 	   	= ($row->gid == $bid) ? " bnmmsjim" : '';
$asne		   	= ($row->gid == $bid) ? $basd : $uyadsoyad;
$gormedurum		= ($row->gid == $bid AND $row->durum==1) ? '<i title="'.dil("TX411").'" style="font-size:16px;color:blue" class="ion-android-done-all"></i>' : '';
$tarih			= date("d.m.Y - H:i",strtotime($row->tarih));
$data["sohbet"]["iletiler"]["ileti".$row->id] = '<div class="msjbaloncuk'.$benyazdm.'" id="ileti'.$row->id.'">
'.link_convert($row->ileti).'
<h5><strong>'.$asne.'</strong> / ('.$tarih.') '.$gormedurum.'</h5>
</div>';
}
} // Daha önce sohbet etmişlerse çekelim...
} // Eğer üye seçmişse...



echo json_encode($data);
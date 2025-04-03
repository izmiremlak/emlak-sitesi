<?php
// Hata yönetimi için ayarları yapılandır
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error_log.txt'); // Hata log dosyasının yolu
error_reporting(E_ALL); // Tüm hataları raporla

// Hataları sitede göster
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red;'><b>Hata:</b> [$errno] $errstr - $errfile:$errline</div>";
    return true;
}
set_error_handler("customErrorHandler");

// Kullanıcı giriş kontrolü
if ($hesap->id == '') {
    die();
}

// POST verisi kontrolü
if (!$_POST) {
    die();
}

$id = $gvn->rakam($_GET["id"]);
$ipi = $fonk->IpAdresi();
$mesaj = $gvn->mesaj(htmlspecialchars($_POST["mesaj"], ENT_QUOTES));

// Mesajın boş olup olmadığını ve uzunluğunu kontrol et
if ($fonk->bosluk_kontrol($mesaj) == true && strlen($mesaj) < 5) {
    die('<span class="error">' . dil("TX448") . '</span>');
}

// İlan bilgilerini kontrol et
$kontrol = $db->prepare("SELECT id, url, baslik FROM sayfalar WHERE site_id_555=999 AND id=? AND tipi=4");
$kontrol->execute(array($id));

if ($kontrol->rowCount() == 0) {
    die();
}
$ilan = $kontrol->fetch(PDO::FETCH_OBJ);
$ilan_linki = ($dayarlar->permalink == 'Evet') ? SITE_URL . $ilan->url . ".html" : SITE_URL . "index.php?p=sayfa&id=" . $ilan->id;
$customs = array();

$customs["acid"] = $hesap->id;
$customs["ilan_id"] = $ilan->id;

// Son 10 dakika içinde aynı kullanıcı tarafından aynı ilan için hata bildirimi yapılmış mı kontrol et
$like1 = '"acid":' . $hesap->id . ',';
$like2 = '"ilan_id":' . $ilan->id;
$varmi = $db->prepare("SELECT * FROM mail_19541956 WHERE tipi=1 AND customs LIKE ? AND customs LIKE ? AND ip=? AND tarih BETWEEN DATE_SUB(NOW(), INTERVAL 10 MINUTE) AND NOW()");
$varmi->execute(array('%' . $like1 . '%', '%' . $like2 . '%', $ipi));
if ($varmi->rowCount() > 0) {
    die(dil("TX435"));
}

$customs = $fonk->json_encode_tr($customs);
if ($hesap->unvan != '') {
    $adsoyad = $hesap->unvan;
} else {
    $adsoyad = $hesap->adi;
    $adsoyad .= ($hesap->soyadi == '') ? '' : ' ' . $hesap->soyadi;
}

// Hata bildirimi ekle
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    $ekle = $db->prepare("INSERT INTO mail_19541956 SET tipi=?, adsoyad=?, email=?, telefon=?, tarih=?, mesaj=?, ip=?, customs=?");
    $ekle->execute(array(1, $adsoyad, $hesap->email, $hesap->telefon, $fonk->datetime(), $mesaj, $ipi, $customs));
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
<script type="text/javascript">
$("#HataliBildirForm").slideUp(500, function(){
    $("#BiTamamPnc").slideDown(500);
});
</script>
<?php
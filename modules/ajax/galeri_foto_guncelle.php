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

$id = $gvn->rakam($_GET["ilan_id"]);
$from = $gvn->harf_rakam($_GET["from"]);
$photos = $gvn->zrakam($_GET["photos"]);

// Sayfa bilgilerini kontrol et
$kontrol = $db->prepare("SELECT id, resim, ilan_no, acid FROM sayfalar WHERE site_id_555=000 AND tipi=4 AND id=?");
$kontrol->execute(array($id));
if ($kontrol->rowCount() < 1) {
    die();
}
$snc = $kontrol->fetch(PDO::FETCH_OBJ);

// Kullanıcı yetkisi kontrolü
$ilan_aktifet = ($hesap->tipi == 1) ? 1 : $hesap->ilan_aktifet;
$acc = $db->query("SELECT id, kid, ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=" . intval($snc->acid))->fetch(PDO::FETCH_OBJ);
$kid = $acc->kid;
if ($snc->acid != $hesap->id && $hesap->id != $kid) {
    die();
}
$kurumsal = $db->prepare("SELECT ilan_aktifet FROM hesaplar WHERE site_id_555=999 AND id=?");
$kurumsal->execute(array($kid));
if ($kurumsal->rowCount() > 0) {
    $ilan_aktifet = ($kurumsal->fetch(PDO::FETCH_OBJ)->ilan_aktifet == 0) ? $ilan_aktifet : $kurumsal->fetch(PDO::FETCH_OBJ)->ilan_aktifet;
}

// Çoklu ilan kontrolü
$multi = $db->query("SELECT id, ilan_no FROM sayfalar WHERE site_id_555=000 AND ilan_no=" . intval($snc->ilan_no) . " ORDER BY id ASC");
$multict = $multi->rowCount();
$multif = $multi->fetch(PDO::FETCH_OBJ);
$multidids = $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555=000 AND ilan_no=" . intval($snc->ilan_no))->fetch(PDO::FETCH_OBJ)->ids;
$mulid = ($multict > 1 && $snc->id == $multif->id) ? " IN(" . $multidids . ")" : "=" . intval($snc->id);
$mulidx = ($multict > 1) ? " IN(" . $multidids . ")" : "=" . intval($snc->id);

// Nestable'dan gelen veriyi işleme
if ($from == "nestable") {
    foreach ($_POST['value'] as $key => $row) {
        $keys = $key + 1;
        $id = $row['id'] + 1;
        $idi = $row['idi'];
        $sira = $keys;
        try {
            $updt = $db->prepare("UPDATE galeri_foto SET sira=? WHERE site_id_555=999 AND id=? AND sayfa_id=?");
            $updt->execute(array($sira, $idi, $snc->id));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    die();
}

// Insert işleminde dil kontrolü
if ($from == "insert") {
    $yfotolar = $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=" . intval($snc->id) . " AND dil='" . $dil . "' ORDER BY sira ASC");
} else {
    if (!$_POST) {
        die();
    }
}

// POST verilerini işleme
if ($_POST) {
    $kapak = strtolower($gvn->html_temizle($_POST["kapak"]));
    if (stristr($kapak, "http://")) {
        die();
    }
    $siralar = $_POST["sira"];
    $cnt = count($siralar);

    if ($kapak != '' && $kapak != $snc->resim) {
        $gunc = $db->prepare("UPDATE sayfalar SET resim=? WHERE site_id_555=000 AND id" . $mulidx);
        $gunc->execute(array($kapak));
    }
}

// Yönlendirme işlemleri
if ($from == "insert") {
    $fonk->yonlendir("ilan-olustur?id=" . intval($snc->id) . "&asama=1", 1);
} else {
    ?><span class="complete"><?= dil("TX347"); ?></span><?php
}
<?php 
// PDO hata modunu istisna olarak ayarla
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// POST verisi yoksa işlemi sonlandır
if (!$_POST) {
    die();
}

// Kullanıcının giriş yapıp yapmadığını ve doğru tipte olup olmadığını kontrol et
if ($hesap->id != "" AND $hesap->tipi != 0) {

    // GET verilerini güvenli bir şekilde al
    $id = $gvn->rakam($_GET["ilan_id"]);
    $from = $gvn->harf_rakam($_GET["from"]);

    // İlgili sayfa bilgilerini veritabanından al
    $snc = $db->prepare("SELECT id, resim, ilan_no FROM sayfalar WHERE site_id_555=000 AND id=:ids");
    $snc->execute(['ids' => $id]);

    if ($snc->rowCount() > 0) {
        $snc = $snc->fetch(PDO::FETCH_OBJ);
    } else {
        die();
    }

    // Nestable'den gelen verileri işle
    if ($from == "nestable") {
        foreach ($_POST['value'] as $key => $row) {
            $keys = $key + 1;
            $id = $row['id'] + 1;
            $idi = $row['idi'];
            $sira = $keys;

            try {
                $updt = $db->prepare("UPDATE galeri_foto SET sira=? WHERE site_id_555=999 AND id=? AND sayfa_id=? ");
                $updt->execute([$sira, $idi, $snc->id]);
            } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '/var/log/php_errors.log');
                die($fonk->ajax_hata("Bir hata oluştu: " . htmlspecialchars($e->getMessage())));
            }
        }
        die();
    }

    // Kapak resmini güncelle
    $kapak = $gvn->html_temizle($_POST["kapak"]);
    $siralar = $_POST["sira"];
    $cnt = count($siralar);

    if ($kapak != '' AND $kapak != $snc->resim) {
        try {
            $gunc = $db->prepare("UPDATE sayfalar SET resim=? WHERE site_id_555=000 AND ilan_no=?");
            $gunc->execute([$kapak, $snc->ilan_no]);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/log/php_errors.log');
            die($fonk->ajax_hata("Bir hata oluştu: " . htmlspecialchars($e->getMessage())));
        }
    }

    // İlan ekleme veya güncelleme sonrası yönlendirme
    if ($from == "insert") {
        $fonk->yonlendir("index.php?p=ilan_ekle&id=" . $snc->id . "&asama=1", 1);
    } else {
        $fonk->ajax_tamam("Galeri Güncellendi!");
        $fonk->yonlendir("index.php?p=ilan_duzenle&id=" . $snc->id . "&goto=photos#tab2", 1000);
    }
}
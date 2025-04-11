<?php

// Sunucu ana bilgisayarı tanımlı değilse çıkış yap
if (!defined("SERVER_HOST")) {
    exit;
}

// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Güvenli bir rastgele dizi oluşturma
$a0fdgkfdw9siu4zj = bin2hex(random_bytes(16));

// HTML başlangıcı ve meta dosyaları dahil
echo "<!DOCTYPE html>\n<html>\n<head>\n\n";
include THEME_DIR . "inc/anasayfa-meta.php";
echo "\n";

// Başlığın ve meta etiketlerinin dahil edilmesi
$index = true;
include THEME_DIR . "inc/head.php";
echo "\n</head>\n<body>\n\n";

// Başlık ve slider dosyalarının dahil edilmesi
include THEME_DIR . "inc/header.php";
echo "\n\n";
include THEME_DIR . "inc/slider.php";
echo "\n\n";
include THEME_DIR . "inc/anasayfa-slider-alti.php";

// Blokların dizilimi ve sıralanması
$bloklar = array();
if ($dayarlar->blok1 == 1) {
    $bloklar[$dayarlar->blok1_sira] = "blok1";
}
if ($dayarlar->blok2 == 1) {
    $bloklar[$dayarlar->blok2_sira] = "blok2";
}
if ($dayarlar->blok3 == 1) {
    $bloklar[$dayarlar->blok3_sira] = "blok3";
}
if ($dayarlar->blok4 == 1) {
    $bloklar[$dayarlar->blok4_sira] = "blok4";
}
if ($dayarlar->blok5 == 1) {
    $bloklar[$dayarlar->blok5_sira] = "blok5";
}
if ($dayarlar->blok6 == 1) {
    $bloklar[$dayarlar->blok6_sira] = "blok6";
}
if ($dayarlar->blok7 == 1) {
    $bloklar[$dayarlar->blok7_sira] = "blok7";
}
if ($dayarlar->blok8 == 1) {
    $bloklar[$dayarlar->blok8_sira] = "blok8";
}
if ($dayarlar->blok9 == 1) {
    $bloklar[$dayarlar->blok9_sira] = "blok9";
}

// Blokların sıralanması ve dahil edilmesi
ksort($bloklar);
foreach ($bloklar as $k => $v) {
    if ($v == "blok1") {
        include THEME_DIR . "inc/anasayfa-sicak-ilanlar-ve-arama.php";
    }
    if ($v == "blok2") {
        include THEME_DIR . "inc/anasayfa-haber-ve-blog.php";
    }
    if ($v == "blok3") {
        echo "<!-- blok3 start -->\n<div id=\"wrapper\">\n";
        include THEME_DIR . "inc/ilanvertanitim.php";
        echo "</div><!-- wrapper end -->\n<!-- blok3 end -->\n";
    }
    if ($v == "blok4") {
        include THEME_DIR . "inc/anasayfa-sehirler.php";
    }
    if ($v == "blok5") {
        include THEME_DIR . "inc/anasayfa-vitrin-ilanlari.php";
    }
    if ($v == "blok6") {
        include THEME_DIR . "inc/anasayfa-onecikan-ilanlar.php";
    }
    if ($v == "blok7") {
        include THEME_DIR . "inc/anasayfa-danismanlar.php";
    }
    if ($v == "blok8") {
        include THEME_DIR . "inc/anasayfa-reklam1.php";
    }
    if ($v == "blok9") {
        include THEME_DIR . "inc/anasayfa-reklam2.php";
    }
}

// Footer dosyasının dahil edilmesi
include THEME_DIR . "inc/footer.php";

// Yardımcı fonksiyon
function aa5wGBHZyWcA($a, $b)
{
    return $a . "-" . $b . "KxYxyvcT8Ha8e";
}
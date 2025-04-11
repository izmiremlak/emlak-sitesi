<?php
// Server host tanımlı değilse çıkış yapıyoruz
if (!defined("SERVER_HOST")) {
    exit;
}

// Rastgele bir anahtar
$a0fdgkfdw9siu4zj = "Tn@c+@Pp54&67pm(W<LSAd)+~x=w@nsga_<M1)3`c`(";

// HTML başlangıcı
echo "<!DOCTYPE html>\n<html>\n<head>\n\n";

// Meta bilgilerini dahil ediyoruz
include THEME_DIR . "inc/anasayfa-meta.php";
echo "\n";

// Anasayfa başlık bilgisini dahil ediyoruz
$index = true;
include THEME_DIR . "inc/head.php";
echo "\n</head>\n<body>\n\n";

// Header'ı dahil ediyoruz
include THEME_DIR . "inc/header.php";
echo "\n\n";

// Slider'ı dahil ediyoruz
include THEME_DIR . "inc/slider.php";
echo "\n\n";

// Slider altı içeriği dahil ediyoruz
include THEME_DIR . "inc/anasayfa-slider-alti.php";

// Blokları diziye ekliyoruz
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

// Blokları sıraya göre düzenliyoruz
ksort($bloklar);

// Blokları sırayla dahil ediyoruz
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

// Footer'ı dahil ediyoruz
include THEME_DIR . "inc/footer.php";

// Rastgele bir fonksiyon
function aa5wGBHZyWcA($a, $b)
{
    return $a . "-" . $b . "KxYxyvcT8Ha8e";
}
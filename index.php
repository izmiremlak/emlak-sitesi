<?php
// Gerekli fonksiyonları içe aktarır.
include "functions.php";

// İstatistik fonksiyonunu çağırır.
istatistik_fonksiyonu();

// 'www.' olmadan gelen istekleri 'www.' ile yönlendirir.
if (!str_contains($_SERVER["SERVER_NAME"], "www.") && $gayarlar->site_www == 1) {
    header('Location: http://www.' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    exit();
}

// HTTPS olmadan gelen istekleri HTTPS ile yönlendirir.
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' && $gayarlar->site_ssl == 1) {
    header('Location: https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
    exit();
}

// GET isteğinden gelen 'p' parametresini harf ve rakamlarla sınırlar.
$tp = $gvn->harf_rakam($_GET["p"]);
$p = $tp;
$pdir = THEME_DIR;

// Sayfa yönlendirmesi yapar.
if (empty($tp)) {
    include $pdir . 'index.php';
} elseif (file_exists($pdir . $tp . '.php')) {
    include $pdir . $tp . '.php';
} else {
    include "404.php";
}
?>
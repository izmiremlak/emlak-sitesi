<?php
// THEME_DIR sabitinin tanımlı olup olmadığını kontrol eder. Tanımlı değilse "Problem 404" mesajı ile sonlandırır.
if (!defined("THEME_DIR")) {
    die("Problem 404");
}

// SCRIPT_NAME sunucu değişkenini kullanarak dizin adını alır.
$dirs = dirname($_SERVER["SCRIPT_NAME"]);

// Dizin adının son karakteri '/' değilse, '/' ekler.
if (substr($dirs, -1) !== '/') {
    $dirs .= '/';
}

// 404 hata sayfasını içeri aktarır.
include "modules/404.php";
?>
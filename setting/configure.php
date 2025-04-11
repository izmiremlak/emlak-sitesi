<?php

require_once __DIR__ . "/DB.php";

// PHP sürüm kontrolü ve minimum gereksinim
$php_ver = substr(phpversion(), 0, 3);
if ($php_ver < '5.4') {
    die("Yazılım en düşük PHP 5.4 kadar desteklemektedir. Lütfen PHP versiyonunuzu yükseltin.");
}

// Domain adı kontrolü ve ayarlaması
$stadrs = str_replace("www.", "", strtolower($_SERVER["SERVER_NAME"]));
if (strstr($stadrs, "izmiremlakbirligi.com.tr")) {
    $domain2 = "izmiremlakbirligi.com.tr";
} else {
    if (!is_file(__DIR__ . "/domain.txt")) {
        touch(__DIR__ . "/domain.txt");
        file_put_contents(__DIR__ . "/domain.txt", $stadrs);
        $domain2 = $stadrs;
    } else {
        $domain2 = file_get_contents(__DIR__ . "/domain.txt");
        if ($domain2 == '') {
            file_put_contents(__DIR__ . "/domain.txt", $stadrs);
            $domain2 = $stadrs;
        }
    }
}

// Veritabanı bağlantısı
require __DIR__ . "/dbconnect.php";

/**
 * Hataları log dosyasına yazma fonksiyonu
 * @param string $message Hata mesajı
 */
function log_error($message)
{
    error_log($message, 3, __DIR__ . '/logs/error.log'); // Hata mesajını log dosyasına yaz
}

/**
 * Hata mesajlarını hem log dosyasına yaz hem de ekrana göster
 * @param string $error_message Hata mesajı
 */
function handle_error($error_message)
{
    log_error($error_message); // Log dosyasına yaz
    echo $error_message; // Ekrana göster
}

// Örnek hata işleme kullanımı
handle_error("Örnek hata mesajı.");
<?php
// Veritabanı bilgilerinizi giriniz.
define("SERVER_HOST", "localhost");
define("DB_NAME", "turkiyeemlaksitesitrdb");
define("DB_USERNAME", "turkiyeemlaksitesitrdb");
define("DB_PASSWORD", "!turkiyeTR1234turkiyeTR?");
define("DB_CHARSET", "utf8");

// PayPal Tahsilat Ayarları
$pay_secret = 'a1b2c3d4e5f6&123+&654321';  // !ÖNEMLİ! :: PayPal ödeme için gereklidir. Rastgele bir değer girin. Güvenlik için gereklidir.

// SMTP Debugger
define("SMTP_DEBUG", false); // Aktif : true Pasif : false

// Tahsilat Sonuç Sayfa Adresleri
$domain = str_replace("www.", "", strtolower($_SERVER["SERVER_NAME"]));

// HTTP veya HTTPS kontrolü
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
    $http_scheme = 'http';
} else {
    $http_scheme = 'https';
}
$www = (stristr($_SERVER["HTTP_HOST"], "www")) ? "www." : '';

// Başarılı ve başarısız ödeme URL'leri
define("PAYTR_OK_URL", $http_scheme . "://" . $www . $domain . "/odeme-tamamlandi");
define("PAYTR_FAIL_URL", $http_scheme . "://" . $www . $domain . "/odeme-basarisiz");

// PayPal ödeme sırrı
define("PAY_SECRET", md5($pay_secret));

// Ödeme Yöntemleri
$oyontemleri = array('Banka Havale/EFT', 'Kredi Kartı', 'Kredi Kartı (PAYPAL)');

// Zaman Dilimi Ayarı (Yaz saati uygulaması nedeniyle TR için aşağıdaki şekilde olmalıdır.)
date_default_timezone_set("Asia/Riyadh");

// PHP Teknik Ayarları
error_reporting(E_ALL ^ E_NOTICE);

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
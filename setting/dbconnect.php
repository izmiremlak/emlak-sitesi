<?php
// Güvenlik kontrolü
if (!defined("SERVER_HOST")) {
    die();
}

try {
    // PDO ile veritabanı bağlantısı
    $db = new PDO("mysql:host=" . SERVER_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Hata modunu etkinleştir
} catch (PDOException $e) {
    // Hata mesajını log dosyasına yaz ve ekrana göster
    handle_error("Bir hata oluştu: " . $e->getMessage());
}

// Charset ayarları
try {
    $db->exec("SET NAMES utf8");
    $db->exec("SET NAMES 'UTF8'");
    $db->exec("SET character_set_connection = 'UTF8'");
    $db->exec("SET character_set_client = 'UTF8'");
    $db->exec("SET character_set_results = 'UTF8'");
} catch (PDOException $e) {
    // Hata mesajını log dosyasına yaz ve ekrana göster
    handle_error("Charset ayarlarında bir hata oluştu: " . $e->getMessage());
}

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
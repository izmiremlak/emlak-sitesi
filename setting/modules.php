<?php

/*
Yönetim Panelinde Bulunan Modüller
*/

// Modüller dizisi
$moduller = array();

// Modül ekleme
$moduller['MD1'] = 'Hesap Bilgileri';

/**
 * Hatalarý log dosyasýna yazma fonksiyonu
 * @param string $message Hata mesajý
 */
function log_error($message)
{
    error_log($message, 3, __DIR__ . '/logs/error.log'); // Hata mesajýný log dosyasýna yaz
}

/**
 * Hata mesajlarýný hem log dosyasýna yaz hem de ekrana göster
 * @param string $error_message Hata mesajý
 */
function handle_error($error_message)
{
    log_error($error_message); // Log dosyasýna yaz
    echo $error_message; // Ekrana göster
}

// Örnek hata iþleme kullanýmý
handle_error("Örnek hata mesajý.");
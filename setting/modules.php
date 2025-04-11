<?php

/*
Y�netim Panelinde Bulunan Mod�ller
*/

// Mod�ller dizisi
$moduller = array();

// Mod�l ekleme
$moduller['MD1'] = 'Hesap Bilgileri';

/**
 * Hatalar� log dosyas�na yazma fonksiyonu
 * @param string $message Hata mesaj�
 */
function log_error($message)
{
    error_log($message, 3, __DIR__ . '/logs/error.log'); // Hata mesaj�n� log dosyas�na yaz
}

/**
 * Hata mesajlar�n� hem log dosyas�na yaz hem de ekrana g�ster
 * @param string $error_message Hata mesaj�
 */
function handle_error($error_message)
{
    log_error($error_message); // Log dosyas�na yaz
    echo $error_message; // Ekrana g�ster
}

// �rnek hata i�leme kullan�m�
handle_error("�rnek hata mesaj�.");
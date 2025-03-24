<?php
// Veri tabanı bilgilerinizi giriniz.
define("SERVER_HOST","localhost");
define("DB_NAME","turkiyeemlaksitesitrdb");
define("DB_USERNAME","turkiyeemlaksitesitrdb");
define("DB_PASSWORD","!turkiyeTR1234turkiyeTR?");
define("DB_CHARSET","utf8");

// PayPal Tahsilat Ayarları
$pay_secret	= 'a1b2c3d4e5f6&123+&654321';  // !ÖNEMLİ! :: PayPal ödeme için gereklidir. rastgele bir değer girin. Güvenlik için gereklidir.

// SMTP Debugger
define("SMTP_DEBUG",false); // Aktif : true Pasif : false

// Tahsilat Sonuç Sayfa Adresleri
$doain = str_replace("www.","",strtolower($_SERVER["SERVER_NAME"]));

if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on'){
$httpne = 'http';
}else{
$httpne = 'https';
}
$www		= (stristr($_SERVER["HTTP_HOST"],"www")) ? "www." : '';

define("PAYTR_OK_URL", $httpne."://".$www.$doain."/odeme-tamamlandi");
define("PAYTR_FAIL_URL", $httpne."://".$www.$doain."/odeme-basarisiz");


define("PAY_SECRET",md5($pay_secret)); 

// Ödeme Yöntemleri
$oyontemleri 	= array('Banka Havale/EFT','Kredi Kartı','Kredi Kartı (PAYPAL)');


// TimeZone (Yaz saati uygulaması nedeniyle TR için aşağıdaki şekilde olmalıdır.)
date_default_timezone_set("Asia/Riyadh");

// Php Technical Settings
error_reporting(E_ALL ^ E_NOTICE);
<?php 
include "../functions.php";

$p = $gvn->harf_rakam($_GET["p"]);
$pdir = 'ajax/' . $p . '.php';

if ($p != 'login' && $p != 'forget_password' && $hesap->tipi == 0) {
    die($fonk->ajax_hata("Hata!"));
}

if ($p != 'login' && $p != 'forget_password' && $p != 'ilce_getir' && $p != 'ilce_getir_string' && $hesap->tipi == 2) {
    die($fonk->ajax_hata("Demo versiyonda işlem yapamazsınız."));
}

if ($_FILES) {
    foreach ($_FILES as $key => $value) {
        $fi = $value;
        $uzanti = $fonk->uzanti($fi["name"]);
        $exs = array(".php", ".html", ".htaccess", ".ini", ".conf");
        if (in_array($uzanti, $exs)) {
            $fonk->ajax_hata("Bu dosya sitenize zarar verebildiği için yüklenemedi.", 4000);
            die();
        }
    }
}

if ($p == 'login') {
    $recaptchaSecret = '6LeOm_8qAAAAANXJTLdtXL30lBPAQzBEnApAtuYW';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $recaptchaSecret,
        'response' => $recaptchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    );
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultJson = json_decode($result);

    if ($resultJson === false || $resultJson->success !== true) {
        die($fonk->ajax_hata("reCAPTCHA doğrulaması başarısız! Lütfen tekrar deneyin."));
    }
}

if (file_exists($pdir)) {
    require $pdir;
} else {
    echo 'File Not Found';
}
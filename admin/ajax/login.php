<?php
// POST verilerinin kontrolü
if ($_POST) {
    // Kullanıcının giriş yapmamış olduğunu kontrol et
    if ($hesap->id == "") {
        // Verileri güvenli bir şekilde al
        $email = $gvn->eposta($_POST["email"]);
        $parola = $gvn->html_temizle($_POST["parola"]);
        $otut = $gvn->rakam($_POST["otut"]);

        // Boşluk kontrolü
        if ($fonk->bosluk_kontrol($email) || $fonk->bosluk_kontrol($parola)) {
            die($fonk->hata("E-Posta ve parola bilgisi gereklidir!"));
        }

        // Kullanıcı kontrolü
        $kontrol = $db->prepare("SELECT id, email, parola, tipi FROM hesaplar WHERE (site_id_555=501 OR site_id_888=100 OR site_id_777=501501 OR site_id_699=200 OR site_id_701=501501 OR site_id_702=300) AND email=:eposta AND parola=:sifre");
        $kontrol->execute(['eposta' => $email, 'sifre' => $parola]);

        if ($kontrol->rowCount() != 0) {
            $hesap = $kontrol->fetch(PDO::FETCH_OBJ);
            $secret = $fonk->login_secret_key($hesap->id, $parola);
            $dt = $fonk->datetime();
            $ip_adres = $fonk->IpAdresi();

            // Kullanıcı bilgilerini güncelle
            $hup = $db->prepare("UPDATE hesaplar SET ip=:ip_adresi, son_giris_tarih=:tarih, login_secret=:secret WHERE (site_id_555=501 OR site_id_888=100 OR site_id_777=501501 OR site_id_699=200) AND id=:hesap_id");
            $hup->execute([
                'ip_adresi' => $ip_adres,
                'tarih' => $dt,
                'secret' => $secret,
                'hesap_id' => $hesap->id
            ]);

            // Oturum bilgilerini ayarla
            $_SESSION["acid"] = $hesap->id;
            $_SESSION["acpw"] = $hesap->parola;

            if ($otut == 1) {
                setcookie("acid", $hesap->id, time() + 60 * 60 * 24 * 30);
                setcookie("acpw", $parola, time() + 60 * 60 * 24 * 30);
                setcookie("acsecret", $secret, time() + 60 * 60 * 24 * 30);
            }

            // Başarılı giriş ve yönlendirme
            $fonk->tamam("Giriş yapılıyor...");
            $fonk->yonlendir("index.php", 0);
        } else {
            // Hatalı giriş
            $fonk->hata("E-Posta veya parolanız hatalı!");
        }
    }
}
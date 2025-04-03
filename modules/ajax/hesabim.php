<?php
// Hata yönetimi için ayarları yapılandır
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error_log.txt'); // Hata log dosyasının yolu
error_reporting(E_ALL); // Tüm hataları raporla

// Hataları sitede göster
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red;'><b>Hata:</b> [$errno] $errstr - $errfile:$errline</div>";
    return true;
}
set_error_handler("customErrorHandler");

// POST verisi kontrolü
if ($_POST) {
    if ($hesap->id != "") {
        $turu = $hesap->turu;
        $adsoyad = $gvn->html_temizle($_POST["adsoyad"]);
        $ayr = @explode(" ", $adsoyad);
        $soyadi = end($ayr);
        array_pop($ayr);
        $adi = implode(" ", $ayr);
        $email = $gvn->html_temizle($_POST["email"]);
        $telefon = $gvn->rakam($_POST["telefon"]);
        $sabit_telefon = $gvn->rakam($_POST["sabit_telefon"]);
        $parola = $gvn->parola($_POST["parola"]);
        $parola_tekrar = $gvn->parola($_POST["parola_tekrar"]);
        $unvan = $gvn->html_temizle($_POST["unvan"]);
        $vergi_no = $gvn->html_temizle($_POST["vergi_no"]);
        $vergi_dairesi = $gvn->html_temizle($_POST["vergi_dairesi"]);
        $adres = ($turu == 2) ? $hesap->adres : $gvn->html_temizle($_POST["adres"]);
        $tcno = ($turu == 2) ? $hesap->tcno : $gvn->rakam($_POST["tcno"]);
        $telefond = $gvn->zrakam($_POST["telefond"]);
        $sabittelefond = $gvn->zrakam($_POST["sabittelefond"]);
        $epostad = $gvn->zrakam($_POST["epostad"]);
        $avatard = $gvn->zrakam($_POST["avatard"]);
        $sms_izin = $gvn->zrakam($_POST["sms_izin"]);
        $mail_izin = $gvn->zrakam($_POST["mail_izin"]);
        $il = $gvn->zrakam($_POST["il"]);
        $ilce = $gvn->zrakam($_POST["ilce"]);
        $mahalle = $gvn->zrakam($_POST["mahalle"]);
        $maps = $gvn->html_temizle($_POST["maps"]);
        $avatar = $_FILES["avatar"];
        $hakkinda = $gvn->filtre($_POST["hakkinda"]);
        $nick_adi = ($unvan != '' && $hesap->turu == 1) ? $gvn->PermaLink($unvan) : $hesap->nick_adi;

        // E-posta kontrolü
        if ($gvn->eposta_kontrol($email) == false) {
            die('<span class="error">' . dil("TX15") . '</span>');
        }

        // Kullanıcı türüne göre ek kontroller
        if ($turu == 0) {
            $unvan = ($unvan != '') ? '' : $unvan;
            $tcno = ($tcno == '' && $hesap->tcno != '') ? $hesap->tcno : $tcno;

            if ($fonk->bosluk_kontrol($tcno) == true && $gayarlar->tcnod == 1 && $hesap->tcno == '') {
                die('<span class="error">' . dil("TX369") . '</span>');
            } elseif ($gayarlar->tcnod == 1 && $gvn->tcNoCheck($tcno) == false && $hesap->tcno == '') {
                die('<span class="error">' . dil("TX370") . '</span>');
            }
        }
        // Kurumsal kullanıcı kontrolleri
        if ($turu == 1) {
            if ($fonk->bosluk_kontrol($unvan) == true) {
                die('<span class="error">' . dil("TX372") . '</span>');
            }
            if ($fonk->bosluk_kontrol($vergi_dairesi) == true) {
                die('<span class="error">' . dil("TX372") . '</span>');
            }
            if ($fonk->bosluk_kontrol($vergi_no) == true) {
                die('<span class="error">' . dil("TX372") . '</span>');
            }
        }

        // Adres kontrolü
        if ($turu == 0 || $turu == 1) {
            if ($fonk->bosluk_kontrol($adres) == true && $gayarlar->adresd == 1) {
                die('<span class="error">' . dil("TX371") . '</span>');
            }
        }

        // İl, ilçe ve mahalle kontrolleri
        if ($hesap->turu == 1) {
            // İli kontrol ediyorum....
            if ($il != 0) {
                $ilkontrol = $db->prepare("SELECT * FROM il WHERE id=?");
                $ilkontrol->execute(array($il));
                if ($ilkontrol->rowCount() < 1)
                    die("<span class='error'>" . dil("TX24") . "</span>");
            }

            // İlçeyi kontrol ediyorum....
            if ($ilce != 0) {
                $ilcekontrol = $db->prepare("SELECT * FROM ilce WHERE id=?");
                $ilcekontrol->execute(array($ilce));
                if ($ilcekontrol->rowCount() < 1)
                    die("<span class='error'>" . dil("TX25") . "</span>");
            }

            // Mahalleyi kontrol ediyorum....
            if ($mahalle != 0) {
                $mahakontrol = $db->prepare("SELECT * FROM mahalle_koy WHERE id=?");
                $mahakontrol->execute(array($mahalle));
                if ($mahakontrol->rowCount() < 1)
                    die("<span class='error'>" . dil("TX25") . "</span>");
            }

            // Maps kontrolü
            if (strlen($maps) >= 40) {
                die("<span class='error'>We have the problem!</span>");
            }
            $adres_update = $db->prepare("UPDATE hesaplar SET il_id=?, ilce_id=?, mahalle_id=?, maps=? WHERE site_id_555=999 AND id=?");
            $adres_update->execute(array($il, $ilce, $mahalle, $maps, $hesap->id));
        }

        // Avatar yükleme işlemi
        if ($avatar["tmp_name"] != '') {
            $max_size = 2097152; // Yüklyeyeceği her resim için max 2Mb boyut siniri aşarsa resim yüklenmez!
            $allow_exten = array('.jpg', '.jpeg', '.png'); // İzin verilen uzantılar...
            $file = $avatar;

            $tmp = $file["tmp_name"]; // Kaynak çekiyoruz
            $xadi = $file["name"]; // Dosya adını alıyoruz..
            $size = $file["size"]; // Boyutunu alıyoruz
            $uzanti = $fonk->uzanti($xadi); // Uzantısını alıyoruz
            if ($size <= $max_size) { // Boyutu max boyutu geçmiyorsa devam ediyoruz
                if (in_array($uzanti, $allow_exten)) { // izin verilen uzantılarda ise devam ediyoruz
                    $watermark		= '';
                    $exmd = strtolower(substr(md5(uniqid(rand())), 0, 18));
                    $randnm = $exmd . $uzanti;
                    $resim = $fonk->resim_yukle(true, $file, $randnm, '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads', $gorsel_boyutlari['avatar']['thumb_x'], $gorsel_boyutlari['avatar']['thumb_y']);
                    $resim = $fonk->resim_yukle(false, $file, $randnm, '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads', $gorsel_boyutlari['avatar']['orjin_x'], $gorsel_boyutlari['avatar']['orjin_y']);
                    if ($resim != '') { // Eğer resim yüklenmişse...
                        $db->query("UPDATE hesaplar SET avatar='" . $randnm . "' WHERE site_id_555=999 AND id=" . $hesap->id);
                        ?>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            $("#avatar_image").attr("src","/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?=$resim;?>");
                        });
                        </script>
                        <?php
                    } else { // Eğer resim yüklenmişse...
                        die('<span class="error" >Image Upload is Failed!</span>');
                    }
                } else { // izin verilen uzantılarda ise devam ediyoruz end
                    die('<span class="error" >' . dil("TX355") . '</span>');
                }
            } else {
                die('<span class="error" >' . dil("TX354") . '</span>');
            }
        }
        // E-posta ve telefon kontrolü
		
        $kontrol2 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND durum=1 AND id!=? AND (email=? OR ip=?) ");
        $kontrol2->execute(array($hesap->id, $email, $ip));
        
        if ($kontrol2->rowCount() > 0) {
            die('<span class="error" >' . dil("TX16") . '</span>');
        }

        $kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id!=? AND email=?");
        $kontrol->execute(array($hesap->id, $email));
        
        if ($kontrol->rowCount() > 0) {
            die('<span class="error" >' . dil("TX17") . '</span>');
        }

        if ($telefon != '') {
            $kontrol3 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id!=? AND telefon=?");
            $kontrol3->execute(array($hesap->id, $telefon));
            if ($kontrol3->rowCount() > 0) {
                die('<span class="error" >' . dil("TX18") . '</span>');
            }
        }

        // Parola kontrolü ve güncelleme
        if ($parola != "") {
            if ($fonk->bosluk_kontrol($parola_tekrar) == true) {
                die('<span class="error" >' . dil("TX19") . '</span>');
            }
            if ($parola_tekrar != $parola) {
                die('<span class="error" >' . dil("TX20") . '</span>');
            }
            $gnc = $db->prepare("UPDATE hesaplar SET parola=? WHERE site_id_555=999 AND id=? ");
            $gnc->execute(array($parola, $hesap->id));
            $_SESSION["acpw"] = $parola;
            if ($ck_acpw != "") {
                $login_secret = $fonk->login_secret_key($hesap->id, $parola);
                setcookie("acid", $hesap->id, time() + 60 * 60 * 24 * 30);
                setcookie("acpw", $parola, time() + 60 * 60 * 24 * 30);
                setcookie("acsecret", $login_secret, time() + 60 * 60 * 24 * 30);
                $db->query("UPDATE hesaplar SET login_secret='" . $login_secret . "' WHERE site_id_555=999 AND id=" . $hesap->id);
            }
        }

        // TC no onayı
        if ($gayarlar->tcnod == 1) {
            $tconay = 1;
        } else {
            $tconay = $hesap->tconay;
        }

        // Kullanıcı adı kontrolü
        if ($fonk->bosluk_kontrol($nick_adi) == false) {
            $baskasi = $db->prepare("SELECT nick_adi FROM hesaplar WHERE site_id_555=999 AND nick_adi=? AND id!=?");
            $baskasi->execute(array($nick_adi, $hesap->id));
            if ($baskasi->rowCount() > 0) {
                $nick_adi .= "-" . $hesap->id;
            }
        }

        // Kullanıcı bilgilerini güncelleme
        $sql = $db->prepare("UPDATE hesaplar SET telefon=?, email=?, sms_izin=?, mail_izin=?, sabit_telefon=?, telefond=?, sabittelefond=?, epostad=?, avatard=?, tcno=?, unvan=?, vergi_no=?, vergi_dairesi=?, adres=?, tconay=?, nick_adi=?, hakkinda=? WHERE site_id_555=999 AND id=?");
        $sql->execute(array($telefon, $email, $sms_izin, $mail_izin, $sabit_telefon, $telefond, $sabittelefond, $epostad, $avatard, $tcno, $unvan, $vergi_no, $vergi_dairesi, $adres, $tconay, $nick_adi, $hakkinda, $hesap->id));

        echo '<span class="complete">' . dil("TX21") . '</span>';
    }
}
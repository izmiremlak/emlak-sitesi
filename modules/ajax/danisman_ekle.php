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

// POST verilerinin varlığını kontrol et
if ($_POST) {
    if ($hesap->id != "") {

        $danisman_limit = $hesap->danisman_limit;
        $paketi = $db->query("SELECT * FROM upaketler_19541956 WHERE acid=" . intval($hesap->id) . " AND durum=1 AND btarih>NOW()");
        if ($paketi->rowCount() > 0) {
            $paketi = $paketi->fetch(PDO::FETCH_OBJ);
            $danisman_limit += ($paketi->danisman_limit == 0) ? 9999 : $paketi->danisman_limit;
            $danisman_limit -= $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND kid=" . intval($paketi->acid) . " AND pid=" . intval($paketi->id))->rowCount();
        }

        if ($danisman_limit < 1) {
            die('<span class="error">' . htmlspecialchars(dil("TX608"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        $pid = ($paketi->id == '') ? 0 : intval($paketi->id);
        $turu = 2;
        $adsoyad = $gvn->html_temizle($_POST["adsoyad"]);
        $ayr = @explode(" ", $adsoyad);
        $soyadi = end($ayr);
        array_pop($ayr);
        $adi = implode(" ", $ayr);
        $nick_adi = $gvn->PermaLink($adsoyad);
        $email = $gvn->html_temizle($_POST["email"]);
        $telefon = $gvn->rakam($_POST["telefon"]);
        $sabit_telefon = $gvn->rakam($_POST["sabit_telefon"]);
        $parola = $gvn->parola($_POST["parola"]);
        $parola_tekrar = $gvn->parola($_POST["parola_tekrar"]);
        /*
        $unvan = $gvn->html_temizle($_POST["unvan"]);
        $vergi_no = $gvn->html_temizle($_POST["vergi_no"]);
        $vergi_dairesi = $gvn->html_temizle($_POST["vergi_dairesi"]);
        $adres = $gvn->html_temizle($_POST["adres"]);
        $tcno = $gvn->rakam($_POST["tcno"]);
        $hakkinda = $gvn->mesaj(htmlspecialchars($_POST["hakkinda"], ENT_QUOTES));
        */
        $telefond = $gvn->zrakam($_POST["telefond"]);
        $sabittelefond = $gvn->zrakam($_POST["sabittelefond"]);
        $epostad = $gvn->zrakam($_POST["epostad"]);
        $avatard = $gvn->zrakam($_POST["avatard"]);
        $sms_izin = $gvn->zrakam($_POST["sms_izin"]);
        $mail_izin = $gvn->zrakam($_POST["mail_izin"]);
        $avatar = $_FILES["avatar"];
        $hakkinda = $gvn->filtre($_POST["hakkinda"]);

        if ($gvn->bosluk_kontrol($adsoyad) == true) {
            die('<span class="error">' . htmlspecialchars(dil("TX14"), ENT_QUOTES, 'UTF-8') . '</span>');
        } elseif ($gvn->eposta_kontrol($email) == false) {
            die('<span class="error">' . htmlspecialchars(dil("TX15"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

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
                    $watermark = '';
                    $exmd = strtolower(substr(md5(uniqid(rand())), 0, 18));
                    $randnm = $exmd . $uzanti;
                    $resim = $fonk->resim_yukle(true, $file, $randnm, '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads', $gorsel_boyutlari['avatar']['thumb_x'], $gorsel_boyutlari['avatar']['thumb_y']);
                    $resim = $fonk->resim_yukle(false, $file, $randnm, '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads', $gorsel_boyutlari['avatar']['orjin_x'], $gorsel_boyutlari['avatar']['orjin_y']);
                    if ($resim != '') { // Eğer resim yüklenmişse...
                        $db->query("UPDATE hesaplar SET avatar='" . htmlspecialchars($resim, ENT_QUOTES, 'UTF-8') . "' WHERE site_id_555=999 AND id=" . intval($hesap->id));
                    } else { // Eğer resim yüklenmişse...
                        die('<span class="error">Image Upload is Failed!</span>');
                    }
                } else { // izin verilen uzantılarda ise devam ediyoruz end
                    die('<span class="error">' . htmlspecialchars(dil("TX355"), ENT_QUOTES, 'UTF-8') . '</span>');
                }
            } else {
                die('<span class="error">' . htmlspecialchars(dil("TX354"), ENT_QUOTES, 'UTF-8') . '</span>');
            }
        }

        $kontrol2 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND durum=1 AND (email=? OR ip=?) ");
        $kontrol2->execute(array($email, $ip));

        if ($kontrol2->rowCount() > 0) {
            die('<span class="error">' . htmlspecialchars(dil("TX16"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        $kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND email=?");
        $kontrol->execute(array($email));

        if ($kontrol->rowCount() > 0) {
            die('<span class="error">' . htmlspecialchars(dil("TX17"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        if ($telefon != '') {
            $kontrol3 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND telefon=?");
            $kontrol3->execute(array($telefon));
            if ($kontrol3->rowCount() > 0) {
                die('<span class="error">' . htmlspecialchars(dil("TX18"), ENT_QUOTES, 'UTF-8') . '</span>');
            }
        }

        if ($gvn->bosluk_kontrol($parola) == true) {
            die('<span class="error">' . htmlspecialchars(dil("TX34"), ENT_QUOTES, 'UTF-8') . '</span>');
        } elseif ($gvn->bosluk_kontrol($parola_tekrar) == true) {
            die('<span class="error">' . htmlspecialchars(dil("TX35"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        if ($parola_tekrar != $parola) {
            die('<span class="error">' . htmlspecialchars(dil("TX20"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        try {
            $sql = $db->prepare("INSERT INTO hesaplar SET site_id_888=XXX,site_id_777=XXX,site_id_699=XXX,site_id_700=XXX,site_id_701=XXX,site_id_702=XXX,site_id_555=555,site_id_450=450,site_id_444=444,site_id_403=403,turu=?,adi=?,soyadi=?,telefon=?,email=?,sms_izin=?,mail_izin=?,sabit_telefon=?,telefond=?,sabittelefond=?,epostad=?,avatard=?,nick_adi=?,parola=?,resim=?,kid=?,tarih=?,hakkinda=?");
            $sql->execute(array($turu, $adi, $soyadi, $telefon, $email, $sms_izin, $mail_izin, $sabit_telefon, $telefond, $sabittelefond, $epostad, $avatard, $nick_adi, $parola, $resim, $hesap->id, $fonk->datetime(), $hakkinda));

            $acid = $db->lastInsertId();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $baskasi = $db->prepare("SELECT nick_adi FROM hesaplar WHERE site_id_555=999 AND nick_adi=? AND id!=?");
        $baskasi->execute(array($nick_adi, $acid));
        if ($baskasi->rowCount() > 0) {
            $nick_adi .= "-" . intval($acid);
            $nup = $db->prepare("UPDATE hesaplar SET nick_adi=? WHERE site_id_555=999 AND id=" . intval($acid));
            $nup->execute(array($nick_adi));
        }

        $fonk->yonlendir("eklenen-danismanlar", 2000);
?>
<script>
$("#DanismanEkleForm").slideUp(500, function(){
    $("#TamamDiv").slideDown(500);
});
$('html, body').animate({scrollTop: 250}, 500);
</script>
<?php
    }
}

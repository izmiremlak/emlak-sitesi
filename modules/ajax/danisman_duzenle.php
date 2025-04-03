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

        $id = $gvn->rakam($_GET["id"]);
        $kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=? AND kid=?");
        $kontrol->execute(array($id, $hesap->id));
        if ($kontrol->rowCount() < 1) {
            die();
        }
        $snc = $kontrol->fetch(PDO::FETCH_OBJ);

        // POST verilerini güvenli hale getir
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
        $telefond = $gvn->zrakam($_POST["telefond"]);
        $sabittelefond = $gvn->zrakam($_POST["sabittelefond"]);
        $epostad = $gvn->zrakam($_POST["epostad"]);
        $avatard = $gvn->zrakam($_POST["avatard"]);
        $sms_izin = $gvn->zrakam($_POST["sms_izin"]);
        $mail_izin = $gvn->zrakam($_POST["mail_izin"]);
        $durum = $gvn->zrakam($_POST["durum"]);
        $avatar = $_FILES["avatar"];
        $hakkinda = $gvn->filtre($_POST["hakkinda"]);

        if ($durum < 0 OR $durum > 1) {
            $durum = $snc->durum;
        }

        if ($gvn->eposta_kontrol($email) == false) {
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
                        $db->query("UPDATE hesaplar SET avatar='" . htmlspecialchars($resim, ENT_QUOTES, 'UTF-8') . "' WHERE site_id_555=999 AND id=" . intval($snc->id));
                        ?>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#avatar_image").attr("src","/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($resim, ENT_QUOTES, 'UTF-8'); ?>");
                            });
                        </script>
                        <?php
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

// Devam eden kod parçası

        $kontrol2 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND durum=1 AND id!=? AND (email=? OR ip=?) ");
        $kontrol2->execute(array($snc->id, $email, $ip));

        if ($kontrol2->rowCount() > 0) {
            die('<span class="error">' . htmlspecialchars(dil("TX16"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        $kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id!=? AND email=?");
        $kontrol->execute(array($snc->id, $email));

        if ($kontrol->rowCount() > 0) {
            die('<span class="error">' . htmlspecialchars(dil("TX17"), ENT_QUOTES, 'UTF-8') . '</span>');
        }

        if ($telefon != '') {
            $kontrol3 = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id!=? AND telefon=?");
            $kontrol3->execute(array($snc->id, $telefon));
            if ($kontrol3->rowCount() > 0) {
                die('<span class="error">' . htmlspecialchars(dil("TX18"), ENT_QUOTES, 'UTF-8') . '</span>');
            }
        }

        if ($parola != "") {
            if ($gvn->bosluk_kontrol($parola_tekrar) == true) {
                die('<span class="error">' . htmlspecialchars(dil("TX19"), ENT_QUOTES, 'UTF-8') . '</span>');
            }
            if ($parola_tekrar != $parola) {
                die('<span class="error">' . htmlspecialchars(dil("TX20"), ENT_QUOTES, 'UTF-8') . '</span>');
            }
            $gnc = $db->prepare("UPDATE hesaplar SET parola=? WHERE site_id_555=999 AND id=? ");
            $gnc->execute(array($parola, $snc->id));
        }

        $baskasi = $db->prepare("SELECT nick_adi FROM hesaplar WHERE site_id_555=999 AND nick_adi=? AND id!=?");
        $baskasi->execute(array($nick_adi, $snc->id));
        if ($baskasi->rowCount() > 0) {
            $nick_adi .= "-" . $snc->id;
        }

        // adi=?,soyadi=?, #$adi,$soyadi,
        $sql = $db->prepare("UPDATE hesaplar SET telefon=?,email=?,sms_izin=?,mail_izin=?,sabit_telefon=?,telefond=?,sabittelefond=?,epostad=?,avatard=?,nick_adi=?,durum=?,hakkinda=? WHERE site_id_555=999 AND id=?");
        $sql->execute(array($telefon, $email, $sms_izin, $mail_izin, $sabit_telefon, $telefond, $sabittelefond, $epostad, $avatard, $nick_adi, $durum, $hakkinda, $snc->id));

        echo '<span class="complete">' . htmlspecialchars(dil("TX21"), ENT_QUOTES, 'UTF-8') . '</span>';
    }
}
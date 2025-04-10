<?php

if (!defined("SERVER_HOST")) {
    exit;
}

/**
 * learkho_functions Class
 * 
 * Bu sınıf, çeşitli yardımcı fonksiyonları içerir.
 * PHP 8.3.17 özelliklerini kullanarak yeniden düzenlenmiştir.
 */
class learkho_functions extends home_functions
{
    public $loaded_sms_gonder = false;
    public $turkce_tarih = [
        "January" => "Ocak", "February" => "Şubat", "March" => "Mart", "April" => "Nisan", "May" => "Mayıs", "June" => "Haziran", 
        "July" => "Temmuz", "August" => "Ağustos", "September" => "Eylül", "October" => "Ekim", "November" => "Kasım", "December" => "Aralık"
    ];
    public $turkce_tarih_kisa = [
        "January" => "Oca", "February" => "Şub", "March" => "Mar", "April" => "Nis", "May" => "May", "June" => "Haz", 
        "July" => "Tem", "August" => "Ağu", "September" => "Eyl", "October" => "Eki", "November" => "Kas", "December" => "Ara"
    ];

    /**
     * Bildirim gönderir.
     *
     * @param array $ydegiskenler
     * @param string|null $tag
     * @param string $uemail
     * @param string $utelefon
     * @return bool
     */
    public function bildirim_gonder(array $ydegiskenler = [], ?string $tag = null, string $uemail = "", string $utelefon = ""): bool
    {
        global $db, $dayarlar, $gayarlar, $domain2;
        $ydegiskenler[] = SITE_URL . "uploads/thumb/" . $gayarlar->logo;
        $ydegiskenler[] = $domain2;
        $sablon = $db->query("SELECT * FROM mail_sablonlar_501 WHERE tag='" . $tag . "' AND dil='" . $dayarlar->dil . "' ")->fetch(PDO::FETCH_OBJ);
        $text = $sablon->icerik;
        $text2 = $sablon->icerik2;
        $text3 = strip_tags(str_replace(["<br />", "<br/>", "<br>"], ["\n"], $sablon->icerik3));
        $text4 = strip_tags(str_replace(["<br />", "<br/>", "<br>"], ["\n"], $sablon->icerik4));
        $degiskenler = rtrim($sablon->degiskenler);
        $degiskenler = explode(",", $degiskenler);
        $nwdegiskenler = array_map(fn($degisken) => "{" . $degisken . "}", $degiskenler);

        $text = str_replace($nwdegiskenler, $ydegiskenler, $text);
        $text2 = str_replace($nwdegiskenler, $ydegiskenler, $text2);
        $text3 = str_replace($nwdegiskenler, $ydegiskenler, $text3);
        $text4 = str_replace($nwdegiskenler, $ydegiskenler, $text4);

        $genel_yemails = stristr($dayarlar->yemails, ",") ? explode(",", $dayarlar->yemails) : $dayarlar->yemails;
        $sablon_yemails = stristr($sablon->yemails, ",") ? explode(",", $sablon->yemails) : $sablon->yemails;
        $genel_yphones = stristr($dayarlar->yphones, ",") ? explode(",", $dayarlar->yphones) : $dayarlar->yphones;
        $sablon_yphones = stristr($sablon->yphones, ",") ? explode(",", $sablon->yphones) : $sablon->yphones;
        $yemails = $sablon->yemails == "" ? $genel_yemails : $sablon_yemails;
        $yphones = $sablon->yphones == "" ? $genel_yphones : $sablon_yphones;

        if ($sablon->ubildirim == 1) {
            $xgonder = $this->mail_gonder($sablon->konu, $uemail, $text);
        }
        if ($sablon->abildirim == 1) {
            if (is_array($yemails)) {
                foreach ($yemails as $nmail) {
                    if ($nmail != "") {
                        $nmail = trim($nmail);
                        $agonder = $this->mail_gonder($sablon->konu2, $nmail, $text2);
                    }
                }
            } else {
                $agonder = $this->mail_gonder($sablon->konu2, $yemails, $text2);
            }
        }
        if ($sablon->sbildirim == 1 && $utelefon != "" && $GLOBALS["gayarlar"]->sms_username != "") {
            $usgonder = $this->sms_gonder($utelefon, $text3);
        }
        if ($sablon->ysbildirim == 1 && $GLOBALS["gayarlar"]->sms_username != "") {
            if (is_array($yphones)) {
                foreach ($yphones as $nphone) {
                    if ($nphone != "") {
                        $nphone = trim($nphone);
                        $ysgonder = $this->sms_gonder($nphone, $text4);
                    }
                }
            } else {
                $ysgonder = $this->sms_gonder($yphones, $text4);
            }
        }
        return true;
    }
	
    /**
     * Menü listesini oluşturur.
     *
     * @param int $kat_id
     */
    public function menu_listesi(int $kat_id = 0): void
    {
        global $db, $dil;
        $sql = $db->query("SELECT * FROM menuler_501 WHERE ustu=" . $kat_id . " AND dil='" . $dil . "' ORDER BY sira ASC");
        if ($sql->rowCount() > 0) {
            if ($kat_id != 0) {
                $ustne = $db->query("SELECT ustu FROM menuler_501 WHERE id=" . $kat_id)->fetch(PDO::FETCH_OBJ);
                if ($ustne->ustu == 0) {
                    $ustaktif = true;
                }
            }
            echo "\n<ul>\n";
            $i = 0;
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $i += 1;
                $rwsayfa = $db->query("SELECT id,url FROM sayfalar WHERE (site_id_555=501 OR site_id_888=100 OR site_id_777=501501 OR site_id_699=200 OR site_id_701=501501 OR site_id_702=300) AND id=" . $row["sayfa"] . " ORDER BY id DESC");
                $rwsayfa = $rwsayfa->fetch(PDO::FETCH_OBJ);
                $mlink = $GLOBALS["dayarlar"]->permalink == "Evet" ? $rwsayfa->url . ".html" : "index.php?p=sayfa&id=" . $rwsayfa->id;
                $kareurl = empty($row["url"]) || $row["url"] == "#" ? "javascript:void(0);" : $row["url"];
                $target = !empty($row["target"]) ? " target=\"" . $row["target"] . "\" " : "";
                echo "<li>";
                echo $ustne->ustu == 0 && $i == 1 ? "<i id=\"menuustok\" class=\"fa fa-caret-up\" aria-hidden=\"true\"></i><a id=\"ustline\"" : "<a";
                echo " href=\"";
                echo $row["sayfa"] != 0 ? $mlink : $kareurl;
                echo "\"";
                echo $target;
                echo ">";
                echo $row["baslik"];
                $this->menu_listesi($row["id"]);
                echo "</li>\r\n";
            }
            echo "</ul>\n";
        }
    }

    /**
     * KDV hesaplar.
     *
     * @param float $fiyat
     * @param float $kdv
     * @return float
     */
    public function kdval(float $fiyat, float $kdv): float
    {
        $kdv = empty($kdv) ? 18 : $kdv;
        $sonuc = $fiyat * $kdv / 100;
        return $sonuc;
    }

    /**
     * Para birimi kodunu döndürür.
     *
     * @param string $pb
     * @return string
     */
    public function currency_code(string $pb): string
    {
        return match ($pb) {
            "₺", "TL" => "TRY",
            "$" => "USD",
            "EURO", "€" => "EUR",
            default => $pb,
        };
    }

    /**
     * Gün farkını hesaplar.
     *
     * @param string $tarih1
     * @param string $tarih2
     * @return int
     */
    public function gun_farki(string $tarih1, string $tarih2): int
    {
        [$y1, $a1, $g1] = explode("-", $tarih1);
        [$y2, $a2, $g2] = explode("-", $tarih2);
        $t1_timestamp = mktime(0, 0, 0, $a1, $g1, $y1);
        $t2_timestamp = mktime(0, 0, 0, $a2, $g2, $y2);
        $result = $t2_timestamp < $t1_timestamp ? ($t1_timestamp - $t2_timestamp) / 86400 : (0 - ($t2_timestamp - $t1_timestamp)) / 86400;
        return round($result);
    }

    /**
     * Ekstra JS ve CSS dosyalarını yükler.
     *
     * @param bool $jquerymin
     * @param bool $bootstrap
     * @param bool $ajaxform
     */
    public function ekstra(bool $jquerymin = false, bool $bootstrap = false, bool $ajaxform = false): void
    {
        echo $jquerymin ? "\r\n<script type=\"text/javascript\" src=\"assets/js/jquery.min.js\" defer></script>\r\n" : "";
        echo $ajaxform ? "\r\n<script type=\"text/javascript\" src=\"assets/js/jquery.form.min.js\" defer></script>\r\n" : "";
        echo "\r\n<script type=\"text/javascript\" src=\"assets/js/istmark.js\" defer></script>\r\n";
        if ($bootstrap) {
            echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\r\n\r\n<!-- Latest compiled and minified CSS -->\r\n<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">\r\n\r\n<!-- Optional theme -->\r\n<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css\">\r\n\r\n<!-- Latest compiled and minified JavaScript -->\r\n<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" defer></script>\r\n";
        }
    }

    /**
     * Metin uzunluğunu döndürür.
     *
     * @param string $str
     * @return int
     */
    public function strlentr(string $str): int
    {
        return mb_strlen($str, "UTF-8");
    }

    /**
     * Metni kısaltır.
     *
     * @param string $text
     * @param int $baslangic
     * @param int $son
     * @param string $charset
     * @return string
     */
    public function kisalt(string $text, int $baslangic, int $son, string $charset = "UTF-8"): string
    {
        return mb_substr($text, $baslangic, $son, $charset);
    }

    /**
     * Metni kısaltır ve sonuna ... ekler.
     *
     * @param string $text
     * @param int $baslangic
     * @param int $son
     * @param string $charset
     * @return string
     */
    public function kisalt2(string $text, int $baslangic, int $son, string $charset = "UTF-8"): string
    {
        $netext = $this->kisalt($text, $baslangic, $son, $charset);
        $netext .= $son < $this->strlentr($text) ? "..." : "";
        return $netext;
    }

    /**
     * Sadece rakamları döndürür.
     *
     * @param string $num
     * @return string
     */
    public function sadece_rakam(string $num): string
    {
        return guvenlik::rakam($num);
    }

    /**
     * Mail gönderir.
     *
     * @param string $konu
     * @param string $nereye
     * @param string $message
     * @return bool
     */
    public function mail_gonder(string $konu, string $nereye, string $message): bool
    {
        $gonder = new PHPMailer();
        if (defined("ISMAIL")) {
            $gonder->IsMail();
        } else {
            $gonder->IsSMTP();
        }
        $gonder->From = MAIL_USER;
        $gonder->CharSet = "utf-8";
        $gonder->FromName = MAIL_FROMNAME;
        if (SMTP_DEBUG) {
            $gonder->SMTPDebug = 2;
        }
        $gonder->Host = MAIL_HOST;
        $gonder->Port = MAIL_PORT;
        if (MAIL_SECURE) {
            $gonder->SMTPSecure = MAIL_SMTPSecure;
        }
        $gonder->SMTPAuth = true;
        $gonder->SetFrom(MAIL_USER, MAIL_FROMNAME);
        $gonder->Username = MAIL_USER;
        $gonder->Password = MAIL_PASSWORD;
        $gonder->WordWrap = 50;
        $gonder->IsHTML(true);
        $gonder->Subject = $konu;
        $gonder->Body = $message;
        $gonder->AddAddress($nereye, __DOMAIN__);
        return @$gonder->Send();
    }

    /**
     * İzmir tr SMS gönderir.
     *
     * @param string $site_name
     * @param string $send_xml
     * @return string
     */
    private function izmirtr_sms_curl(string $site_name, string $send_xml): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $site_name);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $send_xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        return $result;
    }

    /**
     * İzmir tr cell gönderir.
     *
     * @param string|array $telefon
     * @param string $text
     * @return bool
     */
    private function izmirtrcell_gonder(string|array $telefon, string $text): bool
    {
        if (!$this->loaded_sms_gonder && file_exists(__DIR__ . DIRECTORY_SEPARATOR . "sms_gonder.php")) {
            include __DIR__ . DIRECTORY_SEPARATOR . "sms_gonder.php";
            $this->loaded_sms_gonder = true;
        }
        if (function_exists("sms_gonder")) {
            return sms_gonder($telefon, $text);
        }
        $numaralar = is_array($telefon) ? $telefon : [$telefon];
        $numaralar = implode(",", $numaralar);
        $postdata = [
            "kullanici" => SMS_USERNAME, "sifre" => SMS_PASSWORD, "baslik" => SMS_BASLIK, 
            "metin" => $text, "alicilar" => $numaralar
        ];
        $postdata = http_build_query($postdata);
        $sonuc = $this->izmirtr_sms_curl("http://izmirtr.com/cell/sms-gonder-api.php", $postdata);
        if (str_starts_with($sonuc, "OK")) {
            return true;
        }
        if (str_starts_with($sonuc, "ERR")) {
            return false;
        }
        return false;
    }

    /**
     * SMS gönderir.
     *
     * @param string|array $telefon
     * @param string $text
     * @param string $turu
     * @return bool
     */
    public function sms_gonder(string|array $telefon, string $text, string $turu = ""): bool
    {
        global $gayarlar;
        $sms_firma = $gayarlar->sms_firma;
        if ($sms_firma == 1) {
            return $this->izmirtrcell_gonder($telefon, $text);
        }
        return false;
    }

    /**
     * Boşluk kontrolü yapar.
     *
     * @param string $text
     * @return bool
     */
    public function bosluk_kontrol(string $text): bool
    {
        return empty($text) ? true : ctype_space($text);
    }

    /**
     * Tamam mesajı gösterir.
     *
     * @param string $text
     */
    public function tamam(string $text): void
    {
        echo "<div class=\"alert alert-success\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }

    /**
     * Hata mesajı gösterir.
     *
     * @param string $text
     */
    public function hata(string $text): void
    {
        echo "<div class=\"alert alert-danger\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }
}

/**
 * Bilgi mesajı gösterir.
 *
 * @param string $text
 */
public function bilgi(string $text): void
{
    echo "<div class=\"alert alert-info\" role=\"alert\">";
    echo $text;
    echo "</div>";
}

/**
 * Uyarı mesajı gösterir.
 *
 * @param string $text
 */
public function uyari(string $text): void
{
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $text;
    echo "</div>";
}

/**
 * Ajax başarı mesajı gösterir.
 *
 * @param string $string
 */
public function ajax_tamam(string $string): void
{
    echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('success', 'top center', 'İşlem Başarılı','";
    echo addslashes($string);
    echo "');\r\n</script>\r\n";
}

/**
 * Ajax hata mesajı gösterir.
 *
 * @param string $string
 */
public function ajax_hata(string $string): void
{
    echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('error', 'top center', 'İşlem Hatalı','";
    echo addslashes($string);
    echo "');\r\n</script>\r\n";
}

/**
 * Ajax uyarı mesajı gösterir.
 *
 * @param string $string
 */
public function ajax_uyari(string $string): void
{
    echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('warning', 'top center', 'Uyarı!','";
    echo addslashes($string);
    echo "');\r\n</script>\r\n";
}

/**
 * Ajax bilgi mesajı gösterir.
 *
 * @param string $string
 */
public function ajax_bilgi(string $string): void
{
    echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('info', 'top center', 'Uyarı!','";
    echo addslashes($string);
    echo "');\r\n</script>\r\n";
}

/**
 * Yönlendirir.
 *
 * @param string $nere
 * @param int $sure
 */
public function yonlendir(string $nere, int $sure = 1): void
{
    echo "<script type=\"text/javascript\">\r\nfunction yolla(){\r\nwindow.location.href = '";
    echo $nere;
    echo "';\r\n}\r\nsetTimeout(\"yolla();\",";
    echo $sure;
    echo ");\r\n</script>\r\n";
}

/**
 * Türkçe karakterleri İngilizce karakterlere çevirir.
 *
 * @param string $text
 * @return string
 */
public function eng_cevir(string $text): string
{
    $text = trim($text);
    $search = ["Ç", "ç", "Ğ", "ğ", "ı", "İ", "Ö", "ö", "Ş", "ş", "Ü", "ü"];
    $replace = ["C", "c", "G", "g", "i", "I", "O", "o", "S", "s", "U", "u"];
    $new_text = str_replace($search, $replace, $text);
    return $new_text;
}

/**
 * Cacheleme işlemlerini yönetir.
 *
 * @param string $yap
 * @param string|null $cache_ismi
 * @param int $cache_suresi
 */
public function cachele(string $yap, ?string $cache_ismi = null, int $cache_suresi = 21600): void
{
    global $cache;
    if ($cache_ismi === null) {
        $cache_ismi = md5($_SERVER["REQUEST_URI"]);
    }
    $cache_klasor = __DIR__ . "/cache";
    $cache_dosya_adi = $cache_klasor . "/cache-" . $cache_ismi . ".txt";
    if (!is_dir($cache_klasor)) {
        mkdir($cache_klasor, 493);
    }
    if ($yap === "basla") {
        if (file_exists($cache_dosya_adi) && time() - filemtime($cache_dosya_adi) < $cache_suresi) {
            $cache = false;
            include $cache_dosya_adi;
        } else {
            $cache = true;
            ob_start();
        }
    } else {
        if ($yap === "bitir" && $cache) {
            file_put_contents($cache_dosya_adi, ob_get_contents());
            ob_end_flush();
        }
    }
}

/**
 * E-posta adresini gizler.
 *
 * @param string $str
 * @return string|bool
 */
public function eposta_gizle(string $str): string|bool
{
    if (!empty($str)) {
        $bol = explode("@", $str);
        $arr1 = str_split($bol[0]);
        $str = "";
        for ($i = 0; $i <= count($arr1); $i++) {
            $str .= $i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 9 ? "*" : $arr1[$i];
        }
        return $str . "@" . $bol[1];
    }
    return false;
}

/**
 * Metni gizler.
 *
 * @param string $str
 * @return string|bool
 */
public function string_gizle(string $str): string|bool
{
    if (!empty($str)) {
        $arr1 = str_split($str);
        $str = "";
        for ($i = 0; $i <= count($arr1); $i++) {
            $str .= $i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 9 ? "*" : $arr1[$i];
        }
        return $str;
    }
    return false;
}

/**
 * Kupon anahtarı oluşturur.
 *
 * @param int $max_l
 * @return string
 */
public function KuponKey(int $max_l): string
{
    $i = 0;
    $zufallswerte = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    $array_size = count($zufallswerte);
    $zufallscode = "";
    while ($i < $max_l) {
        $i++;
        $zufallscode .= $zufallswerte[rand(0, $array_size - 1)];
        if ($i % 3 == 0) {
            $zufallscode .= "-";
        }
    }
    if (preg_match("/(-)$/", $zufallscode)) {
        return strtoupper(substr($zufallscode, 0, -1));
    }
    return strtoupper($zufallscode);
}

/**
 * Türkçe karakterleri dönüştürür.
 *
 * @param string $char
 * @return string
 */
public function turkce_karakter(string $char): string
{
    return mb_convert_encoding($char, "UTF-8", "ISO-8859-9");
}

/**
 * Zaman farkını hesaplar ve uygun formatta döndürür.
 *
 * @param string $zaman
 * @return string
 */
public function zaman(string $zaman): string
{
    $onceBol = explode(" ", $zaman);
    $gay = explode(".", $onceBol[0]);
    $sds = explode(":", $onceBol[1]);
    $zaman = mktime($sds[0], $sds[1], $sds[2], $gay[1], $gay[0], $gay[2]);
    $zaman_farki = time() - $zaman;
    $saniye = $zaman_farki;
    $dakika = round($zaman_farki / 60);
    $saat = round($zaman_farki / 3600);
    $gun = round($zaman_farki / 86400);
    $hafta = round($zaman_farki / 604800);
    $ay = round($zaman_farki / 2419200);
    $yil = round($zaman_farki / 29030400);
    return match(true) {
        $saniye < 60 => $saniye == 0 ? "Az Önce" : "Yaklaşık " . $saniye . " saniye önce",
        $dakika < 60 => "Yaklaşık " . $dakika . " dakika önce",
        $saat < 24 => "Yaklaşık " . $saat . " saat önce",
        $gun < 7 => "Yaklaşık " . $gun . " gün önce",
        $hafta < 4 => "Yaklaşık " . $hafta . " hafta önce",
        $ay < 12 => "Yaklaşık " . $ay . " ay önce",
        default => "Yaklaşık " . $yil . " yıl önce"
    };
}

/**
 * IP adresini döndürür.
 *
 * @return string
 */
public function IpAdresi(): string
{
    if ($_SERVER["HTTP_CLIENT_IP"]) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        if (str_contains($ip, ",")) {
            $tmp = explode(",", $ip);
            $ip = trim($tmp[0]);
        }
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    return $ip;
}

/**
 * Geçerli tarih ve saati döndürür.
 *
 * @return string
 */
public function datetime(): string
{
    return date("Y-m-d H:i:s");
}

/**
 * Geçerli tarihi döndürür.
 *
 * @return string
 */
public function this_date(): string
{
    return date("Y-m-d");
}

/**
 * Giriş için gizli anahtar oluşturur.
 *
 * @param string $acid
 * @param string $acpw
 * @return string
 */
public function login_secret_key(string $acid, string $acpw): string
{
    return md5("ISTMARK_@^_^_SECRET_@_" . $acid . "_@_" . $acpw . "_@_" . $this->IpAdresi() . "@+");
}

/**
 * Dosya uzantısını döndürür.
 *
 * @param string $string
 * @return string
 */
public function uzanti(string $string): string
{
    return strtolower(strrchr($string, "."));
}

/**
 * Çoklu dosya dizisini yönetir.
 *
 * @param array $arr
 * @return array
 */
public function multiple_arr(array $arr): array
{
    $files = [];
    foreach ($arr as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files)) {
                $files[$i] = [];
            }
            $files[$i][$k] = $v;
        }
    }
    return $files;
}

/**
 * Görsel ayarlarını yapar.
 *
 * @param string $path
 * @param string $file
 * @param string $name
 * @param bool $thumb
 * @param int|bool $x
 * @param int|bool $y
 * @param int $rotate
 * @param string|bool $watermark
 * @return bool
 */
public function gorsel_ayarla(string $path, string $file, string $name, bool $thumb = false, int|bool $x = false, int|bool $y = false, int $rotate = 0, string|bool $watermark = false): bool
{
    $paf = empty($path) ? $file : $path . DIRECTORY_SEPARATOR . $file;
    $image = new Upload($paf, "tr_TR");
    if ($image->uploaded) {
        $image->file_overwrite = true;
        if (!empty($name)) {
            $image->file_new_name_body = $name;
        }
        $image->image_background_color = "#eeeeee";
        $image->allowed = ["image/*"];
        $image->jpeg_quality = 100;
        if ($x || $y) {
            $image->image_resize = true;
            $image->image_ratio_fill = true;
            if ($x && $y) {
                $image->image_x = $x;
                $image->image_y = $y;
            } elseif ($x) {
                $image->image_x = $x;
                $image->image_ratio_y = true;
            } elseif ($y) {
                $image->image_y = $y;
                $image->image_ratio_x = true;
            }
        }
        if ($rotate != 0) {
            $image->image_rotate = $rotate;
        }
        if ($watermark) {
            $image->image_watermark = $watermark;
            $image->image_watermark_position = "L";
        }
        $wipath = empty($path) ? __DIR__ : $path;
        $wipath = $thumb ? $wipath . DIRECTORY_SEPARATOR . "thumb" : $wipath;
        $image->Process($wipath);
        if ($image->processed) {
            return true;
        }
        exit("Process is failed");
    }
    return false;
}

/**
 * Resim yükler.
 *
 * @param bool $thumb
 * @param string $name
 * @param string $dadi
 * @param string $yol
 * @param int|bool $x
 * @param int|bool $y
 * @param bool $filtre
 * @param string $watermark
 * @param bool $crop
 * @return string|void
 */
public function resim_yukle(bool $thumb = false, string $name, string $dadi, string $yol, int|bool $x = false, int|bool $y = false, bool $filtre = true, string $watermark = "", bool $crop = false)
{
    if (!$filtre) {
        if ($thumb) {
            @move_uploaded_file($_FILES[$name]["tmp_name"], $yol . "/thumb/" . $dadi);
        } else {
            @move_uploaded_file($_FILES[$name]["tmp_name"], $yol . "/" . $dadi);
        }
        return $dadi;
    }
    $ho = is_array($name) ? $name : $_FILES[$name];
    $uzanti = $this->uzanti($dadi);
    $resim = $dadi;
    $dontext = str_replace($uzanti, "", $resim);
    $orgname = $dontext . "_original" . $uzanti;
    $original_paf = $yol . "/" . $orgname;
    if (!file_exists($original_paf) && !move_uploaded_file($ho["tmp_name"], $original_paf)) {
        exit("Gorsel yuklenemedi!");
    }
    $ho = $original_paf;
    $image = new Upload($ho);
    if ($image->uploaded) {
        $image->file_overwrite = true;
        $image->file_new_name_body = $dontext;
        $image->image_background_color = "#eeeeee";
        if ($x || $y) {
            $image->image_resize = true;
            if ($crop) {
                $image->image_ratio_fill = true;
            }
            if ($x && $y) {
                $image->image_x = $x;
                $image->image_y = $y;
            } elseif ($x) {
                $image->image_x = $x;
                $image->image_ratio_y = true;
            } elseif ($y) {
                $image->image_y = $y;
                $image->image_ratio_x = true;
            }
        }
        $image->jpeg_quality = 100;
        if (!empty($watermark)) {
            $image->image_watermark = $watermark;
            $image->image_watermark_position = "L";
        }
        $image->allowed = ["image/*"];
        $yol = $thumb ? $yol . "/thumb/" : $yol . "/";
        $image->Process($yol);
        if (!$image->processed) {
            exit($image->log);
        }
        return $dadi;
    }
    exit($image->log);
}

/**
 * HTTP adresini döndürür.
 *
 * @return string
 */
public function http_adres(): string
{
    return "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
}

if ($xsd004 != "b735453157f38d34b65d935ff57d8082") {
    exit(@file_get_contents("http://www.izmirtr.com/license"));
}

function aTk7C60iSqriNxrOVShUZTVoAU($a, $b)
{
    return $a . "-" . $b . "bOtqTFLI8ub6ZjtmhhZutOCR";
}

function ac5ceki26dbmmajgxahszg9o0fc()
{
    return "6b>^PEDK3=!|Ijy2#m<Z4uyq`(JMncciGAK!h=[praz";
}

function ateipc7puj5yzylevuv6yevzq56()
{
    return ";NL?D`3?;w*7XYo>+NIe_MS#Cs1YdYL<(q)n(&)+yz&";
}

function azi90ce2bzoncctlmrscpjl51wl()
{
    return "Be=Y/Ku-g18*N-T5?6nC+`<)ei#<HgKI)9}R0!<!5:G";
}

function a8emwlgm3nnokh9ft0gfdpatsdg()
{
    return "&~[}Uq/v1nTJ21<KNqkjX*dI@LZa(|AQiDdXOlXpz(Y";
}

function azqbpnca15spplrnqftgwr0drg7()
{
    return "5P#jWl3tH:|@`N>IFF9bNo03X6EKX5QQ0y-!=vJ&/~s";
}

function adugezsraprpw9axkormka7km38()
{
    return "fW~gqU;IJ^^_v;EO4pJF-?I_?s`0!>STmcZ|+nP}|HJ";
}

function aktmz6byk8fo5gwyi7vtvufgxpk()
{
    return "a+@rsuV%3j5/BUoGN<YFM~vO>x&*j5ce4D_AyQmr/o%";
}

function arh44em3syb0urwxyzox4vsrhkx()
{
    return "O`WqF;EC746!Y98/?*pV>rh]LP_bICZTsJx3EH5/s!^";
}

function ayw5oujuawujwgjqx5anadxxw1c()
{
    return "n2/CYd^^_8)X/x:(6071huF=FnjVcWM;1K;lpW>[(+n";
}

function ayvgwrcgjliuejr5buhbrqkingh()
{
    return "4wvX#nF*ZN6dxWW+M=YkK4b!eMxGM^f2^E5qW_KiBcS";
}

function ar5rfyttthivdvne2gajrk4ccao()
{
    return "PNndgEgJq:paN_r7)>K~QTYK5I8u}U#QnOYJW(YEA|H";
}

function amik67ii2jolwiczyzwxc0lxmbn()
{
    return "=U;WF@lj3U2uwx(gpPUfqa#AMQoW-><Y|<i?zWW>yU]";
}

function afozgi9897ndhfgc8woy17mstnp()
{
    return "/SEwo~_?G0U*gAm3gyGbIfipnnXa0kfI78;lsPGg7-7";
}

function asadqrlm0sir0r8tgug9hxz0af6()
{
    return "%nDjDj+KS#9egYzQe&o=p#C=eI4C](4n5PU!9EbxrsT";
}

function akgz5iasaxnh3wg8zbul3fzvqvr()
{
    return "!WrFwjx}OdGZ=/]!;jSWMQiz-1JfABCKS*fMh/iu!1D";
}

function aodfetqd30l7mzosonokft29ydv()
{
    return "D=T9<NPCzv_+kQ#qM@ACOS>5&C!6:Bv6eAiz_69s@6q";
}

function aoukzpdywuehwgzocrehktiaktg()
{
    return "|B+jpK?hxvn`11>5m8W2Y:pukpRzF*3GM-Fl#Vn>?wA";
}

function amwcxtupdjgeablowquhmbyhgeb()
{
    return "v4w#<KTYLlOo`gIKOA*&B`vh=V08PYX[Q0N%WK5ilrQ";
}

function aiuqme19clrhtwxz8asspcdn4nf()
{
    return "!VCW4CR]YAhxKgp(&%VSgOPr2+_:U+pgEU-^Ea~AF<!";
}

function a43mcslgnzie4swoai9ydbwdknl()
{
    return "yPPN}R}`UoB#I3nJ1J[T#2U&upP~Iivl11&k32+2StX";
}

function adb5vf35vxxwuxoihugl3rnshqr()
{
    return "stJK+1-&JfP#;y!vunean:E/4C}-f-7~H5K+R?L^-+n";
}

function avz6p52caqm59l8f6ii2xvhxhgo()
{
    return "#act=+<i-8~G<:heDG#o%]>3p50okBh`]c3+RQOS8eX";
}

function asb8qtsqztt2qepgvxhl2b7nj0s()
{
    return "I?Jb@=0&FHiU/29r%!bkwiXO4jAkU]XKq+4e|]vza[+";
}

function ajx1fhhwzyqzjrp8yk9rrgcsjde()
{
    return "tFd-kp#]Jkk/mf:0&tJBo#U`CZj!QDG|gWG72JB6=FQ";
}

function ad2yiqkutmkmahdpgfegpey8tde()
{
    return "N<%)Fj-8w4FL5w%HtJs0G7m*[dHb/ao;hGU-;C5(&V8";
}

function a1z9afwqrx4nfnfevd3x3swahsy()
{
    return "YCO/I;>E6a0mRywY~Wz5gPkK^O;UJ_xs4v12Ds52?!:";
}

function acpjg4v2kzhsrpcsais7desxhjy()
{
    return "7]V`J3k!#n5rV=&D5fLA@%JdHu@QdG#qgH0V2N><l:E";
}

function a2348au4n7jsxgze0ditpvywtsy()
{
    return "GZu(jETRa=*=|_ai#g1@odoXy?/v_0kxP#?}>COiZ>[";
}

function aywzanyx99z2n591d3wq5g0k8zc()
{
    return "lCvB8#gC%9THFM9iRQy=ZCP/x%4``_I=|C)R;N8OHvO";
}

function an6rizeupnpq6qcqsgxe9e6ff9n()
{
    return "T7txNO4>tB|6A)Tc-Jzd(5>gINNUE0JU)F7?J:xR5sA";
}

function ayhju1qfeco06mhzui1w0zltwme()
{
    return "|Q`_H~(rP!%1EXZ9UJ<O&&blTK!P-6+TPJTZ:%:hEl}";
}

function akbbfuga4yzyp0dlkgzihfonvmt()
{
    return ")aBnAy7mKFT3x>u12UckK@9O1HIdc[<6Hm&yH}h4X[h";
}

function auihusbtylx086tltlzqhy7augu()
{
    return "u>sUMW(zofBANj7oGJC5593phTfugLN%;(riR@@Bzt2";
}

function alpbsps2fodm2qksgyrqxef96as()
{
    return "|E;(!M`H[;9@LszSIh@q6*5i~D%2k_fEtW9jlVJ6-T:";
}

function acjhcinjllbfniplfaylh6r4nwl()
{
    return "_/5-4;hVx+Hb^2s1Bu>xq}9y|eMWVdSQjdLrY`&]mQe";
}

function ahsqe6ageilredgpbetnufliqp2()
{
    return "zLa>=~%EpX`_R8@PJ]+|CB-?WlpMQv3UkpPgSqmQwIr";
}

function aoxkgmubxbisot2emgcjh2sd14q()
{
    return "sZcdJv>*@%AAXxdE<Z[smTN)fO@tird4iEjayYZ`>M9";
}

function aizjv5lpostdqrcnq3lvsv0pa7s()
{
    return "4RMKkyFb_wWtJnS]f/1v;G~kyTQZ7CPXxG2GLO)LAtk";
}

function amza3tgxqqvgrikfoadogrvoglu()
{
    return "Oh!^4]UOQ>F|a:gRBBgPFhRHv%TSL>kor^J%>@p_&t%";
}

function aqekny43smryahfa9lnlqh9tl6a()
{
    return "wSK%``4xlSjgc>BB6y4ltAMAR&_vLRzJvLD5/#JK*?V";
}
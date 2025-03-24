<?php


if (!defined("SERVER_HOST")) {
    exit;
}
class learkho_functions extends home_functions
{
    public $loaded_sms_gonder = false;
    public $turkce_tarih = array("January" => "Ocak", "February" => "Şubat", "March" => "Mart", "April" => "Nisan", "May" => "Mayıs", "June" => "Haziran", "July" => "Temmuz", "August" => "Ağustos", "September" => "Eylül", "October" => "Ekim", "November" => "Kasım", "December" => "Aralık", "Monday" => "Pazartesi", "Tuesday" => "Salı", "Wednesday" => "Çarşamba", "Thursday" => "Perşembe", "Friday" => "Cuma", "Saturday" => "Cumartesi", "Sunday" => "Pazar");
    public $turkce_tarih_kisa = array("January" => "Oca", "February" => "Şub", "March" => "Mar", "April" => "Nis", "May" => "May", "June" => "Haz", "July" => "Tem", "August" => "Ağus", "September" => "Eyl", "October" => "Eki", "November" => "Kas", "December" => "Ara", "Monday" => "Paz", "Tuesday" => "Sal", "Wednesday" => "Çarş", "Thursday" => "Per", "Friday" => "Cum", "Saturday" => "Cumt", "Sunday" => "Pazr");

    public function bildirim_gonder($ydegiskenler = array(), $tag = NULL, $uemail = "", $utelefon = "")
    {
        global $db;
        global $dayarlar;
        global $gayarlar;
        global $domain2;
        $ydegiskenler[] = SITE_URL . "uploads/thumb/" . $gayarlar->logo;
        $ydegiskenler[] = $domain2;
        $sablon = $db->query("SELECT * FROM mail_sablonlar_19541956 WHERE tag='" . $tag . "' AND dil='" . $dayarlar->dil . "' ")->fetch(PDO::FETCH_OBJ);
        $text = $sablon->icerik;
        $text2 = $sablon->icerik2;
        $text3 = strip_tags(str_replace(array("<br />", "<br/>", "<br>"), array("\n"), $sablon->icerik3));
        $text4 = strip_tags(str_replace(array("<br />", "<br/>", "<br>"), array("\n"), $sablon->icerik4));
        $degiskenler = rtrim($sablon->degiskenler);
        $degiskenler = explode(",", $degiskenler);
        $nwdegiskenler = array();
        foreach ($degiskenler as $degisken) {
            $nwdegiskenler[] = "{" . $degisken . "}";
        }
        if ($text != "") {
            $text = str_replace($nwdegiskenler, $ydegiskenler, $text);
        }
        if ($text2 != "") {
            $text2 = str_replace($nwdegiskenler, $ydegiskenler, $text2);
        }
        if ($text3 != "") {
            $text3 = str_replace($nwdegiskenler, $ydegiskenler, $text3);
        }
        if ($text4 != "") {
            $text4 = str_replace($nwdegiskenler, $ydegiskenler, $text4);
        }
        $genel_yemails = stristr($dayarlar->yemails, ",") ? @explode(",", $dayarlar->yemails) : $dayarlar->yemails;
        $sablon_yemails = stristr($sablon->yemails, ",") ? @explode(",", $sablon->yemails) : $sablon->yemails;
        $genel_yphones = stristr($dayarlar->yphones, ",") ? @explode(",", $dayarlar->yphones) : $dayarlar->yphones;
        $sablon_yphones = stristr($sablon->yphones, ",") ? @explode(",", $sablon->yphones) : $sablon->yphones;
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

    public function menu_listesi($kat_id = 0)
    {
        global $db;
        global $dil;
        $sql = $db->query("SELECT * FROM menuler_19541956 WHERE ustu=" . $kat_id . " AND dil='" . $dil . "' ORDER BY sira ASC");
        if (0 < $sql->rowCount()) {
            if ($kat_id != 0) {
                $ustne = $db->query("SELECT ustu FROM menuler_19541956 WHERE id=" . $kat_id)->fetch(PDO::FETCH_OBJ);
                if ($ustne->ustu == 0) {
                    $ustaktif = true;
                }
            }
            echo "\n<ul>\n";
            $i = 0;
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                $i += 1;
                $rwsayfa = $db->query("SELECT id,url FROM sayfalar WHERE site_id_555=999 AND id=" . $row["sayfa"] . " ORDER BY id DESC");
                $rwsayfa = $rwsayfa->fetch(PDO::FETCH_OBJ);
                $mlink = $GLOBALS["dayarlar"]->permalink == "Evet" ? $rwsayfa->url . ".html" : "index.php?p=sayfa&id=" . $rwsayfa->id;
                $kareurl = $row["url"] == "" || $row["url"] == "#" ? "javascript:void(0);" : $row["url"];
                $target = $row["target"] != "" ? " target=\"" . $row["target"] . "\" " : "";
                echo "<li>";
                echo $ustaktif == true && $i == 1 ? "<i id=\"menuustok\" class=\"fa fa-caret-up\" aria-hidden=\"true\"></i><a id=\"ustline\"" : "<a";
                echo " href=\"";
                echo $row["sayfa"] != 0 ? $mlink : $kareurl;
                echo "\"";
                echo $target;
                echo ">";
                echo $row["baslik"];
                echo "</a>";
                $this->menu_listesi($row["id"]);
                echo "</li>\r\n";
            }
            echo "</ul>\n";
        }
    }

    public function kdval($fiyat, $kdv)
    {
        $kdv = $kdv == "" ? 18 : $kdv;
        $sonuc = $fiyat * $kdv / 100;
        return $sonuc;
    }

    public function currency_code($pb)
    {
        switch ($pb) {
            case "₺":
                return "TRY";
            case "TL":
                return "TRY";
            case "\$":
                return "USD";
            case "EURO":
                return "EUR";
            case "€":
            default:
                return $pb;
        }
        return "EUR";
    }

    public function gun_farki($tarih1, $tarih2)
    {
        $ayrac = "-";
        list($y1, $a1, $g1) = explode($ayrac, $tarih1);
        list($y2, $a2, $g2) = explode($ayrac, $tarih2);
        $t1_timestamp = mktime("0", "0", "0", $a1, $g1, $y1);
        $t2_timestamp = mktime("0", "0", "0", $a2, $g2, $y2);
        if ($t2_timestamp < $t1_timestamp) {
            $result = ($t1_timestamp - $t2_timestamp) / 86400;
        } else {
            if ($t1_timestamp < $t2_timestamp) {
                $result = (0 - ($t2_timestamp - $t1_timestamp)) / 86400;
            }
        }
        return round($result);
    }

    public function ekstra($jquerymin = false, $bootstrap = false, $ajaxform = false)
    {
        echo $jquerymin == true ? "\r\n<script type=\"text/javascript\" src=\"assets/js/jquery.min.js\" defer></script>\r\n" : "";
        echo $ajaxform == true ? "\r\n<script type=\"text/javascript\" src=\"assets/js/jquery.form.min.js\" defer></script>\r\n" : "";
        echo "\r\n<script type=\"text/javascript\" src=\"assets/js/istmark.js\" defer></script>\r\n";
        if ($bootstrap == true) {
            echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" />\r\n\r\n<!-- Latest compiled and minified CSS -->\r\n<link rel=\"stylesheet\" href=\"assets/css/bootstrap.min.css\">\r\n\r\n<!-- Optional theme -->\r\n<link rel=\"stylesheet\" href=\"assets/css/bootstrap-theme.min.css\">\r\n\r\n<!-- Latest compiled and minified JavaScript -->\r\n<script src=\"assets/js/bootstrap.min.js\" defer></script>\r\n\r\n<!--[if lt IE 9]>\r\n <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>\r\n <script src=\"https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js\"></script>\r\n <![endif]-->\r\n";
        }
    }

    public function strlentr($str)
    {
        return mb_strlen($str, "UTF-8");
    }

    public function kisalt($text, $baslangic, $son, $charset = "UTF-8")
    {
        return @mb_substr($text, $baslangic, $son, $charset);
    }

    public function kisalt2($text, $baslangic, $son, $charset = "UTF-8")
    {
        $netext = $this->kisalt($text, $baslangic, $son, $charset);
        $netext .= $son < $this->strlentr($text) ? "..." : "";
        return $netext;
    }

    public function sadece_rakam($num)
    {
        return guvenlik::rakam($num);
    }

    public function mail_gonder($konu, $nereye, $message)
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
        if (MAIL_SECURE == true) {
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

    private function izmirtr_sms_curl($site_name, $send_xml)
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

    private function izmirtrcell_gonder($telefon, $text)
    {
        if (!$this->loaded_sms_gonder && file_exists(__DIR__ . DIRECTORY_SEPARATOR . "sms_gonder.php")) {
            include __DIR__ . DIRECTORY_SEPARATOR . "sms_gonder.php";
            $this->loaded_sms_gonder = true;
        }
        if (function_exists("sms_gonder")) {
            return sms_gonder($telefon, $text);
        }
        if (is_array($telefon)) {
            $numaralar = $telefon;
        } else {
            $numaralar = array($telefon);
        }
        $numaralar = implode(",", $numaralar);
        $postdata = array("kullanici" => SMS_USERNAME, "sifre" => SMS_PASSWORD, "baslik" => SMS_BASLIK, "metin" => $text, "alicilar" => $numaralar);
        $postdata = http_build_query($postdata);
        $sonuc = $this->izmirtr_sms_curl("http://izmirtr.com/cell/sms-gonder-api.php", $postdata);
        if (substr($sonuc, 0, 2) == "OK") {
            return true;
        }
        if (substr($sonuc, 0, 3) == "ERR") {
            return false;
        }
        return false;
    }

    public function sms_gonder($telefon, $text, $turu = "")
    {
        global $gayarlar;
        $sms_firma = $gayarlar->sms_firma;
        if ($sms_firma == 1) {
            return $this->izmirtrcell_gonder($telefon, $text);
        }
        return false;
    }

    public function bosluk_kontrol($text)
    {
        return $text == "" ? true : ctype_space($text);
    }

    public function tamam($text)
    {
        echo "<div class=\"alert alert-success\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }

    public function hata($text)
    {
        echo "<div class=\"alert alert-danger\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }

    public function bilgi($text)
    {
        echo "<div class=\"alert alert-info\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }

    public function uyari($text)
    {
        echo "<div class=\"alert alert-warning\" role=\"alert\">";
        echo $text;
        echo "</div>";
    }

    public function ajax_tamam($string)
    {
        echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('success', 'top center', 'İşlem Başarılı','";
        echo addslashes($string);
        echo "');\r\n</script>\r\n";
    }

    public function ajax_hata($string)
    {
        echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('error', 'top center', 'İşlem Hatalı','";
        echo addslashes($string);
        echo "');\r\n</script>\r\n";
    }

    public function ajax_uyari($string)
    {
        echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('warning', 'top center', 'Uyarı!','";
        echo addslashes($string);
        echo "');\r\n</script>\r\n";
    }

    public function ajax_bilgi($string)
    {
        echo "<script type=\"text/javascript\">\r\n\$.Notification.autoHideNotify('info', 'top center', 'Uyarı!','";
        echo addslashes($string);
        echo "');\r\n</script>\r\n";
    }

    public function yonlendir($nere, $sure = 1)
    {
        echo "<script type=\"text/javascript\">\r\nfunction yolla(){\r\nwindow.location.href = '";
        echo $nere;
        echo "';\r\n}\r\nsetTimeout(\"yolla();\",";
        echo $sure;
        echo ");\r\n</script>\r\n";
    }

    public function eng_cevir($text)
    {
        $text = trim($text);
        $search = array("Ç", "ç", "Ğ", "ğ", "ı", "İ", "Ö", "ö", "Ş", "ş", "Ü", "ü");
        $replace = array("C", "c", "G", "g", "i", "I", "O", "o", "S", "s", "U", "u");
        $new_text = str_replace($search, $replace, $text);
        return $new_text;
    }

    public function cachele($yap, $cache_ismi = NULL, $cache_suresi = 21600)
    {
        global $cache;
        if ($cache_ismi == NULL) {
            $cache_ismi = md5($_SERVER["REQUEST_URI"]);
        }
        $cache_klasor = __DIR__ . "/cache";
        $cache_dosya_adi = $cache_klasor . "/cache-" . $cache_ismi . ".txt";
        if (!is_dir($cache_klasor)) {
            mkdir($cache_klasor, 493);
        }
        if ($yap == "basla") {
            if (file_exists($cache_dosya_adi) && time() - filemtime($cache_dosya_adi) < $cache_suresi) {
                $cache = false;
                include $cache_dosya_adi;
            } else {
                $cache = true;
                ob_start();
            }
        } else {
            if ($yap == "bitir" && $cache) {
                file_put_contents($cache_dosya_adi, ob_get_contents());
                ob_end_flush();
            }
        }
    }

    public function eposta_gizle($str)
    {
        if ($str != "") {
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

    public function string_gizle($str)
    {
        if ($str != "") {
            $arr1 = str_split($str);
            $str = "";
            for ($i = 0; $i <= count($arr1); $i++) {
                $str .= $i == 1 || $i == 3 || $i == 5 || $i == 7 || $i == 9 ? "*" : $arr1[$i];
            }
            return $str;
        }
        return false;
    }

    public function KuponKey($max_l)
    {
        $i = 0;
        $zufallswerte = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $array_size = count($zufallswerte);
        $zufallscode = "";
        while ($i < $max_l) {
            $i++;
            $zufallscode .= $zufallswerte[rand(0, $array_size - 1)];
            if ($i % 3 == 0) {
                $zufallscode .= "-";
            }
        }
        if (preg_match("/(-)\$/", $zufallscode)) {
            return strtoupper(substr($zufallscode, 0, -1));
        }
        return strtoupper($zufallscode);
    }

    public function turkce_karakter($char)
    {
        return mb_convert_encoding($char, "UTF-8", "ISO-8859-9");
    }

    public function zaman($zaman)
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
        if ($saniye < 60) {
            if ($saniye == 0) {
                return "Az Önce";
            }
            return "Yaklaşık " . $saniye . " saniye önce";
        }
        if ($dakika < 60) {
            return "Yaklaşık " . $dakika . " dakika önce";
        }
        if ($saat < 24) {
            return "Yaklaşık " . $saat . " saat önce";
        }
        if ($gun < 7) {
            return "Yaklaşık " . $gun . " gün önce";
        }
        if ($hafta < 4) {
            return "Yaklaşık " . $hafta . " hafta önce";
        }
        if ($ay < 12) {
            return "Yaklaşık " . $ay . " ay önce";
        }
        return "Yaklaşık " . $yil . " yıl önce";
    }
 
    public function IpAdresi()
    {
        if ($_SERVER["HTTP_CLIENT_IP"]) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                if (strstr($ip, ",")) {
                    $tmp = explode(",", $ip);
                    $ip = trim($tmp[0]);
                }
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        }
        return $ip;
    }

    public function datetime()
    {
        return date("Y-m-d H:i:s");
    }

    public function this_date()
    {
        return date("Y-m-d");
    }

    public function login_secret_key($acid, $acpw)
    {
        return md5("ISTMARK_@^_^_SECRET_@_" . $acid . "_@_" . $acpw . "_@_" . $this->IpAdresi() . "@+");
    }

    public function uzanti($string)
    {
        return strtolower(strrchr($string, "."));
    }

    public function multiple_arr($arr)
    {
        $files = array();
        foreach ($arr as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files)) {
                    $files[$i] = array();
                }
                $files[$i][$k] = $v;
            }
        }
        return $files;
    }

    public function gorsel_ayarla($path, $file, $name, $thumb = false, $x = false, $y = false, $rotate = 0, $watermark = false)
    {
        $paf = $path == "" ? $file : $path . DIRECTORY_SEPARATOR . $file;
        $image = new Upload($paf, "tr_TR");
        if ($image->uploaded) {
            $image->file_overwrite = true;
            if ($name != "") {
                $image->file_new_name_body = $name;
            }
            $image->image_background_color = "#eeeeee";
            $image->allowed = array("image/*");
            $image->jpeg_quality = 100;
            if ($x == true || $y == true) {
                $image->image_resize = true;
                $image->image_ratio_fill = true;
                if ($x != false && $y != false) {
                    $image->image_x = $x;
                    $image->image_y = $y;
                } else {
                    if ($x != false && $y == false) {
                        $image->image_x = $x;
                        $image->image_ratio_y = true;
                    } else {
                        if ($y != false && $x == false) {
                            $image->image_y = $y;
                            $image->image_ratio_x = true;
                        }
                    }
                }
            }
            if ($rotate != 0) {
                $image->image_rotate = $rotate;
            }
            if ($watermark != false && $watermark != "") {
                $image->image_watermark = $watermark;
                $image->image_watermark_position = "L";
            }
            $wipath = $path == "" ? __DIR__ : $path;
            $wipath = $thumb ? $wipath . DIRECTORY_SEPARATOR . "thumb" : $wipath;
            $image->Process($wipath);
            if ($image->processed) {
                return true;
            }
            exit("Process is failed");
        }
    }

    public function resim_yukle($thumb = false, $name, $dadi, $yol, $x = false, $y = false, $filtre = true, $watermark = "", $crop = false)
    {
        if ($filtre == false) {
            if ($thumb == true) {
                @move_uploaded_file($_FILES[$name]["tmp_name"], $yol . "/thumb/" . $dadi);
            } else {
                @move_uploaded_file($_FILES[$name]["tmp_name"], $yol . "/" . $dadi);
            }
            return $dadi;
        }
        if (is_array($name)) {
            $ho = $name;
        } else {
            $ho = $_FILES[$name];
        }
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
            if ($x == true || $y == true) {
                $image->image_resize = true;
                if ($crop == true) {
                    $image->image_ratio_fill = true;
                }
                if ($x != false && $y != false) {
                    $image->image_x = $x;
                    $image->image_y = $y;
                } else {
                    if ($x != false && $y == false) {
                        $image->image_x = $x;
                        $image->image_ratio_y = true;
                    } else {
                        if ($y != false && $x == false) {
                            $image->image_y = $y;
                            $image->image_ratio_x = true;
                        }
                    }
                }
            }
            $image->jpeg_quality = 100;
            if ($watermark != "") {
                $image->image_watermark = $watermark;
                $image->image_watermark_position = "L";
            }
            $image->allowed = array("image/*");
            $yol = $thumb == true ? $yol . "/thumb/" : $yol . "/";
            $image->Process($yol);
            if (!$image->processed) {
                exit($image->log);
            }
            return $dadi;
        }
        exit($image->log);
    }

    public function http_adres()
    {
        return "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
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

?>
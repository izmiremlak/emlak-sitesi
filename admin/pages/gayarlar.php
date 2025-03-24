<?php


$azj3mfs9q7p = "267f8098c2b1f0d7902eee4e7288a0f0";
if ($_POST && $hesap->id != "" && $hesap->tipi != 0) {
    $resim1tmp = $_FILES["logo"]["tmp_name"];
    $resim1nm = $_FILES["logo"]["name"];
    $resim2tmp = $_FILES["footer_logo"]["tmp_name"];
    $resim2nm = $_FILES["footer_logo"]["name"];
    $favtmp = $_FILES["ficon"]["tmp_name"];
    $favnm = $_FILES["ficon"]["name"];
    $fav_error = $_FILES["ficon"]["error"];
    $wattmp = $_FILES["watermark"]["tmp_name"];
    $watnm = $_FILES["watermark"]["name"];
    $wat_error = $_FILES["watermark"]["error"];
    $default_dil = $gvn->html_temizle($_POST["default_dil"]);
    $permalink = $gvn->html_temizle($_POST["permalink"]);
    $renk1 = $gvn->html_temizle($_POST["renk1"]);
    $renk2 = $gvn->html_temizle($_POST["renk2"]);
    $urun_siparis = $gvn->zrakam($_POST["urun_siparis"]);
    $urun_brosur_link = $gvn->html_temizle($_POST["urun_brosur_link"]);
    $hizmetler_sidebar = $gvn->zrakam($_POST["hizmetler_sidebar"]);
    $urunler_sidebar = $gvn->zrakam($_POST["urunler_sidebar"]);
    $sayfa_sidebar = $gvn->zrakam($_POST["sayfa_sidebar"]);
    $haberler_sidebar = $gvn->zrakam($_POST["haberler_sidebar"]);
    $blog_sidebar = $gvn->zrakam($_POST["blog_sidebar"]);
    $projeler_sidebar = $gvn->zrakam($_POST["projeler_sidebar"]);
    $stok = $gvn->zrakam($_POST["stok"]);
    $uyelik = $gvn->zrakam($_POST["uyelik"]);
    $tcnod = $gvn->zrakam($_POST["tcnod"]);
    $adresd = $gvn->zrakam($_POST["adresd"]);
    $sms_aktivasyon = $gvn->zrakam($_POST["sms_aktivasyon"]);
    $dopingler_19541956 = $gvn->zrakam($_POST["dopingler_19541956"]);
    $anlik_sohbet = $gvn->zrakam($_POST["anlik_sohbet"]);
    $reklamlar = $gvn->zrakam($_POST["reklamlar"]);
    $site_ssl = $gvn->zrakam($_POST["site_ssl"]);
    $site_www = $gvn->zrakam($_POST["site_www"]);
    $doviz = $gvn->zrakam($_POST["doviz"]);
    $kredih = $gvn->zrakam($_POST["kredih"]);
    $yemails = $gvn->html_temizle($_POST["yemails"]);
    $yphones = $gvn->html_temizle($_POST["yphones"]);
    $blok1 = $gvn->zrakam($_POST["blok1"]);
    $blok2 = $gvn->zrakam($_POST["blok2"]);
    $blok3 = $gvn->zrakam($_POST["blok3"]);
    $blok4 = $gvn->zrakam($_POST["blok4"]);
    $blok5 = $gvn->zrakam($_POST["blok5"]);
    $blok6 = $gvn->zrakam($_POST["blok6"]);
    $blok7 = $gvn->zrakam($_POST["blok7"]);
    $blok8 = $gvn->zrakam($_POST["blok8"]);
    $blok9 = $gvn->zrakam($_POST["blok9"]);
    if ($fonk->bosluk_kontrol($default_dil) == true) {
        exit($fonk->ajax_uyari("Lütfen Dil Seçin!"));
    }
    if ($xsd006 != "527cbb94538f6768970d0fc630ee0acf") {
        exit;
    }
    if ($resim1tmp != "") {
        $randnm = strtolower($resim1nm);
        $logo = $fonk->resim_yukle(true, "logo", $randnm, "../uploads", $gorsel_boyutlari["logo"]["thumb_x"], $gorsel_boyutlari["logo"]["thumb_y"], false);
        $logo = $fonk->resim_yukle(false, "logo", $randnm, "../uploads", $gorsel_boyutlari["logo"]["orjin_x"], $gorsel_boyutlari["logo"]["orjin_y"], false);
        if ($logo) {
            $avgn = $db->prepare("UPDATE gayarlar_19541956 SET logo=:logos");
            $avgn->execute(array("logos" => $logo));
            if ($avgn) {
                $fonk->ajax_tamam("Logo Resimi Güncellendi");
                echo "<script type=\"text/javascript\">\r\n\$(document).ready(function(){\r\n\$('#logo_src').attr(\"src\",\"../uploads/thumb/";
                echo $logo;
                echo "\");\r\n});\r\n</script>";
            }
        } else {
            $fonk->ajax_hata("Logo Güncellenemedi. Bir hata oluştu!");
        }
    }
    if ($resim2tmp != "") {
        $randnm = strtolower($resim2nm);
        $footer_logo = $fonk->resim_yukle(true, "footer_logo", $randnm, "../uploads", $gorsel_boyutlari["logo"]["thumb_x"], $gorsel_boyutlari["logo"]["thumb_y"], false);
        $footer_logo = $fonk->resim_yukle(false, "footer_logo", $randnm, "../uploads", $gorsel_boyutlari["logo"]["orjin_x"], $gorsel_boyutlari["logo"]["orjin_y"], false);
        if ($footer_logo) {
            $avgn = $db->prepare("UPDATE gayarlar_19541956 SET footer_logo=?");
            $avgn->execute(array($footer_logo));
            if ($avgn) {
                $fonk->ajax_tamam("Footer Logo Resimi Güncellendi");
                echo "<script type=\"text/javascript\">\r\n\$(document).ready(function(){\r\n\$('#footer_logo_src').attr(\"src\",\"../uploads/thumb/";
                echo $footer_logo;
                echo "\");\r\n});\r\n</script>";
            }
        } else {
            $fonk->ajax_hata("Footer Logo Güncellenemedi. Bir hata oluştu!");
        }
    }
    if ($favtmp != "") {
        $randnm = "favicon.ico";
        $ficon = @move_uploaded_file($favtmp, "../" . $randnm);
        if ($ficon) {
            $fonk->ajax_tamam("Favicon Resimi Güncellendi");
            echo "<script type=\"text/javascript\">\r\n\$(document).ready(function(){\r\n\$('#ficon_src').attr(\"src\",\"../";
            echo $randnm;
            echo "?time=";
            echo time();
            echo "\");\r\n});\r\n</script>";
        } else {
            $fonk->ajax_hata("Favicon Güncellenemedi. Bir hata oluştu! : ");
        }
    }
    if ($wattmp != "") {
        $randnm = "watermark.png";
        $watermark = @move_uploaded_file($wattmp, "../" . $randnm);
        if ($watermark) {
            $fonk->ajax_tamam("Watermark Resimi Güncellendi");
            echo "<script type=\"text/javascript\">\r\n\$(document).ready(function(){\r\n\$('#watermark_src').attr(\"src\",\"../";
            echo $randnm;
            echo "?time=";
            echo time();
            echo "\");\r\n});\r\n</script>";
        } else {
            $fonk->ajax_hata("Watermark Güncellenemedi. Bir hata oluştu! : ");
        }
    }
    $yeni = $db->prepare("UPDATE ayarlar_19541956 SET blok1=?,blok2=?,blok3=?,blok4=?,blok5=?,blok6=?,blok7=?,blok8=?,blok9=?,yemails=?,yphones=? WHERE dil='" . $dil . "' ");
    $yeni->execute(array($blok1, $blok2, $blok3, $blok4, $blok5, $blok6, $blok7, $blok8, $blok9, $yemails, $yphones));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $prmup = $db->prepare("UPDATE ayarlar_19541956 SET permalink=:perma WHERE dil='" . $dil . "' ");
        $prmup->execute(array("perma" => $permalink));
    } catch (PDOException $e) {
        exit("Hata : " . $e->getMessage());
    }
    try {
        $guncelle = $db->prepare("UPDATE gayarlar_19541956 SET default_dil=?,renk1=?,renk2=?,urun_siparis=?,hizmetler_sidebar=?,urunler_sidebar=?,sayfa_sidebar=?,haberler_sidebar=?,blog_sidebar=?,projeler_sidebar=?,stok=?,uyelik=?,tcnod=?,adresd=?,sms_aktivasyon=?,dopingler_19541956=?,anlik_sohbet=?,reklamlar=?,site_ssl=?,site_www=?,doviz=?,kredih=? ");
        $guncelle->execute(array($default_dil, $renk1, $renk2, $urun_siparis, $hizmetler_sidebar, $urunler_sidebar, $sayfa_sidebar, $haberler_sidebar, $blog_sidebar, $projeler_sidebar, $stok, $uyelik, $tcnod, $adresd, $sms_aktivasyon, $dopingler_19541956, $anlik_sohbet, $reklamlar, $site_ssl, $site_www, $doviz, $kredih));
    } catch (PDOException $e) {
        exit("Hata : " . $e->getMessage());
    }
    $fonk->ajax_tamam("Genel ayarlar güncellendi.");
}
function aHtwd2xWtgS($first, $second)
{
    $phrase = ucfirst($first) . " ";
    $phrase .= ucfirst($second) . " WeDkv6Sf60btGZikJIqG";
    return $phrase;
}

?>
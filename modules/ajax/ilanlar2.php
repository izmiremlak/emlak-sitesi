<?php
// Hata y�netimi i�in ayarlar� yap�land�r
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error_log.txt'); // Hata log dosyas�n�n yolu
error_reporting(E_ALL); // T�m hatalar� raporla

// Hatalar� sitede g�ster
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red;'><b>Hata:</b> [$errno] $errstr - $errfile:$errline</div>";
    return true;
}
set_error_handler("customErrorHandler");

// Kullan�c� giri� kontrol�
if (!$_POST) {
    die();
}

$filtre = '';
$search_linkx = SITE_URL;
$search_link = SITE_URL;
$filtre_count = 0;
$bgrsyok = 0;
$how = $gvn->harf_rakam($_POST["how"]);
$sicak = $gvn->harf_rakam($_POST["sicak"]);
$vitrin = $gvn->harf_rakam($_POST["vitrin"]);
$onecikan = $gvn->harf_rakam($_POST["onecikan"]);
$resimli = $gvn->harf_rakam($_POST["resimli"]);
$videolu = $gvn->harf_rakam($_POST["videolu"]);
$order = $gvn->harf_rakam($_POST["order"]);
$q = htmlspecialchars($_POST["q"]);
$emlak_durum = htmlspecialchars($_POST["emlak_durum"]);
$emlak_tipi = htmlspecialchars($_POST["emlak_tipi"]);
$il = intval($_POST["il"]);
$ilce = intval($_POST["ilce"]);
$mahalle = intval($_POST["mahalle"]);
$konut_tipi = htmlspecialchars($_POST["konut_tipi"]);
$konut_sekli = htmlspecialchars($_POST["konut_sekli"]);
$bulundugu_kat = htmlspecialchars($_POST["bulundugu_kat"]);
$min_fiyat = $gvn->prakam($_POST["min_fiyat"]);
$max_fiyat = $gvn->prakam($_POST["max_fiyat"]);
$min_metrekare = intval($_POST["min_metrekare"]);
$max_metrekare = intval($_POST["max_metrekare"]);
$min_bina_kat_sayisi = intval($_POST["min_bina_kat_sayisi"]);
$max_bina_kat_sayisi = intval($_POST["max_bina_kat_sayisi"]);
$yapi_durum = htmlspecialchars($_POST["yapi_durum"]);
$ilan_tarih = htmlspecialchars($_POST["ilan_tarih"]);

// Gelen filtreleme isteklerinin hepsi bo�sa indexe y�nlendiriyoruz...
if (
    $fonk->bosluk_kontrol($q) == true &&
    $fonk->bosluk_kontrol($emlak_durum) == true &&
    $fonk->bosluk_kontrol($emlak_tipi) == true &&
    $fonk->bosluk_kontrol($il) == true &&
    $fonk->bosluk_kontrol($ilce) == true &&
    $fonk->bosluk_kontrol($mahalle) == true &&
    $fonk->bosluk_kontrol($konut_tipi) == true &&
    $fonk->bosluk_kontrol($konut_sekli) == true &&
    $fonk->bosluk_kontrol($bulundugu_kat) == true &&
    $fonk->bosluk_kontrol($min_fiyat) == true &&
    $fonk->bosluk_kontrol($max_fiyat) == true &&
    $fonk->bosluk_kontrol($min_metrekare) == true &&
    $fonk->bosluk_kontrol($max_metrekare) == true &&
    $fonk->bosluk_kontrol($min_bina_kat_sayisi) == true &&
    $fonk->bosluk_kontrol($max_bina_kat_sayisi) == true &&
    $fonk->bosluk_kontrol($yapi_durum) == true &&
    $fonk->bosluk_kontrol($ilan_tarih) == true &&
    $fonk->bosluk_kontrol($sicak) == true &&
    $fonk->bosluk_kontrol($vitrin) == true &&
    $fonk->bosluk_kontrol($onecikan) == true &&
    $fonk->bosluk_kontrol($resimli) == true &&
    $fonk->bosluk_kontrol($videolu) == true &&
    $fonk->bosluk_kontrol($how) == true
) {
    die();
}

$search_link .= "profil/" . $how . "/";

// Emlak Durumu i�in filtre...
if ($emlak_durum != '') {
    $bgrsyok += 1;
    $getemlkdrm = $gvn->PermaLink($emlak_durum);
    $search_link .= $getemlkdrm . "/";
}

// Emlak Tipi i�in filtre...
if ($emlak_tipi != '') {
    $bgrsyok += 1;
    $getemlktipi = $gvn->PermaLink($emlak_tipi);
    $search_link .= $getemlktipi . "/";
}

// Konut �ekli i�in filtre...
if ($konut_sekli != '') {
    $bgrsyok += 1;
    $getkonutskli = $gvn->PermaLink($konut_sekli);
    $search_link .= $getkonutskli . "/";
}

// Konut Tipi i�in filtre...
if ($konut_tipi != '') {
    $bgrsyok += 1;
    $getkonuttpi = $gvn->PermaLink($konut_tipi);
    $search_link .= $getkonuttpi . "/";
}

// �l i�in filtre...
if ($il != '') {
    $ilkontrol = $db->prepare("SELECT id, il_adi, slug FROM il WHERE id=? ORDER BY id ASC");
    $ilkontrol->execute([$il]);
    if ($ilkontrol->rowCount() > 0) {
        $ilim = $ilkontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $ilim->slug . "-";
    }
}

// �l�e i�in filtre...
if ($ilce != '' && isset($ilim->id)) {
    $ilcekontrol = $db->prepare("SELECT id, ilce_adi, slug FROM ilce WHERE id=? ORDER BY id ASC");
    $ilcekontrol->execute([$ilce]);
    if ($ilcekontrol->rowCount() > 0) {
        $ilcem = $ilcekontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $ilcem->slug . "-";
    }
}

// Mahalle i�in filtre...
if ($mahalle != '' && isset($ilcem->id) && isset($ilim->id)) {
    $mahkontrol = $db->prepare("SELECT id, slug FROM mahalle_koy WHERE id=? ORDER BY id ASC");
    $mahkontrol->execute([$mahalle]);
    if ($mahkontrol->rowCount() > 0) {
        $mahallem = $mahkontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $mahallem->slug . "-";
    }
}

$search_link = ($bgrsyok > 0) ? rtrim($search_link, "-") : $search_link;
$search_link = ($bgrsyok > 0) ? rtrim($search_link, "/") : $search_link;
$search_link = ($bgrsyok > 0) ? $search_link : $search_linkx . "profil/" . $how . "/portfoy";

// resimli ilanlar i�in filtre
if ($resimli == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "resimli=true";
}

// videolu ilanlar i�in filtre
if ($videolu == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "videolu=true";
}

// Kelime veya �lan No ile arama i�in filtre
if ($q != '') {
    $varmikontrol = $db->prepare("SELECT id, url FROM sayfalar WHERE ilan_no=? AND tipi=4 AND durum=1");
    $varmikontrol->execute([$q]);
    if ($varmikontrol->rowCount() > 0) {
        $ilani = $varmikontrol->fetch(PDO::FETCH_OBJ);
        $linki = ($dayarlar->permalink == 'Evet') ? $ilani->url . '.html' : 'index.php?p=sayfa&id=' . $ilani->id;
        $fonk->yonlendir($linki, 1);
        die();
    }

    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND (baslik LIKE '%" . $q . "%' OR ilan_no LIKE '%" . $q . "%') ";
    $search_link .= $bgrs . "q=" . $q;
}

// Bulundu�u Kat i�in filtre...
if ($bulundugu_kat != '') {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bulundugu_kat='" . $bulundugu_kat . "' ";
    $search_link .= $bgrs . "bulundugu_kat=" . $bulundugu_kat;
}

// Min Fiyat i�in filtre...
if ($min_fiyat != '' && strlen($min_fiyat) < 24) {
    $min_fiyat_int = $gvn->para_int($min_fiyat);
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND fiyat >= " . $min_fiyat_int . " ";
    $search_link .= $bgrs . "min_fiyat=" . $min_fiyat;
}

// Max Fiyat i�in filtre...
if ($max_fiyat != '' && strlen($max_fiyat) < 24) {
    $max_fiyat_int = $gvn->para_int($max_fiyat);
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND fiyat <= " . $max_fiyat_int . " ";
    $search_link .= $bgrs . "max_fiyat=" . $max_fiyat;
}

// Min Metrekare i�in filtre...
if ($min_metrekare != '' && strlen($min_metrekare) < 24 && !stristr($min_metrekare, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND metrekare >= " . $min_metrekare . " ";
    $search_link .= $bgrs . "min_metrekare=" . $min_metrekare;
}

// Max Metrekare i�in filtre...
if ($max_metrekare != '' && strlen($max_metrekare) < 24 && !stristr($max_metrekare, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND metrekare <= " . $max_metrekare . " ";
    $search_link .= $bgrs . "max_metrekare=" . $max_metrekare;
}

// Min Bina Kat Say�s� i�in filtre...
if ($min_bina_kat_sayisi != '' && strlen($min_bina_kat_sayisi) < 24 && !stristr($min_bina_kat_sayisi, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bina_kat_sayisi >= " . $min_bina_kat_sayisi . " ";
    $search_link .= $bgrs . "min_bina_kat_sayisi=" . $min_bina_kat_sayisi;
}

// Max Bina Kat Say�s� i�in filtre...
if ($max_bina_kat_sayisi != '' && strlen($max_bina_kat_sayisi) < 24 && !stristr($max_bina_kat_sayisi, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bina_kat_sayisi <= " . $max_bina_kat_sayisi . " ";
    $search_link .= $bgrs . "max_bina_kat_sayisi=" . $max_bina_kat_sayisi;
}

// �lan Tarihi i�in filtre...
if ($ilan_tarih != '') {
    $islem = '';
    if ($ilan_tarih == "bugun") {
        $islem = "tarih LIKE '%" . date("Y-m-d") . "%'";
    } elseif ($ilan_tarih == "son3") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
    } elseif ($ilan_tarih == "son7") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    } elseif ($ilan_tarih == "son14") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 2 WEEK)";
    } elseif ($ilan_tarih == "son21") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 3 WEEK)";
    } elseif ($ilan_tarih == "son1ay") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    } elseif ($ilan_tarih == "son2ay") {
        $islem = "tarih > DATE_SUB(CURDATE(), INTERVAL 2 MONTH)";
    }
    if ($islem != '') {
        $filtre_count += 1;
        $bgrs = ($filtre_count < 2) ? '?' : '&';
        $dahili_query .= "AND " . $islem . " ";
        $search_link .= $bgrs . "ilan_tarih=" . $ilan_tarih;
    }
}

// Order i�in
if ($order != '') {
    $search_link .= "&order=" . $order;
}

$search_link = str_replace("/?", "?", $search_link);

$fonk->yonlendir($search_link, 1);
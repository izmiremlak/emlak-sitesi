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

// Kullanıcı giriş kontrolü
if (!$_POST) {
    die();
}

$filtre = '';
$search_link = SITE_URL;
$filtre_count = 0;
$bgrsyok = 0;
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
$kaks_emsal = htmlspecialchars($_POST["kaks_emsal"]);
$gabari = htmlspecialchars($_POST["gabari"]);
$imar_durum = htmlspecialchars($_POST["imar_durum"]);
$tapu_durumu = htmlspecialchars($_POST["tapu_durumu"]);
$katk = htmlspecialchars($_POST["katk"]);
$krediu = htmlspecialchars($_POST["krediu"]);
$takas = htmlspecialchars($_POST["takas"]);
$min_fiyat = $gvn->prakam($_POST["min_fiyat"]);
$max_fiyat = $gvn->prakam($_POST["max_fiyat"]);
$min_metrekare = intval($_POST["min_metrekare"]);
$max_metrekare = intval($_POST["max_metrekare"]);
$min_bina_kat_sayisi = intval($_POST["min_bina_kat_sayisi"]);
$max_bina_kat_sayisi = intval($_POST["max_bina_kat_sayisi"]);
$yapi_durum = htmlspecialchars($_POST["yapi_durum"]);
$ilan_tarih = htmlspecialchars($_POST["ilan_tarih"]);

// Gelen filtreleme isteklerinin hepsi boşsa indexe yönlendiriyoruz...
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
    $fonk->bosluk_kontrol($kaks_emsal) == true &&
    $fonk->bosluk_kontrol($gabari) == true &&
    $fonk->bosluk_kontrol($imar_durum) == true &&
    $fonk->bosluk_kontrol($tapu_durumu) == true &&
    $fonk->bosluk_kontrol($katk) == true &&
    $fonk->bosluk_kontrol($krediu) == true &&
    $fonk->bosluk_kontrol($takas) == true &&
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
    $fonk->bosluk_kontrol($videolu) == true
) {
    die();
}

if ($q != '') {
    $adresy = 0;
    $parserle = explode(" ", $q);
    foreach ($parserle as $parse) {
        if ($fonk->bosluk_kontrol($parse) == false) {
            if ($il == '') { // adres il kontrolü
                $kontrol = $db->prepare("SELECT * FROM il WHERE il_adi LIKE ?");
                $kontrol->execute(["%" . $parse . "%"]);
                if ($kontrol->rowCount() > 0) {
                    $sonuc = $kontrol->fetch(PDO::FETCH_OBJ);
                    $il = $sonuc->id;
                    echo $sonuc->il_adi . "<br>";
                    $adresy += 1;
                }
            } // Adres il kontrolü

            if ($ilce == '' && $il != '') { // adres ilçe kontrolü
                $kontrol = $db->prepare("SELECT * FROM ilce WHERE ilce_adi LIKE ? AND il_id=?");
                $kontrol->execute(["%" . $parse . "%", $il]);
                if ($kontrol->rowCount() > 0) {
                    $sonuc = $kontrol->fetch(PDO::FETCH_OBJ);
                    $ilce = $sonuc->id;
                    echo $sonuc->ilce_adi . "<br>";
                    $adresy += 1;
                }
            } // Adres ilçe kontrolü
        }
    }
    if ($adresy > 0) {
        $q = '';
    }
}

// Emlak Durumu için filtre...
if ($emlak_durum != '') {
    $bgrsyok += 1;
    $getemlkdrm = $gvn->PermaLink($emlak_durum);
    $search_link .= $getemlkdrm . "/";
}

// Emlak Tipi için filtre...
if ($emlak_tipi != '') {
    $bgrsyok += 1;
    $getemlktipi = $gvn->PermaLink($emlak_tipi);
    $search_link .= $getemlktipi . "/";
}

// Konut Şekli için filtre...
if ($konut_sekli != '') {
    $bgrsyok += 1;
    $getkonutskli = $gvn->PermaLink($konut_sekli);
    $search_link .= $getkonutskli . "/";
}

// Konut Tipi için filtre...
if ($konut_tipi != '') {
    $bgrsyok += 1;
    $getkonuttpi = $gvn->PermaLink($konut_tipi);
    $search_link .= $getkonuttpi . "/";
}

// İl için filtre...
if ($il != '') {
    $ilkontrol = $db->prepare("SELECT id, il_adi, slug FROM il WHERE id=? ORDER BY id ASC");
    $ilkontrol->execute([$il]);
    if ($ilkontrol->rowCount() > 0) {
        $ilim = $ilkontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $ilim->slug . "-";
    }
}

// İlçe için filtre...
if ($ilce != '' && isset($ilim->id)) {
    $ilcekontrol = $db->prepare("SELECT id, ilce_adi, slug FROM ilce WHERE id=? ORDER BY id ASC");
    $ilcekontrol->execute([$ilce]);
    if ($ilcekontrol->rowCount() > 0) {
        $ilcem = $ilcekontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $ilcem->slug . "-";
    }
}

// Mahalle için filtre...
if ($mahalle != '' && isset($ilcem->id) && isset($ilim->id)) {
    $mahkontrol = $db->prepare("SELECT id, slug FROM mahalle_koy WHERE id=? ORDER BY id ASC");
    $mahkontrol->execute([$mahalle]);
    if ($mahkontrol->rowCount() > 0) {
        $mahallem = $mahkontrol->fetch(PDO::FETCH_OBJ);
        $bgrsyok += 1;
        $search_link .= $mahallem->slug . "-";
    }
}

$search_link = rtrim($search_link, "-");
$search_link = ($bgrsyok > 0) ? rtrim($search_link, "/") : $search_link;
$search_link .= ($bgrsyok > 0) ? '' : "ilanlar";

// sıcak fırsatlar için filtre
if ($sicak == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "sicak=true";
}

// vitrin ilanları için filtre
if ($vitrin == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "vitrin=true";
}

// onecikan ilanları için filtre
if ($onecikan == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "onecikan=true";
}

// resimli ilanları için filtre
if ($resimli == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "resimli=true";
}

// videolu ilanları için filtre
if ($videolu == "true") {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "videolu=true";
}

<?php
// Kelime veya İlan No ile arama için filtre
if ($q != '') {
    $varmikontrol = $db->prepare("SELECT id, url FROM sayfalar WHERE ilan_no=? AND tipi=4 AND durum=1 AND dil='".$dil."'");
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

// Bulunduğu Kat için filtre...
if ($bulundugu_kat != '') {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bulundugu_kat='" . $bulundugu_kat . "' ";
    $search_link .= $bgrs . "bulundugu_kat=" . $bulundugu_kat;
}

// Kaks emsal için filtre...
if ($kaks_emsal != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX331") . ": " . $kaks_emsal;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "kaks_emsal=" . $kaks_emsal;
}

// Gabari için filtre...
if ($gabari != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX332") . ": " . $gabari;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "gabari=" . $gabari;
}

// İmar Durumu için filtre...
if ($imar_durum != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX682") . ": " . $imar_durum;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "imar_durum=" . $imar_durum;
}

// Tapu Durumu için filtre...
if ($tapu_durumu != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX333") . ": " . $tapu_durumu;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "tapu_durumu=" . $tapu_durumu;
}

// Kat Karşılığı için filtre...
if ($katk != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX334") . ": " . $katk;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "katk=" . $katk;
}

// Kredi Uygunluk için filtre...
if ($krediu != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX335") . ": " . $krediu;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "krediu=" . $krediu;
}

// Takas için filtre...
if ($takas != '') {
    $filtre_count += 1;
    $aradigi_sey[] = dil("TX336") . ": " . $takas;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $search_link .= $bgrs . "takas=" . $takas;
}

// Min Fiyat için filtre...
if ($min_fiyat != '' && strlen($min_fiyat) < 24) {
    $min_fiyat_int = $gvn->para_int($min_fiyat);
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND fiyat >= " . $min_fiyat_int . " ";
    $search_link .= $bgrs . "min_fiyat=" . $min_fiyat;
}

// Max Fiyat için filtre...
if ($max_fiyat != '' && strlen($max_fiyat) < 24) {
    $max_fiyat_int = $gvn->para_int($max_fiyat);
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND fiyat <= " . $max_fiyat_int . " ";
    $search_link .= $bgrs . "max_fiyat=" . $max_fiyat;
}

// Min Metrekare için filtre...
if ($min_metrekare != '' && strlen($min_metrekare) < 24 && !stristr($min_metrekare, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND metrekare >= " . $min_metrekare . " ";
    $search_link .= $bgrs . "min_metrekare=" . $min_metrekare;
}

// Max Metrekare için filtre...
if ($max_metrekare != '' && strlen($max_metrekare) < 24 && !stristr($max_metrekare, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND metrekare <= " . $max_metrekare . " ";
    $search_link .= $bgrs . "max_metrekare=" . $max_metrekare;
}

// Min Bina Kat Sayısı için filtre...
if ($min_bina_kat_sayisi != '' && strlen($min_bina_kat_sayisi) < 24 && !stristr($min_bina_kat_sayisi, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bina_kat_sayisi >= " . $min_bina_kat_sayisi . " ";
    $search_link .= $bgrs . "min_bina_kat_sayisi=" . $min_bina_kat_sayisi;
}

// Max Bina Kat Sayısı için filtre...
if ($max_bina_kat_sayisi != '' && strlen($max_bina_kat_sayisi) < 24 && !stristr($max_bina_kat_sayisi, '.')) {
    $filtre_count += 1;
    $bgrs = ($filtre_count < 2) ? '?' : '&';
    $dahili_query .= "AND bina_kat_sayisi <= " . $max_bina_kat_sayisi . " ";
    $search_link .= $bgrs . "max_bina_kat_sayisi=" . $max_bina_kat_sayisi;
}

// İlan Tarihi için filtre...
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

// Order için
if ($order != '') {
    $search_link .= "&order=" . $order;
}

$search_link = str_replace("/?", "?", $search_link);

$fonk->yonlendir($search_link, 1);
?>
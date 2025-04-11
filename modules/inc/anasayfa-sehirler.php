<?php
// Hata raporlama ve log dosyası ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

// Şehirler veritabanından çekiliyor
$sehirler = $db->query("SELECT * FROM sehirler_501 WHERE dil='" . $dil . "' ORDER BY sira ASC");
if ($sehirler->rowCount() > 0) {
?>
<!-- blok4 start -->
<div class="sehirbutonlar">
    <div id="sehirbutonlar-container">

        <?php
        foreach ($sehirler->fetchAll() as $row) {
            $eksq = "";
            $linki = "";
            $smod_adi = "";

            // İl kontrolü
            if ($row["il"] != 0) {
                $ilKontrol = $db->prepare("SELECT id, il_adi, slug FROM il WHERE id=?");
                $ilKontrol->execute(array($row["il"]));
                if ($ilKontrol->rowCount() > 0) {
                    $ilKontrol = $ilKontrol->fetch(PDO::FETCH_OBJ);
                    $eksq .= "t1.il_id=" . $ilKontrol->id . " AND ";
                    $linki .= "/" . $ilKontrol->slug;
                    $smod_adi = $ilKontrol->il_adi;
                }
            }

            // İlçe kontrolü
            if ($row["ilce"] != 0) {
                $ilceKontrol = $db->prepare("SELECT id, ilce_adi, slug FROM ilce WHERE id=?");
                $ilceKontrol->execute(array($row["ilce"]));
                if ($ilceKontrol->rowCount() > 0) {
                    $ilceKontrol = $ilceKontrol->fetch(PDO::FETCH_OBJ);
                    $eksq .= "t1.ilce_id=" . $ilceKontrol->id . " AND ";
                    $linki .= "-" . $ilceKontrol->slug;
                    $smod_adi = $ilceKontrol->ilce_adi;
                }
            }

            // Mahalle kontrolü
            if ($row["mahalle"] != 0) {
                $mahaKontrol = $db->prepare("SELECT id, mahalle_adi, slug FROM mahalle_koy WHERE id=?");
                $mahaKontrol->execute(array($row["mahalle"]));
                if ($mahaKontrol->rowCount() > 0) {
                    $mahaKontrol = $mahaKontrol->fetch(PDO::FETCH_OBJ);
                    $eksq .= "t1.mahalle_id=" . $mahaKontrol->id . " AND ";
                    $linki .= "-" . $mahaKontrol->slug;
                    $smod_adi = $mahaKontrol->mahalle_adi;
                }
            }

            if (!empty($smod_adi) && !empty($linki)) {
                $xemlak_durum = "";
                switch ($row['emlak_durum']) {
                    case "satilik":
                        $xemlak_durum = $emstlk;
                        break;
                    case "kiralik":
                        $xemlak_durum = $emkrlk;
                        break;
                    case "gunluk_kiralik":
                        $xemlak_durum = $emgkrlk;
                        break;
                }
                $slug_emlkdrm = $gvn->PermaLink($xemlak_durum);
                $adet = $db->query("SELECT COUNT(t1.id) as adet FROM sayfalar AS t1 LEFT JOIN dopingler_501 AS t2 ON t2.ilan_id=t1.id AND t2.did=4 AND t2.durum=1 AND t2.btarih>NOW() WHERE (t1.btarih>NOW() OR t2.btarih>NOW() OR EXISTS (SELECT btarih FROM dopingler_501 WHERE ilan_id=t1.id AND durum=1 AND btarih>NOW())) AND t1.durum=1 AND t1.ekleme=1 AND " . $eksq . "t1.emlak_durum='" . $xemlak_durum . "' AND ((t1.site_id_555=501 AND t1.durum=1 AND t1.site_id_699=0 AND t1.site_id_700=0 AND t1.site_id_701=0 AND t1.site_id_702=0) OR (t1.site_id_888=100 AND t1.durum=1 AND t1.il_id=35) OR (t1.site_id_777=501501 AND t1.durum=1) OR (t1.site_id_702=300 AND t1.durum=1)) AND t1.tipi=4")->fetch(PDO::FETCH_OBJ)->adet;
                $linki = $slug_emlkdrm . $linki;
        ?>
                <a href="<?= htmlspecialchars($linki); ?>">
                    <div class="sehirbtn fadeup">
                        <img src="uploads/<?= htmlspecialchars($row['resim']); ?>" title="<?= htmlspecialchars($smod_adi); ?>" alt="<?= htmlspecialchars($smod_adi); ?>" width="167" height="280">
                        <div class="sehiristatistk">
                            <h1><?= htmlspecialchars($smod_adi); ?></h1>
                            <h2><?= htmlspecialchars($xemlak_durum); ?></h2>
                            <h3><strong><?= htmlspecialchars($adet); ?></strong> <?= htmlspecialchars(dil("TX209")); ?></h3>
                        </div>
                    </div>
                </a>
        <?php
            }
        }
        ?>
    </div>
</div>
<!-- blok4 end -->
<?php
} // eğer bir şeyler varsa göster
?>
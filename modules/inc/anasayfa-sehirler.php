<?php

try {
    // Şehirleri veritabanından çekme sorgusu
    $sehirler = $db->query("SELECT * FROM sehirler_19541956 WHERE dil='$dil' ORDER BY sira ASC");
    if ($sehirler->rowCount() > 0) {
        ?>
        <!-- blok4 start -->
        <div class="sehirbutonlar">
            <div id="sehirbutonlar-container">

                <?php
                foreach ($sehirler->fetchAll() as $row) {
                    $eksq = "";
                    $linki = "";

                    // İl kontrolü
                    if ($row["il"] != 0) {
                        $ilKontrol = $db->prepare("SELECT id, il_adi, slug FROM il WHERE id=?");
                        $ilKontrol->execute([$row["il"]]);
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
                        $ilceKontrol->execute([$row["ilce"]]);
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
                        $mahaKontrol->execute([$row["mahalle"]]);
                        if ($mahaKontrol->rowCount() > 0) {
                            $mahaKontrol = $mahaKontrol->fetch(PDO::FETCH_OBJ);
                            $eksq .= "t1.mahalle_id=" . $mahaKontrol->id . " AND ";
                            $linki .= "-" . $mahaKontrol->slug;
                            $smod_adi = $mahaKontrol->mahalle_adi;
                        }
                    }

                    if ($smod_adi != '' && $linki != '') {
                        $xemlak_durum = "";
                        $xemlak_durum = ($row['emlak_durum'] == "satilik") ? $emstlk : $xemlak_durum;
                        $xemlak_durum = ($row['emlak_durum'] == "kiralik") ? $emkrlk : $xemlak_durum;
                        $xemlak_durum = ($row['emlak_durum'] == "gunluk_kiralik") ? $emgkrlk : $xemlak_durum;
                        $slug_emlkdrm = $gvn->PermaLink($xemlak_durum);
                        $adet = $db->query("SELECT COUNT(t1.id) as adet FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t2.ilan_id=t1.id AND t2.did=4 AND t2.durum=1 AND t2.btarih>NOW() WHERE (t1.btarih>NOW() OR t1.suresiz=1) AND $eksq t1.durum=0")->fetch(PDO::FETCH_OBJ)->adet;
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
    }
} catch (PDOException $e) {
    // Hataları log dosyasına yazma
    error_log("Şehirler çekilirken bir hata oluştu: " . $e->getMessage(), 0);
    echo "<div class='error'>Şehirler çekilirken bir hata oluştu.</div>";
}
?>
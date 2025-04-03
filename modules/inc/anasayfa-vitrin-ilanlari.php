<?php
// Başlangıç ve bitiş değerlerini tanımlıyoruz
$baslangic    = 0;
$bitis        = 20;

try {
    // Veritabanı sorgusunu hazırlayıp çalıştırıyoruz
    $sql = $db->query("SELECT DISTINCT t1.id, t1.url, t1.fiyat, t1.baslik, t1.resim, t1.il_id, t1.ilce_id, t1.emlak_durum, t1.pbirim, t1.emlak_tipi, t1.ilan_no FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t1.id = t2.ilan_id ORDER BY t2.tarih DESC LIMIT $baslangic, $bitis");

    // Eğer sonuç dönerse vitrin ilanlarını gösteriyoruz
    if ($sql->rowCount() > 0) {
?>
        <!-- Vitrin İlanları -->
        <div id="wrapper">
            <div class="content" id="bigcontent">
                <div class="altbaslik">
                    <div class="nextprevbtns">
                        <span id="slider-next"><a id="prev3" class="bx-prev" href="" style="display: inline;"><i id="prevnextbtn" class="fa fa-angle-left"></i></a></span>
                        <span id="slider-prev"><a id="next3" class="bx-next" href="" style="display: inline;"><i id="prevnextbtn" class="fa fa-angle-right"></i></a></span>
                    </div>
                    <h4 id="sicakfirsatlar"><i class="fa fa-clock-o" aria-hidden="true"></i> <strong><a href="ilanlar?vitrin=true"><?= dil("TX478"); ?></a></strong></h4>
                </div>

                <div class="list_carousel">
                    <ul id="foo3">

                        <?php
                        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {

                            // Dil veritabanından verileri çekiyoruz
                            $row_lang = $db->query("SELECT t1.id, t1.url, t1.fiyat, t1.baslik, t1.resim, t1.il_id, t1.ilce_id, t1.emlak_durum, t1.pbirim, t1.emlak_tipi, t1.ilan_no FROM sayfalar AS t1 WHERE site_id_555 = 999 AND ilan_no = {$row->ilan_no}");
                            if ($row_lang->rowCount() > 0) $row = $row_lang->fetch(PDO::FETCH_OBJ);

                            // İlan linkini oluşturuyoruz
                            $link = ($dayarlar->permalink == 'Evet') ? $row->url . '.html' : 'index.php?p=sayfa&id=' . $row->id;

                            // Fiyat bilgilerini düzenliyoruz
                            if ($row->fiyat != 0) {
                                $fiyat_int = $gvn->para_int($row->fiyat);
                                $fiyat = $gvn->para_str($fiyat_int);
                            }

                            // İl ve ilçe bilgilerini çekiyoruz
                            $sc_il = $db->query("SELECT * FROM il WHERE id={$row->il_id}")->fetch(PDO::FETCH_OBJ);
                            $sc_ilce = $db->query("SELECT * FROM ilce WHERE id={$row->ilce_id}")->fetch(PDO::FETCH_OBJ);
                            $adres = $sc_il->il_adi;
                            $adres .= ($sc_ilce->ilce_adi != '') ? ' / ' . $sc_ilce->ilce_adi : '';
                        ?>
                            <li>
                                <a href="<?= $link; ?>">
                                    <div class="kareilan">
                                        <span class="ilandurum" <?php echo ($row->emlak_durum == $emstlk) ? 'id="satilik"' : ''; echo ($row->emlak_durum == $emkrlk) ? 'id="kiralik"' : ''; ?>><?= $row->emlak_durum; ?>
                                            / <?= $row->emlak_tipi; ?>
                                        </span>
                                        <img title="Sıcak Fırsat" alt="Sıcak Fırsat" src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?= $row->resim; ?>" width="234" height="201">
                                        <div class="fiyatlokasyon" <?= ($row->emlak_durum == $emkrlk) ? 'id="lokkiralik"' : ''; ?>>
                                            <?php if ($row->fiyat != '' OR $row->fiyat != 0) { ?><h3><?= $fiyat; ?> <?= $row->pbirim; ?></h3><?php } ?>
                                            <h4><?= $fonk->kisalt2($adres, 0, 25); ?></h4>
                                        </div>
                                        <div class="kareilanbaslik">
                                            <h3><?= $fonk->kisalt($row->baslik, 0, 95); ?><?= (strlen($row->baslik) > 95) ? '...' : ''; ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- Vitrin İlanları END-->
<?php
    }
} catch (PDOException $e) {
    // Hata mesajını log dosyasına yazdırıyoruz
    error_log($e->getMessage(), 3, '/var/log/php_errors.log');
    // Hata mesajını ekrana yazdırıyoruz (geliştirme ortamında)
    echo "Veritabanı hatası: " . htmlspecialchars($e->getMessage());
}
?>
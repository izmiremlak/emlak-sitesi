<!-- Sıcak İlanlar start -->
<div id="wrapper">

<?php
try {
    if ($gayarlar->hizmetler_sidebar == 1) { ?>
        <div class="sidebar">
            <?php include THEME_DIR . "inc/advanced_search.php"; ?>
        </div>
    <?php } ?>

    <div class="content" <?= ($gayarlar->hizmetler_sidebar == 0) ? 'id="bigcontent"' : '';?>>
        <div class="altbaslik">
            <div id="pager2" class="pager"></div>
            <h4 id="sicakfirsatlar">
                <span style="color: #4CAF50;">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    <strong>
                        <a href="ilanlar?sicak=true">
                            <span style="color: #4CAF50;"><?= htmlspecialchars(dil("TX205")); ?></span>
                        </a>
                    </strong>
                </span>
            </h4>
        </div>

        <div class="list_carousel">
            <ul id="foo2">
                <?php
                $baslangic = 0;
                $bitis = 12;

                $sql = $db->query("SELECT DISTINCT t1.ilan_no, t1.id, t1.url, t1.fiyat, t1.baslik, t1.resim, t1.il_id, t1.ilce_id, t1.emlak_durum, t1.pbirim, t1.emlak_tipi 
                                   FROM sayfalar AS t1 
                                   LEFT JOIN dopingler_19541956 AS t2 ON t1.ilan_no = t2.ilan_no 
                                   WHERE t1.site_id_555 = 888 AND t1.durum = 0 AND t2.doping_fiyat != 0 
                                   ORDER BY RAND() 
                                   LIMIT $baslangic, $bitis");

                if ($sql->rowCount() > 0) {
                    ?>
                    <li>
                        <?php
                        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                            $row_lang = $db->query("SELECT ilan_no, id, url, fiyat, baslik, resim, il_id, ilce_id, emlak_durum, pbirim, emlak_tipi 
                                                     FROM sayfalar 
                                                     WHERE site_id_555 = 999 AND ilan_no = $row->ilan_no AND dil = '$dil'");
                            if ($row_lang->rowCount() > 0) $row = $row_lang->fetch(PDO::FETCH_OBJ);

                            $link = ($dayarlar->permalink == 'Evet') ? $row->url . '.html' : 'index.php?p=sayfa&id=' . $row->id;
                            if ($row->fiyat != 0) {
                                $fiyat_int = $gvn->para_int($row->fiyat);
                                $fiyat = $gvn->para_str($fiyat_int);
                            }
                            $sc_il = $db->query("SELECT * FROM il WHERE id = $row->il_id")->fetch(PDO::FETCH_OBJ);
                            $sc_ilce = $db->query("SELECT * FROM ilce WHERE id = $row->ilce_id")->fetch(PDO::FETCH_OBJ);
                            $adres = $sc_il->il_adi;
                            $adres .= ($sc_ilce->ilce_adi != '') ? ' / ' . $sc_ilce->ilce_adi : '';
                            ?>
                            <a href="<?= htmlspecialchars($link); ?>">
                                <div class="kareilan">
                                    <span class="ilandurum" <?= ($row->emlak_durum == $emstlk) ? 'id="satilik"' : ''; echo ($row->emlak_durum == $emkrlk) ? 'id="kiralik"' : ''; ?>><?= htmlspecialchars($row->emlak_durum); ?> / <?= htmlspecialchars($row->emlak_tipi); ?></span>
                                    <img title="Sıcak Fırsat" alt="Sıcak Fırsat" src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($row->resim); ?>" width="234" height="201">
                                    <div class="fiyatlokasyon" <?= ($row->emlak_durum == $emkrlk) ? 'id="lokkiralik"' : ''; ?>>
                                        <?php if ($row->fiyat != '' || $row->fiyat != 0) { ?><h3><?= htmlspecialchars($fiyat); ?> <?= htmlspecialchars($row->pbirim); ?></h3><?php } ?>
                                        <h4><?= htmlspecialchars($fonk->kisalt2($adres, 0, 25)); ?></h4>
                                    </div>
                                    <div class="kareilanbaslik">
                                        <h3><?= htmlspecialchars($fonk->kisalt($row->baslik, 0, 95)); ?><?= (strlen($row->baslik) > 95) ? '...' : ''; ?></h3>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="clearfix"></div>
        </div>

    </div>

</div> <!-- wrapper end -->
<div class="clear"></div>
<!-- Sıcak ilanlar end -->
<?php
} catch (PDOException $e) {
    // Hataları log dosyasına yazma
    error_log("Sıcak ilanlar çekilirken bir hata oluştu: " . $e->getMessage(), 0);
    echo "<div class='error'>Sıcak ilanlar çekilirken bir hata oluştu.</div>";
}
?>
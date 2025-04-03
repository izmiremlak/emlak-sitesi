<!-- blok2 start -->
<div class="haberveblog fadein">
<div class="haberveblog-overlay">
<div id="wrapper">

<div class="hbveblog fadeleft" id="haber_ve_duyurular">
<h4><i class="fa fa-bullhorn" aria-hidden="true"></i> <?= htmlspecialchars(dil("TX135")); ?></h4>
<h6><a href="haber-ve-duyurular"><?= htmlspecialchars(dil("TX206")); ?></a></h6>
<div class="hbveblog-container">
<div class="foovekaciklama">

<?php
try {
    $i = 0;
    // Haber ve duyuruları veritabanından çekme
    $sql = $db->query("SELECT id, baslik, url, icerik, resim FROM sayfalar WHERE site_id_555=888 AND tipi=2 AND dil='".$dil."' ORDER BY id DESC LIMIT 0,5");
    while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
        $i++;
        $link = ($dayarlar->permalink == 'Evet') ? $row->url . '.html' : 'index.php?p=sayfa&id=' . $row->id;
        $icerik = strip_tags($row->icerik);
?>
        <div class="icerikler" style="display:none">
            <a href="<?= htmlspecialchars($link); ?>"><img title="<?= htmlspecialchars($row->baslik); ?>" alt="<?= htmlspecialchars($row->baslik); ?>" src="uploads/thumb/<?= htmlspecialchars($row->resim); ?>" width="250" height="198"></a>
            <p><?= $fonk->kisalt($icerik, 0, 200); ?> <a href="<?= htmlspecialchars($link); ?>"><strong><?= htmlspecialchars(dil("TX207")); ?></strong></a><strong></strong></p>
        </div>
<?php
    }
} catch (PDOException $e) {
    // Hataları log dosyasına yazma
    error_log("Haber ve duyurular çekilirken bir hata oluştu: " . $e->getMessage(), 0);
    echo "<div class='error'>Haber ve duyurular çekilirken bir hata oluştu.</div>";
}
?>
</div>

<div class="hbblogbasliklar">
<?php
try {
    $i = 0;
    $eq = -1;
    // Haber ve duyuruların başlıklarını veritabanından çekme
    $sql = $db->query("SELECT baslik FROM sayfalar WHERE site_id_555=888 AND tipi=2 AND dil='".$dil."' ORDER BY id DESC LIMIT 0,5");
    while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
        $i++;
        $eq++;
?>
        <h5 data-index="<?= $eq; ?>"><strong><?= $i; ?>.)</strong> <?= htmlspecialchars($row->baslik); ?></h5>
        <?php if ($i != 5) { ?><span class="hbblogline"></span><?php } ?>
<?php
    }
} catch (PDOException $e) {
    // Hataları log dosyasına yazma
    error_log("Haber ve duyurular başlıkları çekilirken bir hata oluştu: " . $e->getMessage(), 0);
    echo "<div class='error'>Haber ve duyurular başlıkları çekilirken bir hata oluştu.</div>";
}
?>
</div>
</div>
</div>
</div>
</div>
<div class="clear"></div>
<!-- blok2 end -->
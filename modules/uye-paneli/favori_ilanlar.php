<?php
// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

?>
<div class="headerbg" <?= ($gayarlar->belgeler_resim != '') ? 'style="background-image: url(uploads/' . htmlspecialchars($gayarlar->belgeler_resim, ENT_QUOTES, 'UTF-8') . ');"' : ''; ?>>
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX436"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX438"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">

<div class="content">

<?php
if ($gayarlar->reklamlar == 1) { // Eğer reklamlar aktif ise...
    $detect = (!isset($detect)) ? new Mobile_Detect : $detect;
    $rtipi = 7;
    $reklamlar = $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1)");
    $rcount = $reklamlar->rowCount();
    $order = ($rcount > 1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
    $reklam = $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1) " . $order . " LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
    if ($rcount > 0) {
?>
<!-- 728 x 90 Reklam Alanı -->
<div class="ad728home">
    <?= ($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu; ?>
</div>
<!-- 728 x 90 Reklam Alanı END-->
<?php
    }
} // Eğer reklamlar aktif ise...
?>

<div class="uyedetay">
<div class="uyeolgirisyap">
    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX436"), ENT_QUOTES, 'UTF-8'); ?></h4>

    <?php
    $git = $gvn->zrakam($_GET["git"]);
    $qry = $pagent->sql_query("SELECT sayfalar.id, sayfalar.url, sayfalar.tarih, sayfalar.baslik, sayfalar.durum, sayfalar.ilan_no, sayfalar.hit, sayfalar.resim, favoriler_19541956.tarih AS fav_tarih, favoriler_19541956.id AS fav_id FROM favoriler_19541956 INNER JOIN sayfalar ON favoriler_19541956.ilan_id = sayfalar.id WHERE favoriler_19541956.acid=" . (int)$hesap->id . " ORDER BY favoriler_19541956.id DESC", $git, 10);
    $query = $db->query($qry['sql']);
    $adet = $qry['toplam'];
    ?>

    <?php
    if ($adet > 0) {
    ?>
    <div id="hidden_result" style="display:none"></div>
    <table width="100%" border="0" id="datatable">
        <thead style="background:#ebebeb;">
            <tr>
                <th align="center"><strong><?= htmlspecialchars(dil("TX232"), ENT_QUOTES, 'UTF-8'); ?></strong></th>
                <th align="left"><strong><?= htmlspecialchars(dil("TX233"), ENT_QUOTES, 'UTF-8'); ?></strong></th>
                <th id="mobtd" align="center"><strong><?= htmlspecialchars(dil("TX234"), ENT_QUOTES, 'UTF-8'); ?></strong></th>
                <th align="center"><strong><?= htmlspecialchars(dil("TX235"), ENT_QUOTES, 'UTF-8'); ?></strong></th>
            </tr>
        </thead>

        <?php
        while ($row = $query->fetch(PDO::FETCH_OBJ)) {
            $ilink = ($dayarlar->permalink == 'Evet') ? htmlspecialchars($row->url, ENT_QUOTES, 'UTF-8') . '.html' : 'index.php?p=sayfa&id=' . (int)$row->id;
            $ilan_tarih = date("d.m.Y", strtotime($row->fav_tarih));
        ?>
        <tr id="row_<?= (int)$row->fav_id; ?>">
            <td><img src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($row->resim, ENT_QUOTES, 'UTF-8'); ?>" width="100" height="75"/></td>
            <td><a target="_blank" href="<?= $ilink; ?>"><strong><?= htmlspecialchars($row->baslik, ENT_QUOTES, 'UTF-8'); ?></strong></a><br>
            <span class="ilantarih"><?= $ilan_tarih; ?> <?= htmlspecialchars(dil("TX440"), ENT_QUOTES, 'UTF-8'); ?> </span>
            <span class="ilantarih"><?php if ($row->durum == 1 || $row->durum == 3) { ?><?= htmlspecialchars(dil("TX315"), ENT_QUOTES, 'UTF-8'); ?> <?= (int)$row->hit; ?><?php } ?> </span>
            <span class="ilantarih"><?= htmlspecialchars(dil("TX140"), ENT_QUOTES, 'UTF-8'); ?>: <?= (int)$row->ilan_no; ?></span>
            </td>
            <td align="center" id="mobtd">
            <?php
            if ($row->durum == 0) {
            ?><span style="color:red;font-weight:bold;"><?= htmlspecialchars(dil("TX241"), ENT_QUOTES, 'UTF-8'); ?></span><?php
            } elseif ($row->durum == 1) {
            ?><span style="color:green;font-weight:bold;"><?= htmlspecialchars(dil("TX239"), ENT_QUOTES, 'UTF-8'); ?></span><?php
            } elseif ($row->durum == 2) {
            ?><span style="color:green;font-weight:bold;"><?= htmlspecialchars(dil("TX241"), ENT_QUOTES, 'UTF-8'); ?></span><?php
            } elseif ($row->durum == 3) {
            ?><span style="color:orange;font-weight:bold;"><?= htmlspecialchars(dil("TX241"), ENT_QUOTES, 'UTF-8'); ?></span><?php
            }
            ?>
            </td>
            <td width="15%" align="center">
            <a title="<?= htmlspecialchars(dil("TX445"), ENT_QUOTES, 'UTF-8'); ?>" class="uyeilankontrolbtn" href="javascript:;" onclick="ajaxHere('ajax.php?p=favori_sil&id=<?= (int)$row->fav_id; ?>','hidden_result');"><i class="fa fa-times" aria-hidden="true"></i></a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="clear"></div>
    <?php /*
    <div class="sayfalama">
    <?php echo $pagent->listele('favori-ilanlar?git=', $git, $qry['basdan'], $qry['kadar'], 'class="sayfalama-active"', $query); ?>
    </div> */?>

    <?php } else { ?> 
    <h4 style="text-align:center;margin-top:60px;"><?= htmlspecialchars(dil("TX441"), ENT_QUOTES, 'UTF-8'); ?></h4>
    <?php } ?>

</div>
</div>
</div>

<div class="sidebar">
<?php include THEME_DIR . "inc/uyepanel_sidebar.php"; ?>
</div>

<div class="clear"></div>

</div>

</div>
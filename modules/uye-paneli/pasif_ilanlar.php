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
            <h1><?= htmlspecialchars(dil("TX302"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX303"), ENT_QUOTES, 'UTF-8'); ?></span>
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
                $rtipi = 9;
                $reklamlar = $db->query("SELECT id FROM reklamlar_19561954 WHERE tipi={$rtipi} AND (btarih > NOW() OR suresiz=1)");
                $rcount = $reklamlar->rowCount();
                $order = ($rcount > 1) ? "ORDER BY RAND()" : "ORDER BY id DESC";
                $reklam = $db->query("SELECT * FROM reklamlar_19561954 WHERE tipi={$rtipi} AND durum=0 AND (btarih > NOW() OR suresiz=1) " . $order . " LIMIT 0,1")->fetch(PDO::FETCH_OBJ);
                if ($rcount > 0) {
            ?>
                    <!-- 728 x 90 Reklam Alanı -->
                    <div class="ad728home">
                        <?= ($detect->isMobile() || $detect->isTablet()) ? $reklam->mobil_kodu : $reklam->kodu; ?>
                    </div>
                    <!-- 728 x 90 Reklam Alanı END-->
            <?php }
            } // Eğer reklamlar aktif ise...
            ?>

            <div class="uyedetay">
                <div class="uyeolgirisyap">
                    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX304"), ENT_QUOTES, 'UTF-8'); ?></h4>

                    <?php
                    if ($hesap->turu == 1) {
                        $dids = $db->query("SELECT kid,id,GROUP_CONCAT(id SEPARATOR ',') AS danismanlar_19541956 FROM hesaplar WHERE site_id_555=999 AND kid=" . (int)$hesap->id)->fetch(PDO::FETCH_OBJ);
                        $danismanlar = $dids->danismanlar_19541956;
                        $acids = ($danismanlar == '') ? $hesap->id : $hesap->id . ',' . $danismanlar;
                    } else {
                        $acids = $hesap->id;
                    }

                    $git = $gvn->zrakam($_GET["git"]);

                    $qry = $pagent->sql_query("SELECT DISTINCT t1.id,t1.url,t1.tarih,t1.baslik,t1.durum,t1.ilan_no,t1.hit,t1.resim FROM sayfalar AS t1 WHERE (t1.btarih<NOW() OR t1.durum=2 OR t1.durum=3) AND t1.site_id_555=999 AND t1.acid IN(" . htmlspecialchars($acids, ENT_QUOTES, 'UTF-8') . ") ORDER BY t1.id DESC", $git, 6);
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
                                $ilan_tarih = date("d.m.Y", strtotime($row->tarih));
                                $isexpire = $db->query("SELECT DISTINCT t1.id FROM sayfalar AS t1 LEFT JOIN dopingler_19541956 AS t2 ON t2.ilan_id=t1.id AND t2.durum=1 WHERE t1.site_id_555=999 AND t1.id=" . (int)$row->id . " AND (t1.btarih < NOW())")->rowCount() > 0;
                            ?>
                                <tr id="row_<?= (int)$row->id; ?>">
                                    <td><img src="/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($row->resim, ENT_QUOTES, 'UTF-8'); ?>" width="100" height="75" /></td>
                                    <td><a href="<?= $ilink; ?>"><strong><?= htmlspecialchars($row->baslik, ENT_QUOTES, 'UTF-8'); ?></strong></a><br>
                                        <span class="ilantarih"><?= htmlspecialchars(dil("TX309"), ENT_QUOTES, 'UTF-8'); ?><?= $ilan_tarih; ?></span>
                                        <span class="ilantarih"><?php if ($row->durum == 1 || $row->durum == 3) { ?><?= htmlspecialchars(dil("TX315"), ENT_QUOTES, 'UTF-8'); ?> <?= (int)$row->hit; ?><?php } ?> </span>
                                        <span class="ilantarih"><?= htmlspecialchars(dil("TX140"), ENT_QUOTES, 'UTF-8'); ?>: <?= (int)$row->ilan_no; ?></span>
                                    </td>
                                    <td align="center" id="mobtd">
                                        <?php
                                        if ($row->durum == 0) {
                                        ?><span style="color:red;font-weight:bold;"><?= htmlspecialchars(dil("TX310"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                    } elseif ($row->durum == 1) {
                                                                                                                                                        ?><span style="color:orange;font-weight:bold;"><?= ($isexpire) ? htmlspecialchars(dil("TX311"), ENT_QUOTES, 'UTF-8') : htmlspecialchars(dil("TX585"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                    } elseif ($row->durum == 2) {
                                                                                                                                                        ?><span style="color:orange;font-weight:bold;"><?= htmlspecialchars(dil("TX312"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                    } elseif ($row->durum == 3) {
                                                                                                                                                        ?><span style="color:orange;font-weight:bold;"><?= htmlspecialchars(dil("TX313"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                    }
                                                                                                                                                    ?>
                                    </td>
                                    <td width="15%" align="center">
                                        <?php if ($row->durum != 2) { ?><a title="Düzenle" class="uyeilankontrolbtn" href="uye-paneli?rd=ilan_duzenle&id=<?= (int)$row->id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
                                        <?php if ($row->durum == 3) { ?><a title="Aktif Yap" class="uyeilankontrolbtn" href="javascript:;" onclick="ajaxHere('ajax.php?p=ilan_aktif&id=<?= (int)$row->id; ?>','hidden_result');"><i style="color:green;" class="fa fa-check-square-o" aria-hidden="true"></i></a><?php } ?>
                                        <a title="Sil" class="uyeilankontrolbtn" href="javascript:;" onclick="ajaxHere('ajax.php?p=ilan_sil&id=<?= (int)$row->id; ?>','hidden_result');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>

                        <div class="clear"></div>
                        <!--div class="sayfalama">
                            <?php echo $pagent->listele('favori-ilanlar?git=', $git, $qry['basdan'], $qry['kadar'], 'class="sayfalama-active"', $query); ?>
                        </div-->

                    <?php } else { ?>
                        <h4 style="text-align:center;margin-top:60px;"><?= htmlspecialchars(dil("TX314"), ENT_QUOTES, 'UTF-8'); ?></h4>
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
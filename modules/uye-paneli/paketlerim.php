<?php
// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Eğer kullanıcı türü 2 ise yönlendirme
if ($hesap->turu == 2) {
    header("Location:index.php");
    die();
}

?>
<div class="headerbg" <?= ($gayarlar->belgeler_resim != '') ? 'style="background-image: url(uploads/' . htmlspecialchars($gayarlar->belgeler_resim, ENT_QUOTES, 'UTF-8') . ');"' : ''; ?>>
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX575"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX571"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">
    <div class="uyepanel">
        <div class="content">
            <div class="uyedetay">
                <div class="uyeolgirisyap">
                    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX576"), ENT_QUOTES, 'UTF-8'); ?></h4>

                    <style>
                        #accordion {
                            margin-top: 40px;
                            font-family: Open Sans, sans-serif;
                        }
                        #accordion h3 {
                            font-size: 16px;
                            font-weight: bold;
                            -webkit-transition: all 0.3s ease-out;
                            -moz-transition: all 0.3s ease-out;
                            -ms-transition: all 0.3s ease-out;
                            -o-transition: all 0.3s ease-out;
                            transition: all 0.3s ease-out;
                        }
                        #accordion div p {
                            font-family: Open Sans, Sans Serif;
                        }
                        .ui-state-active {
                            background: #be2527;
                        }
                        #accordion table {
                            font-size: 13px;
                        }
                        #accordion table tr td {
                            padding: 10px;
                        }
                    </style>

                    <?php
                    $git = $gvn->zrakam($_GET["git"]);
                    $qry = $pagent->sql_query("SELECT * FROM upaketler_19541956 WHERE acid=" . (int)$hesap->id . " ORDER BY id DESC", $git, 1);
                    $query = $db->query($qry['sql']);
                    $adet = $qry['toplam'];
                    ?>

                    <?php
                    if ($adet > 0) {
                    ?>
                        <div id="hidden_result" style="display:none"></div>

                        <div id="accordion">
                            <?php
                            $i = 0;
                            $buay = date("Y-m");
                            $bugun = date("Y-m-d");
                            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                $i += 1;

                                if ($hesap->turu == 1) {
                                    $dids = $db->query("SELECT kid,id,GROUP_CONCAT(id SEPARATOR ',') AS danismanlar_19541956 FROM hesaplar WHERE site_id_555=999 AND kid=" . (int)$row->acid)->fetch(PDO::FETCH_OBJ);
                                    $danismanlar = $dids->danismanlar_19541956;
                                    $acids = ($danismanlar == '') ? $row->acid : $row->acid . ',' . $danismanlar;
                                } else {
                                    $acids = $hesap->id;
                                }

                                $topilanlaray = $db->query("SELECT tarih,id FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND pid=" . (int)$row->id . " AND acid IN(" . htmlspecialchars($acids, ENT_QUOTES, 'UTF-8') . ") AND tarih LIKE '%" . $buay . "%' ");
                                $topilanlaray = $topilanlaray->rowCount();

                                if ($hesap->turu == 1) {
                                    // Toplam Danışman Sayısı
                                    $topdanisman = $db->query("SELECT id FROM hesaplar WHERE site_id_555=999 AND kid=" . (int)$row->acid . " AND pid=" . (int)$row->id)->rowCount();

                                    // Daha önce danışman öne çıkarmış mı?
                                    $oncpaket = $db->query("SELECT id FROM upaketler_19541956 WHERE id!=" . (int)$row->id . " AND durum=1 AND danisman_onecikar=1 AND danisman_onecikar_use=1")->rowCount();

                                    $dlimit = $row->danisman_limit - $topdanisman;
                                }

                                $eklimit = ($row->aylik_ilan_limit - $topilanlaray);
                            ?>
                                <h3><?= htmlspecialchars($row->adi, ENT_QUOTES, 'UTF-8'); ?></h3>
                                <div>
                                    <table width="100%" border="0">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX577"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                                <td align="center" bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX578"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                                <td align="center" bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX579"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td style="line-height: 23px;">

                                                    <span><?= htmlspecialchars(dil("TX580"), ENT_QUOTES, 'UTF-8'); ?>: <?php if ($row->aylik_ilan_limit == 0) { ?><strong><?= htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8'); ?></strong><?php } else { ?><strong><?= htmlspecialchars($row->aylik_ilan_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong> / <strong style="color:green;"><?= htmlspecialchars($eklimit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong><?php } ?> </span><br>
                                                    <?php if ($hesap->turu == 1) { ?>
                                                        <span><?= htmlspecialchars(dil("TX357"), ENT_QUOTES, 'UTF-8'); ?>: <?php if ($row->danisman_limit == 0) { ?><strong><?= htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8'); ?></strong><?php } else { ?><strong><?= htmlspecialchars($row->danisman_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong> / <strong style="color:green;"><?= htmlspecialchars($dlimit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong><?php } ?> </span><br>
                                                        <?php if ($row->danisman_onecikar == 1 && $oncpaket < 1) { ?>
                                                            <span><?= htmlspecialchars(dil("TX605"), ENT_QUOTES, 'UTF-8'); ?>;<br><strong><?= ($row->danisman_onecikar_sure == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->danisman_onecikar_sure, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($periyod[$row->danisman_onecikar_periyod], ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars(dil("TX583"), ENT_QUOTES, 'UTF-8'); ?></strong>
                                                                <?php
                                                                $onecikand = $db->query("SELECT onecikar_btarih,kid,onecikar,turu FROM hesaplar WHERE site_id_555=999 AND kid=" . (int)$row->acid . " AND onecikar=1 AND turu=2")->fetch(PDO::FETCH_OBJ);
                                                                $dkgun = $fonk->gun_farki($onecikand->onecikar_btarih, $bugun);
                                                                if ($row->danisman_onecikar_sure == 0) {
                                                                ?><strong style="color:green;"><?= htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($periyod["gunluk"], ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                        } elseif ($dkgun < 0) {
                                                                                                                                                                                            ?><strong style="color:red;"><?= htmlspecialchars(dil("TX585"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                        } elseif ($dkgun == 0) {
                                                                                                                                                                                            ?><strong style="color:orange;"><?= htmlspecialchars(dil("TX586"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                        } elseif ($dkgun > 0) {
                                                                                                                                                                                            ?><strong style="color:green;"><?= htmlspecialchars($dkgun, ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars(dil("TX564"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                        }
                                                                                                                                                                                    ?> </span><br>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <span><?= htmlspecialchars(dil("TX587"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->ilan_resim_limit == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->ilan_resim_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong> </span><br>
                                                    <span><?= htmlspecialchars(dil("TX588"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->ilan_yayin_sure == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->ilan_yayin_sure, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($periyod[$row->ilan_yayin_periyod], ENT_QUOTES, 'UTF-8'); ?></strong> </span><br>

                                                    <?php if ($hesap->turu == 1) { ?>
                                                        <span><?= htmlspecialchars(dil("TX589"), ENT_QUOTES, 'UTF-8'); ?> </span><br>
                                                        <span><?= htmlspecialchars(dil("TX590"), ENT_QUOTES, 'UTF-8'); ?> </span><br>
                                                        <span><?= htmlspecialchars(dil("TX591"), ENT_QUOTES, 'UTF-8'); ?> </span><br>
                                                    <?php } ?>
                                                </td>
                                                <td align="center">(<?= htmlspecialchars($row->sure, ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($periyod[$row->periyod], ENT_QUOTES, 'UTF-8'); ?>)<br><?php if ($row->durum == 1) {
                                                                                                                                                                                $pkgun = $fonk->gun_farki($row->btarih, $bugun);
                                                                                                                                                                                if ($pkgun < 0) {
                                                                                                                                                                                    ?><strong style="color:red;"><?= htmlspecialchars(dil("TX585"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                } elseif ($pkgun == 0) {
                                                                                                                                                                                    ?><strong style="color:orange;"><?= htmlspecialchars(dil("TX586"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                } elseif ($pkgun > 0) {
                                                                                                                                                                                    ?><strong style="color:green;"><?= htmlspecialchars($pkgun, ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars(dil("TX564"), ENT_QUOTES, 'UTF-8'); ?></strong><?php
                                                                                                                                                                                }
                                                                                                                                                                            } ?></td>
                                                <td align="center">
                                                    <?php
                                                    if ($row->durum == 0) {
                                                    ?><span style="color:orange;font-weight:bold;"><?= htmlspecialchars(dil("TX560"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                            } elseif ($row->durum == 1) {
                                                                                                                                                                ?><span style="color:green;font-weight:bold;"><?= htmlspecialchars(dil("TX561"), ENT_QUOTES, 'UTF-8'); ?></span><br><?php
                                                                                                                                                            } elseif ($row->durum == 2) {
                                                                                                                                                                ?><span style="color:red;font-weight:bold;"><?= htmlspecialchars(dil("TX565"), ENT_QUOTES, 'UTF-8'); ?></span><?php
                                                                                                                                                            }
                                                                                                                                                            ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <span style="float:left;"><?= htmlspecialchars(dil("TX566"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= date("d.m.Y H:i", strtotime($row->tarih)); ?></strong></span>
                                                    <span style="float:right; margin-left:20px;"><?= htmlspecialchars(dil("TX567"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= htmlspecialchars($gvn->para_str($row->tutar), ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars(dil("UYELIKP_PBIRIMI"), ENT_QUOTES, 'UTF-8'); ?></strong></span>
                                                    <span style="float:right;"><?= htmlspecialchars(dil("TX568"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= htmlspecialchars($row->odeme_yontemi, ENT_QUOTES, 'UTF-8'); ?></strong></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

                        </div><!-- tab end -->

                        <div class="clear"></div>
                        <!--div class="sayfalama">
                            <?php echo $pagent->listele('paketlerim?git=', $git, $qry['basdan'], $qry['kadar'], 'class="sayfalama-active"', $query); ?>
                        </div-->

                    <?php } else { ?>
                        <h4 style="text-align:center;margin-top:60px;"><?= htmlspecialchars(dil("TX592"), ENT_QUOTES, 'UTF-8'); ?></h4>
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
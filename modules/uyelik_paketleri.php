<?php
if (!defined("THEME_DIR")) {
    die();
}

// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Kullanıcı giriş kontrolü
if ($hesap->id != '' && $hesap->turu == 2) {
    header("Location:index.php");
    die();
}

if ($hesap->id == '') {
    $danisman = true;
} elseif ($hesap->id != '' && $hesap->turu == 1) {
    $danisman = true;
} else {
    $danisman = false;
}
?>
<!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?= htmlspecialchars(dil("TX593"), ENT_QUOTES, 'UTF-8'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="keywords" content="<?= htmlspecialchars($dayarlar->keywords, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="description" content="<?= htmlspecialchars($dayarlar->description, ENT_QUOTES, 'UTF-8'); ?>" />
<meta name="robots" content="All" />
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<!-- Meta Tags -->

<?php include THEME_DIR . "inc/head.php"; ?>

</head>
<body>

<?php include THEME_DIR . "inc/header.php"; ?>

<div class="headerbg" style="background-image: url(uploads/911da78222.jpg);">
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX570"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX571"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div class="clear"></div>

<div id="wrapper">
    <div class="content" id="bigcontent">

        <div class="clearmob" style="margin-top:20px;"></div>

        <div class="uyelikpaketleri">

            <?php
            $sql = $db->query("SELECT * FROM uyelik_paketleri_19541956 WHERE gizle=0 ORDER BY sira ASC");
            while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            ?>
                <div class="uyepaket_19541956" style="border:2px solid <?= htmlspecialchars($row->renk, ENT_QUOTES, 'UTF-8'); ?>;">
                    <div style="padding:15px;">
                        <h1 style="color: <?= htmlspecialchars($row->renk, ENT_QUOTES, 'UTF-8'); ?>;"><i class="ion-ribbon-b"></i> <?= htmlspecialchars($row->baslik, ENT_QUOTES, 'UTF-8'); ?></h1>

                        <span><?= htmlspecialchars(dil("TX594"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->aylik_ilan_limit == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->aylik_ilan_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX595"), ENT_QUOTES, 'UTF-8'); ?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(str_replace(["\r", "\n"], '', $row->aylik_ilan_limit_aciklama), ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                        <span><?= htmlspecialchars(dil("TX587"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->ilan_resim_limit == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->ilan_resim_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(str_replace(["\r", "\n"], '', $row->ilan_resim_limit_aciklama), ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                        <span><?= htmlspecialchars(dil("TX588"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->ilan_yayin_sure == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->ilan_yayin_sure, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($periyod[$row->ilan_yayin_periyod], ENT_QUOTES, 'UTF-8'); ?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(str_replace(["\r", "\n"], '', $row->ilan_yayin_sure_aciklama), ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                        <?php if ($danisman) { ?>
                            <span><?= htmlspecialchars(dil("TX600"), ENT_QUOTES, 'UTF-8'); ?>: <strong><?= ($row->danisman_limit == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->danisman_limit, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars(dil("TX581"), ENT_QUOTES, 'UTF-8'); ?></strong> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(str_replace(["\r", "\n"], '', $row->danisman_limit_aciklama), ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                            <span><?= htmlspecialchars(dil("TX589"), ENT_QUOTES, 'UTF-8'); ?> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(dil("TX602"), ENT_QUOTES, 'UTF-8'); ?>"><i style="margin-left: 7px; font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                            <span><?= htmlspecialchars(dil("TX590"), ENT_QUOTES, 'UTF-8'); ?> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(dil("TX603"), ENT_QUOTES, 'UTF-8'); ?>"><i style="margin-left: 7px; font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                            <span><?= htmlspecialchars(dil("TX591"), ENT_QUOTES, 'UTF-8'); ?> <a href="#" class="tooltip-bottom" data-tooltip="<?= htmlspecialchars(dil("TX604"), ENT_QUOTES, 'UTF-8'); ?>"><i style="margin-left: 7px; font-size: 16px;" class="fa fa-question-circle-o" aria-hidden="true"></i></a></span>

                            <?php if ($row->danisman_onecikar == 1) { ?>
                                <span><?= htmlspecialchars(dil("TX605"), ENT_QUOTES, 'UTF-8'); ?>: <br><strong><?= ($row->danisman_onecikar_sure == 0) ? htmlspecialchars(dil("TX622"), ENT_QUOTES, 'UTF-8') : htmlspecialchars($row->danisman_onecikar_sure, ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($periyod[$row->danisman_onecikar_periyod], ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars(dil("TX583"), ENT_QUOTES, 'UTF-8'); ?></strong></span>
                            <?php } else { ?>
                                <span style="line-height: 39px;">--</span>
                            <?php } ?>
                        <?php } ?>

                        <select id="periyod_<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php
                            $ucretler = json_decode($row->ucretler, true);
                            foreach ($ucretler as $idi => $urow) {
                                $suresi = htmlspecialchars($urow["sure"], ENT_QUOTES, 'UTF-8');
                                $periyodu = htmlspecialchars($periyod[$urow["periyod"]], ENT_QUOTES, 'UTF-8');
                                $tutar = htmlspecialchars($gvn->para_str($urow["tutar"]), ENT_QUOTES, 'UTF-8');
                            ?><option value="<?= htmlspecialchars($idi, ENT_QUOTES, 'UTF-8'); ?>"><?php echo ($suresi != 0) ? $suresi . " " : '1 '; echo $periyodu . " " . $tutar; ?> <?= htmlspecialchars(dil("UYELIKP_PBIRIMI"), ENT_QUOTES, 'UTF-8'); ?></option><?php
                            }
                            ?>
                        </select>
                        <a href="javascript:void(0);" onclick="window.location.href='uyelik-paketi-satinal?id=<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>&periyod='+document.getElementById('periyod_<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>').value;" class="btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?= htmlspecialchars(dil("TX606"), ENT_QUOTES, 'UTF-8'); ?></a>
                    </div>
                </div>
            <?php
            }
            ?>

            <?= htmlspecialchars($dayarlar->paketler_icerik, ENT_QUOTES, 'UTF-8'); ?>
        </div>

    </div>

    <div class="clear"></div>
</div>

<?php include THEME_DIR . "inc/footer.php"; ?>
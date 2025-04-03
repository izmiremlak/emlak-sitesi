<?php
declare(strict_types=1);

if (!defined("THEME_DIR")) {
    die();
}

error_reporting(E_ALL); // Tüm hata raporlamalarını aç
ini_set('display_errors', '1'); // Hataları ekranda göster
ini_set('log_errors', '1'); // Hataları log dosyasına yaz
ini_set('error_log', __DIR__ . '/error_log.log'); // Log dosyasının yolu
?><!DOCTYPE html>
<html>
<head>

<!-- Meta Tags -->
<title><?= htmlspecialchars(dil("TX480"), ENT_QUOTES, 'UTF-8'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<div class="headerbg" style="background-image: url(uploads/e115b36791.jpg);">
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX480"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <a href="index.html"><?= htmlspecialchars(dil("TX136"), ENT_QUOTES, 'UTF-8'); ?></a> / 
                <span><?= htmlspecialchars(dil("TX480"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">

    <div class="content" id="bigcontent">

        <?php include THEME_DIR . "inc/sosyal_butonlar.php"; ?>

        <div class="altbaslik">
            <h4><strong><?= htmlspecialchars(dil("TX480"), ENT_QUOTES, 'UTF-8'); ?></strong></h4>
        </div>

        <div class="clear"></div>

        <div class="sayfadetay">

            <div class="emlaktalepformu">
                <form action="ajax.php?p=emlak_talep_formu" method="POST" id="EmlakTalepForm">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="40%"><?= htmlspecialchars(dil("TX126"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><input name="adsoyad" type="text"></td>
                        </tr>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX128"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><input name="telefon" type="text"></td>
                        </tr>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX127"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><input name="email" type="text"></td>
                        </tr>

                        <?php
                        $emlak_tipi = dil("EMLKTLP1");
                        if ($emlak_tipi != '') {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX54"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="emlak_tipi">
                                    <?= $emlak_tipi; ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php
                        $ulkeler = $db->query("SELECT * FROM ulkeler_19541956 ORDER BY id ASC");
                        $ulkelerc = $ulkeler->rowCount();
                        if ($ulkelerc > 1) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX348"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="ulke_id" onchange="ajaxHere('ajax.php?p=il_getir&ulke_id='+this.options[this.selectedIndex].value,'il');">
                                    <option value=""><?= htmlspecialchars(dil("TX348"), ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php
                                    while ($row = $ulkeler->fetch(PDO::FETCH_OBJ)) {
                                    ?><option value="<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($row->ulke_adi, ENT_QUOTES, 'UTF-8'); ?></option><?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td><?= htmlspecialchars(dil("TX55"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="il" id="il" onchange="ajaxHere('ajax.php?p=ilce_getir&il_id='+this.options[this.selectedIndex].value,'ilce');">
                                    <option value=""><?= htmlspecialchars(dil("TX55"), ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php
                                    if ($ulkelerc < 2) {
                                        $ulke = $ulkeler->fetch(PDO::FETCH_OBJ);
                                        $sql = $db->query("SELECT id,il_adi FROM il WHERE ulke_id=" . htmlspecialchars($ulke->id, ENT_QUOTES, 'UTF-8') . " ORDER BY id ASC");
                                    } else {
                                        $sql = null;
                                    }
                                    if ($sql != null) {
                                        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                    ?><option value="<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($row->il_adi, ENT_QUOTES, 'UTF-8'); ?></option><?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><?= htmlspecialchars(dil("TX56"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="ilce" id="ilce" onchange="ajaxHere('ajax.php?p=mahalle_getir&ilce_id='+this.options[this.selectedIndex].value,'mahalle');">
                                    <option value=""><?= htmlspecialchars(dil("TX56"), ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php
                                    if ($il != '') {
                                        $sql = $db->prepare("SELECT id,ilce_adi FROM ilce WHERE il_id=? ORDER BY id ASC");
                                        $sql->execute([htmlspecialchars($il, ENT_QUOTES, 'UTF-8')]);
                                    } else {
                                        $sql = '';
                                    }
                                    if ($sql != '') {
                                        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                                    ?><option value="<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($row->ilce_adi, ENT_QUOTES, 'UTF-8'); ?></option><?php
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX266"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="mahalle" id="mahalle">
                                    <option value=""><?= htmlspecialchars(dil("TX266"), ENT_QUOTES, 'UTF-8'); ?></option>
                                </select>
                            </td>
                        </tr>

                        <?php
                        $talepler = dil("EMLKTLP2");
                        if ($talepler != '') {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars(dil("TX481"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <select name="talep">
                                    <?= $talepler; ?>
                                </select>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td><?= htmlspecialchars(dil("TX482"), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <textarea name="mesaj"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td><a class="gonderbtn" onclick="AjaxFormS('EmlakTalepForm','EmlakTalepForm_output');" href="javascript:void(0);"><?= htmlspecialchars(dil("TX483"), ENT_QUOTES, 'UTF-8'); ?></a></td>
                        </tr>

                        <tr>
                            <td colspan="2"><div id="EmlakTalepForm_output" style="display:none"></div></td>
                        </tr>

                    </table>
                </form>
                <div id="EmlakTalepForm_SUCCESS" style="display:none"><?= htmlspecialchars(dil("TX645"), ENT_QUOTES, 'UTF-8'); ?></div>
            </div>

        </div>

    </div>

    <div class="clear"></div>
</div>

<?php include THEME_DIR . "inc/ilanvertanitim.php"; ?>
</div>

<?php include THEME_DIR . "inc/footer.php"; ?>

</body>
</html>
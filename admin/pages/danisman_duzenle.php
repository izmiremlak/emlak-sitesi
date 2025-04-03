<?php
// Veritabanı bağlantısı ve güvenlik işlemleri
$id = $gvn->rakam($_GET["id"] ?? '');
$snc = $db->prepare("SELECT * FROM danismanlar_19541956 WHERE id=:ids");
$snc->execute(['ids' => $id]);

if ($snc->rowCount() > 0) {
    $snc = $snc->fetch(PDO::FETCH_OBJ);
} else {
    header("Location:index.php?p=danismanlar");
    exit;
}

// Hata loglama fonksiyonu
function logError($errorMessage) {
    error_log($errorMessage, 3, '/path/to/error.log');
}

try {
    // İşlem kodları burada
} catch (Exception $e) {
    logError($e->getMessage());
    echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danışman Düzenle</title>
    <link rel="stylesheet" href="assets/css/admin.min.css">
    <link href="assets/plugins/notifications/notification.css" rel="stylesheet">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
</head>
<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">Danışman Düzenle</h4>
                </div>
            </div>
					
            <div class="row">
                <!-- Col 1 -->
                <div class="col-md-12">
                    <ul class="nav nav-tabs tabs">
                        <li class="tab">
                            <a href="#tab1" data-toggle="tab" aria-expanded="false">
                                <span class="hidden-xs">Danışman Bilgileri</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#tab2" data-toggle="tab" aria-expanded="false">
                                <span class="hidden-xs">İlanları Aktar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div id="form_status"></div>
                            <form role="form" class="form-horizontal" id="forms" method="POST" action="ajax.php?p=danisman_duzenle&id=<?= htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8'); ?>" onsubmit="return false;" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="adsoyad" class="col-sm-3 control-label">Adı Soyadı</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="adsoyad" name="adsoyad" value="<?= htmlspecialchars($snc->adsoyad, ENT_QUOTES, 'UTF-8'); ?>" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gsm" class="col-sm-3 control-label">GSM</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="gsm" name="gsm" value="<?= htmlspecialchars($snc->gsm, ENT_QUOTES, 'UTF-8'); ?>" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="telefon" class="col-sm-3 control-label">Telefon</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="telefon" name="telefon" value="<?= htmlspecialchars($snc->telefon, ENT_QUOTES, 'UTF-8'); ?>" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 control-label">E-Posta</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($snc->email, ENT_QUOTES, 'UTF-8'); ?>" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="resim" class="col-sm-3 control-label">Resim</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="resim" name="resim">
                                        <?php if ($snc->resim != ''): ?>
                                            <img src="/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($snc->resim, ENT_QUOTES, 'UTF-8'); ?>" id="resim_src" width="150" />
                                        <?php endif; ?>
                                        <p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?= $gorsel_boyutlari['danismanlar']['thumb_x']; ?> x <?= $gorsel_boyutlari['danismanlar']['thumb_y']; ?> olmalıdır.</p>
                                    </div>
                                </div>
                                <div align="right">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light" onclick="AjaxFormS('forms', 'form_status');">Kaydet</button>
                                </div>
                            </form>
                        </div><!-- tab1 end -->

                        <div class="tab-pane" id="tab2">
                            <form role="form" class="form-horizontal" id="formsx" method="POST" action="ajax.php?p=danisman_ilan_aktar" onsubmit="return false;" enctype="multipart/form-data">
                                <input type="hidden" name="danisman_id" value="<?= htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="form-group">
                                    <label for="danisman_yeni_id" class="col-sm-3 control-label">Aktarılacak Üye</label>
                                    <div class="col-sm-9">
                                        <select name="danisman_yeni_id" id="danisman_yeni_id" class="form-control">
                                            <option>Seçiniz</option>
                                            <?php
                                            $query = $db->query("SELECT id, unvan, concat_ws(' ', adi, soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND durum=0 ORDER BY id DESC");
                                            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                                $adsoyad = ($row->unvan != '') ? $row->unvan : $row->adsoyad;
                                                echo '<option value="' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($adsoyad, ENT_QUOTES, 'UTF-8') . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        &nbsp;
                                        <div id="formx_status"></div>
                                    </div>
                                </div>
                                <div align="right">
                                    <button type="submit" class="btn btn-purple waves-effect waves-light" onclick="AjaxFormS('formsx', 'formx_status');">Uygula</button>
                                </div>
                            </form>
                        </div><!-- tab2 end -->
                    </div><!-- tabcontent end -->
                </div><!-- Col1 end -->
            </div><!-- row end -->
        </div>
    </div>
    <script>
        var resizefunc = [];
    </script>
    <script src="assets/js/admin.min.js"></script>
    <link href="assets/plugins/notifications/notification.css" rel="stylesheet">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>
</body>
</html>
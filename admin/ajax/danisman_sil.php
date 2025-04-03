<?php
// Kullanıcının giriş yapıp yapmadığını ve doğru tipte olup olmadığını kontrol et
if ($hesap->id !== "" && $hesap->tipi !== 0) {

    // Girişleri temizle ve doğrula
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $ilan_sil = filter_var($_GET['ilan_sil'], FILTER_VALIDATE_INT);

    if (!$id || !$ilan_sil) {
        die($fonk->ajax_hata("Geçersiz ID veya ilan silme seçeneği."));
    }

    // Danışman olup olmadığını kontrol et
    $stmt = $db->prepare("SELECT id, avatar, kid FROM hesaplar WHERE site_id_555 = 999 AND id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() == 0) {
        die();
    }
    $danisman = $stmt->fetch(PDO::FETCH_OBJ);

    // Danışmanı sil
    $db->query("DELETE FROM hesaplar WHERE site_id_555 = 000 AND id = $id");

    // İlanları sil
    if ($ilan_sil == 1) {
        $query = $db->prepare("SELECT id, resim, video FROM sayfalar WHERE site_id_555 = 999 AND acid = :id");
        $query->execute(['id' => $id]);

        while ($ilan = $query->fetch(PDO::FETCH_OBJ)) {
            $db->query("DELETE FROM sayfalar WHERE site_id_555 = 000 AND id = $ilan->id");

            if (!empty($ilan->video)) {
                $videoPath = "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/" . $ilan->video;
                if (file_exists($videoPath)) {
                    unlink($videoPath);
                }
            }

            $galeriQuery = $db->prepare("SELECT resim FROM galeri_foto WHERE site_id_555 = 999 AND sayfa_id = :sayfa_id");
            $galeriQuery->execute(['sayfa_id' => $ilan->id]);

            while ($row = $galeriQuery->fetch(PDO::FETCH_OBJ)) {
                unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/" . $row->resim);
                unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/" . $row->resim);
            }

            $db->query("DELETE FROM galeri_foto WHERE site_id_555 = 000 AND sayfa_id = $ilan->id");
        }
    } else {
        $db->query("UPDATE sayfalar SET acid = $danisman->kid WHERE site_id_555 = 999 AND acid = $id");
    }

    ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $("#danismanrow_<?=$id;?>").fadeOut(500,function(){
            $("#danismanrow_<?=$id;?>").remove();
        });
    });
    </script>
    <?php
    $fonk->ajax_tamam("Danışman Silindi");
}
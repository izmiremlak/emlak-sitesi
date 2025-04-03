<?php
// Kullanıcının giriş yapıp yapmadığını ve doğru tipte olup olmadığını kontrol et
if ($hesap->id !== "" && $hesap->tipi !== 0) {
    // Dosya yükleme işlemi olup olmadığını kontrol et
    if ($_FILES) {
        $resim1tmp = $_FILES['file']['tmp_name'];
        $resim1nm = $_FILES['file']['name'];

        if ($resim1tmp && $resim1nm) {
            // Rastgele dosya ismi oluştur
            $randnm = strtolower(substr(md5(uniqid(rand())), 0, 10)) . $fonk->uzanti($resim1nm);

            // Resim yükleme işlemleri
            $upload_dir = '/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads';
            $fonk->resim_yukle(true, 'file', $randnm, $upload_dir, $gorsel_boyutlari['foto_galeri']['thumb_x'], $gorsel_boyutlari['foto_galeri']['thumb_y']);
            $fonk->resim_yukle(false, 'file', $randnm, $upload_dir, $gorsel_boyutlari['foto_galeri']['orjin_x'], $gorsel_boyutlari['foto_galeri']['orjin_y']);

            // Veritabanına resim bilgisi ekle
            try {
                $stmt = $db->prepare("INSERT INTO galeri_foto 
                    SET site_id_888 = :site_id_888, site_id_777 = :site_id_777, site_id_699 = :site_id_699,
                        site_id_700 = :site_id_700, site_id_701 = :site_id_701, site_id_702 = :site_id_702,
                        site_id_555 = :site_id_555, site_id_450 = :site_id_450, site_id_444 = :site_id_444,
                        site_id_333 = :site_id_333, site_id_335 = :site_id_335, site_id_334 = :site_id_334,
                        site_id_306 = :site_id_306, site_id_222 = :site_id_222, site_id_111 = :site_id_111,
                        resim = :resim, dil = :dil");
                $stmt->execute([
                    'site_id_888' => 'XXX',
                    'site_id_777' => 'XXX',
                    'site_id_699' => 'XXX',
                    'site_id_700' => 'XXX',
                    'site_id_701' => 'XXX',
                    'site_id_702' => 'XXX',
                    'site_id_555' => 555,
                    'site_id_450' => 450,
                    'site_id_444' => 444,
                    'site_id_333' => 333,
                    'site_id_335' => 335,
                    'site_id_334' => 334,
                    'site_id_306' => 306,
                    'site_id_222' => 222,
                    'site_id_111' => 111,
                    'resim' => $randnm,
                    'dil' => $dil
                ]);
            } catch (PDOException $e) {
                // Hata durumunda hatayı log dosyasına yaz ve kullanıcıya göster
                error_log($e->getMessage(), 3, '/var/log/php_errors.log');
                die($fonk->ajax_hata("Bir hata oluştu: " . htmlspecialchars($e->getMessage())));
            }
        }
    }
}
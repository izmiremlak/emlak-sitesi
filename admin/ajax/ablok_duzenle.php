<?php
// POST isteği olup olmadığını kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kullanıcının giriş yapıp yapmadığını ve doğru tipte olup olmadığını kontrol et
    if ($hesap->id !== "" && $hesap->tipi !== 0) {
        
        // Gerekli değişkenleri başlat ve girişleri temizle
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false) {
            die('Geçersiz ID');
        }
        
        // Blok verilerini çekmek için SQL sorgusunu hazırla ve çalıştır
        $stmt = $db->prepare("SELECT * FROM abloklar WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $snc = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$snc) {
            die('Blok bulunamadı');
        }

        // Girişleri temizle ve doğrula
        $sira = filter_input(INPUT_POST, 'sira', FILTER_VALIDATE_INT);
        $icon = filter_input(INPUT_POST, 'icon', FILTER_SANITIZE_STRING);
        $aciklama = filter_input(INPUT_POST, 'aciklama', FILTER_SANITIZE_STRING);
        $baslik = $gvn->html_temizle($_POST['baslik']);
        $url = $gvn->html_temizle($_POST['url']);

        if (empty($baslik) || empty($aciklama) || empty($sira)) {
            die($fonk->ajax_uyari("Lütfen tüm alanları eksiksiz doldurun."));
        }

        // Dosya yükleme işlemi
        $resim1tmp = $_FILES['resim']['tmp_name'] ?? '';
        $resim1nm = $_FILES['resim']['name'] ?? '';

        if ($resim1tmp !== '') {
            $randnm = strtolower(substr(md5(uniqid(rand())), 0, 10)) . $fonk->uzanti($resim1nm);
            $resim = $fonk->resim_yukle(false, 'resim', $randnm, '../uploads', $gorsel_boyutlari['abloklar']['orjin_x'], $gorsel_boyutlari['abloklar']['orjin_y']);

            // Veritabanında resmi güncelle
            $avgn = $db->prepare("UPDATE abloklar SET resim = :image WHERE id = :id");
            if ($avgn->execute(['image' => $resim, 'id' => $snc->id])) {
                $fonk->ajax_tamam('Resim Güncellendi');
                echo '<script type="text/javascript">
                    $(document).ready(function(){
                        $("#resim_src").attr("src", "../uploads/thumb/' . htmlspecialchars($resim) . '");
                    });
                </script>';
            }
        }

        // Blok verilerini veritabanında güncelle
        $dzn = $db->prepare("UPDATE abloklar SET sira = ?, icon = ?, baslik = ?, aciklama = ?, url = ? WHERE id = ?");
        if ($dzn->execute([$sira, $icon, $baslik, $aciklama, $url, $snc->id])) {
            $fonk->ajax_tamam("Anasayfa Blok Güncellendi.");
        } else {
            $fonk->ajax_hata("Bir hata oluştu.");
        }
    }
}
?>
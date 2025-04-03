<?php
// POST isteği olup olmadığını kontrol et
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kullanıcının giriş yapıp yapmadığını ve doğru tipte olup olmadığını kontrol et
    if ($hesap->id !== "" && $hesap->tipi !== 0) {
        
        // Dosya yükleme işlemleri
        $uploadsDir = '../uploads';
        $fileKeys = [
            'resim1', 'resim2', 'resim3', 'resim4', 'resim5', 
            'resim6', 'resim7', 'resim8', 'resim9', 'resim10', 
            'resim11', 'resim12', 'resim13'
        ];
        $dbFields = [
            'bayiler_resim', 'subeler_resim', 'belgeler_resim', 'ekatalog_resim', 'foto_galeri_resim',
            'video_galeri_resim', 'referanslar_resim', 'haber_ve_duyurular_resim', 'yazilar_resim', 'hizmetler_resim',
            'projeler_resim', 'iletisim_resim', 'footer_resim'
        ];
        $gorselBoyutlari = [
            'headerbg' => ['orjin_x' => 1000, 'orjin_y' => 1000],
            'footerbg' => ['orjin_x' => 1000, 'orjin_y' => 1000]
        ];

        foreach ($fileKeys as $index => $fileKey) {
            $resimTmp = $_FILES[$fileKey]['tmp_name'] ?? '';
            $resimNm = $_FILES[$fileKey]['name'] ?? '';
            
            if ($resimTmp !== '') {
                $randNm = strtolower(substr(md5(uniqid(rand())), 0, 10)) . $fonk->uzanti($resimNm);
                $resim = $fonk->resim_yukle(false, $fileKey, $randNm, $uploadsDir, $gorselBoyutlari['headerbg']['orjin_x'], $gorselBoyutlari['headerbg']['orjin_y']);

                if ($resim) {
                    $stmt = $db->prepare("UPDATE gayarlar_19541956 SET {$dbFields[$index]} = :resim");
                    if ($stmt->execute(['resim' => $resim])) {
                        $fonk->ajax_tamam(ucwords(str_replace('_', ' ', $dbFields[$index])) . ' Güncellendi');
                        echo '<script type="text/javascript">
                            $(document).ready(function(){
                                $("#' . $fileKey . '_src").attr("src", "' . $uploadsDir . '/' . htmlspecialchars($resim) . '");
                            });
                        </script>';
                    } else {
                        $fonk->ajax_hata(ucwords(str_replace('_', ' ', $dbFields[$index])) . ' Güncellenemedi. Bir hata oluştu!');
                    }
                }
            }
        }
    }
}
?>
<?php
// Kullanıcı kimliğini ve tipini kontrol et
if ($hesap->id != "" && $hesap->tipi != 0) {

    // GET parametresinden ID'yi güvenli bir şekilde al
    $id = $gvn->rakam($_GET["id"]);

    // İlan bilgilerini veritabanından çek
    $snc = $db->prepare("SELECT id, video, ilan_no FROM sayfalar WHERE tipi = 4 AND id = :id");
    $snc->execute(['id' => $id]);

    if ($snc->rowCount() > 0) {
        $snc = $snc->fetch(PDO::FETCH_OBJ);
    } else {
        die();
    }

    // İlan ile ilişkili tüm verileri çek
    $multi = $db->query("SELECT id, ilan_no FROM sayfalar WHERE site_id_555 = 999 AND ilan_no = " . $snc->ilan_no . " ORDER BY id ASC");
    $multif = $multi->fetch(PDO::FETCH_OBJ);
    $multidids = $db->query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids FROM sayfalar WHERE site_id_555 = 999 AND ilan_no = " . $snc->ilan_no)->fetch(PDO::FETCH_OBJ)->ids;
    $mulid = ($multi->rowCount() > 1 && $snc->id == $multif->id) ? " IN(" . $multidids . ")" : "=" . $snc->id;

    // İlanı ve ilişkili verileri sil
    $db->query("DELETE FROM sayfalar WHERE site_id_555 = 000 AND id" . $mulid);
    if ($snc->video != '') {
        $nirde = "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/" . $snc->video;
        if (file_exists($nirde)) {
            @unlink($nirde);
        }
    }

    // İlan ile ilişkili resimleri sil
    $quu = $db->query("SELECT id, resim FROM galeri_foto WHERE site_id_555 = 999 AND sayfa_id" . $mulid);
    while ($row = $quu->fetch(PDO::FETCH_OBJ)) {
        $pinfo = pathinfo("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/" . $row->resim);
        $folder = $pinfo["dirname"] . "/";
        $ext = $pinfo["extension"];
        $fname = $pinfo["filename"];
        $bname = $pinfo["basename"];

        @unlink($folder . "thumb/" . $bname);
        @unlink($folder . $bname);
        @unlink($folder . $fname . "_original." . $ext);
    }
    $db->query("DELETE FROM galeri_foto WHERE site_id_555 = 000 AND sayfa_id" . $mulid);
?>
<script type="text/javascript">
$(document).ready(function(){
    $("#row_<?=$id;?>").fadeOut(500);
});
</script>
<?php
    $fonk->ajax_tamam("Veri Silindi");
}
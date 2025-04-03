<?php
// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

$id = $gvn->rakam($_GET["id"]);

// Kullanıcı kontrolü
$kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=? AND kid=?");
$kontrol->execute([$id, $hesap->id]);
if ($kontrol->rowCount() < 1) {
    header("Location: eklenen-danismanlar");
    die();
}
$snc = $kontrol->fetch(PDO::FETCH_OBJ);
?>
<div class="headerbg" <?= ($gayarlar->belgeler_resim != '') ? 'style="background-image: url(uploads/' . htmlspecialchars($gayarlar->belgeler_resim, ENT_QUOTES, 'UTF-8') . ');"' : ''; ?>>
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX501"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX502"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">

<div class="sidebar">
<?php include THEME_DIR . "inc/uyepanel_sidebar.php"; ?>
</div>

<div class="content">

<div class="uyedetay">
<div class="uyeolgirisyap">
    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX501"), ENT_QUOTES, 'UTF-8'); ?></h4>

    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'uyelik_bilgileri')" <?= ($_GET["goto"] == "") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX609"), ENT_QUOTES, 'UTF-8'); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'ilanlari')" <?= ($_GET["goto"] == "ilanlari") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX504"), ENT_QUOTES, 'UTF-8'); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'ilanlari2')" <?= ($_GET["goto"] == "ilanlari2") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX507"), ENT_QUOTES, 'UTF-8'); ?></a></li>
    </ul>

    <div id="uyelik_bilgileri" class="tabcontent">

    <form action="ajax.php?p=danisman_duzenle&id=<?= htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8'); ?>" method="POST" id="DanismanEkleForm" enctype="multipart/form-data">

    <table width="100%" border="0">

    <tr>
        <td><?= htmlspecialchars(dil("TX363"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <input type="file" name="avatar" id="avatar" style="display:none;" />
            <div class="uyeavatar">
                <a title="Foto Yükle" class="avatarguncelle" href="javascript:void(0);" onclick="document.getElementById('avatar').click();"><i class="fa fa-camera" aria-hidden="true"></i></a>
                <img src="<?= ($snc->avatar == '') ? 'https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' : 'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/' . htmlspecialchars($snc->avatar, ENT_QUOTES, 'UTF-8'); ?>" id="avatar_image" />
            </div>
        </td>
    </tr>

    <tr>
        <td>Hesap Durumu</td>
        <td>
            <input id="durum_0" class="radio-custom" name="durum" value="0" type="radio" style="width:25px;" <?= ($snc->durum == 0) ? 'checked' : ''; ?>>
            <label for="durum_0" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?= htmlspecialchars(dil("TX491"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            
            <input id="durum_1" class="radio-custom" name="durum" value="1" type="radio" style="width:25px;" <?= ($snc->durum == 1) ? 'checked' : ''; ?>>
            <label for="durum_1" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?= htmlspecialchars(dil("TX490"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        </td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX126"), ENT_QUOTES, 'UTF-8'); ?> <span style="color:red">*</span></td>
        <td><input name="adsoyad" type="text" value="<?= htmlspecialchars($snc->adi . " " . $snc->soyadi, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX396"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <div class="prufilurllink">
                <a target="_blank" href="profil/<?= ($snc->nick_adi == '') ? htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8') : htmlspecialchars($snc->nick_adi, ENT_QUOTES, 'UTF-8'); ?>"><?= SITE_URL; ?>profil/<?= ($snc->nick_adi == '') ? htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8') : htmlspecialchars($snc->nick_adi, ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
        </td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX127"), ENT_QUOTES, 'UTF-8'); ?> <span style="color:red">*</span></td>
        <td><input name="email" type="text" value="<?= htmlspecialchars($snc->email, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX128"), ENT_QUOTES, 'UTF-8'); ?> <?= ($gayarlar->sms_aktivasyon == 1) ? '<span style="color:red">*</span>' : ''; ?></td>
        <td><input name="telefon" id="gsm" type="text" value="<?= htmlspecialchars($snc->telefon, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX390"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="sabit_telefon" type="text" id="telefon" value="<?= htmlspecialchars($snc->sabit_telefon, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX129"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="parola" type="password" placeholder="<?= htmlspecialchars(dil("TX254"), ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>
    <tr>
        <td><?= htmlspecialchars(dil("TX130"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="parola_tekrar" type="password" placeholder="<?= htmlspecialchars(dil("TX254"), ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td colspan="2">
            <span style="margin-bottom:10px; float: left;"><strong><?= htmlspecialchars(dil("TX644"), ENT_QUOTES, 'UTF-8'); ?></strong></span><div class="clear"></div>
            <textarea style="width:100%;" name="hakkinda" class="thetinymce" id="hakkinda" placeholder="<?= htmlspecialchars(dil("TX429"), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($snc->hakkinda, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </td>
    </tr>

    <tr style="font-size:13px;display:none">
        <td colspan="2">
            <h5 style="margin-bottom:7px;"><strong><?= htmlspecialchars(dil("TX398"), ENT_QUOTES, 'UTF-8'); ?></strong></h5>
            <input id="telefond_check" class="checkbox-custom" name="telefond" value="1" type="checkbox" <?= ($snc->telefond == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="telefond_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX386"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="sabittelefond_check" class="checkbox-custom" name="sabittelefond" value="1" type="checkbox" <?= ($snc->sabittelefond == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="sabittelefond_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX387"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="epostad_check" class="checkbox-custom" name="epostad" value="1" type="checkbox" <?= ($snc->epostad == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="epostad_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX388"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="avatard_check" class="checkbox-custom" name="avatard" value="1" type="checkbox" <?= ($snc->avatard == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="avatard_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX389"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <h5 style="margin-bottom:7px;margin-top:10px;"><strong><?= htmlspecialchars(dil("TX399"), ENT_QUOTES, 'UTF-8'); ?></strong></h5>
            <input id="checkbox-6" class="checkbox-custom" name="mail_izin" value="1" type="checkbox" <?= ($snc->mail_izin == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="checkbox-6" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX251"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            <input id="checkbox-7" class="checkbox-custom" name="sms_izin" value="1" type="checkbox" <?= ($snc->sms_izin == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="checkbox-7" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX252"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        </td>
    </tr>

    <tr>
        <td style="border:none" colspan="2">
            <a href="javascript:;" id="ButtonSubmit" onclick="ButtonSubmit();" class="btn"><i class="fa fa-refresh" aria-hidden="true"></i> <?= htmlspecialchars(dil("TX505"), ENT_QUOTES, 'UTF-8'); ?></a>
        </td>
    </tr>

    <tr>
        <td style="border:none" colspan="2" align="center"><div id="DanismanEkleForm_output" style="display:none"></div></td>
    </tr>

    </table>
    </form>
    <script src="<?= THEME_DIR; ?>tinymce/tinymce.min.js"></script>
    <script type="application/x-javascript">
    tinymce.init({
        selector: "#hakkinda",
        height: 200,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
    });
    </script>
    <script type="text/javascript">
    function ButtonSubmit() {
        var stbutton = document.getElementById("ButtonSubmit");
        var stonc = stbutton.getAttribute("onclick");
        var stinn = stbutton.innerHTML;
        stbutton.removeAttribute("onclick");
        stbutton.innerHTML = '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
        document.getElementById('hakkinda').innerHTML = tinymce.get('hakkinda').getContent();
        document.getElementById("DanismanEkleForm_output").style.display = 'none';
        $("#DanismanEkleForm").ajaxForm({
            target: '#DanismanEkleForm_output',
            complete: function () {
                document.getElementById("DanismanEkleForm_output").style.display = 'block';
                stbutton.setAttribute("onclick", stonc);
                stbutton.innerHTML = stinn;
            }
        }).submit();
    }
    </script>

<?php
// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

$id = $gvn->rakam($_GET["id"]);

// Kullanıcı kontrolü
$kontrol = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=? AND kid=?");
$kontrol->execute([$id, $hesap->id]);
if ($kontrol->rowCount() < 1) {
    header("Location: eklenen-danismanlar");
    die();
}
$snc = $kontrol->fetch(PDO::FETCH_OBJ);
?>
<div class="headerbg" <?= ($gayarlar->belgeler_resim != '') ? 'style="background-image: url(uploads/' . htmlspecialchars($gayarlar->belgeler_resim, ENT_QUOTES, 'UTF-8') . ');"' : ''; ?>>
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX501"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <span><?= htmlspecialchars(dil("TX502"), ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">

<div class="uyepanel">

<div class="sidebar">
<?php include THEME_DIR . "inc/uyepanel_sidebar.php"; ?>
</div>

<div class="content">

<div class="uyedetay">
<div class="uyeolgirisyap">
    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX501"), ENT_QUOTES, 'UTF-8'); ?></h4>

    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'uyelik_bilgileri')" <?= ($_GET["goto"] == "") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX609"), ENT_QUOTES, 'UTF-8'); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'ilanlari')" <?= ($_GET["goto"] == "ilanlari") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX504"), ENT_QUOTES, 'UTF-8'); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openCity(event, 'ilanlari2')" <?= ($_GET["goto"] == "ilanlari2") ? 'id="defaultOpen"' : ''; ?>><?= htmlspecialchars(dil("TX507"), ENT_QUOTES, 'UTF-8'); ?></a></li>
    </ul>

    <div id="uyelik_bilgileri" class="tabcontent">

    <form action="ajax.php?p=danisman_duzenle&id=<?= htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8'); ?>" method="POST" id="DanismanEkleForm" enctype="multipart/form-data">

    <table width="100%" border="0">

    <tr>
        <td><?= htmlspecialchars(dil("TX363"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <input type="file" name="avatar" id="avatar" style="display:none;" />
            <div class="uyeavatar">
                <a title="Foto Yükle" class="avatarguncelle" href="javascript:void(0);" onclick="document.getElementById('avatar').click();"><i class="fa fa-camera" aria-hidden="true"></i></a>
                <img src="<?= ($snc->avatar == '') ? 'https://www.turkiyeemlaksitesi.com.tr/uploads/default-avatar.png' : 'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/' . htmlspecialchars($snc->avatar, ENT_QUOTES, 'UTF-8'); ?>" id="avatar_image" />
            </div>
        </td>
    </tr>

    <tr>
        <td>Hesap Durumu</td>
        <td>
            <input id="durum_0" class="radio-custom" name="durum" value="0" type="radio" style="width:25px;" <?= ($snc->durum == 0) ? 'checked' : ''; ?>>
            <label for="durum_0" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?= htmlspecialchars(dil("TX491"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            
            <input id="durum_1" class="radio-custom" name="durum" value="1" type="radio" style="width:25px;" <?= ($snc->durum == 1) ? 'checked' : ''; ?>>
            <label for="durum_1" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?= htmlspecialchars(dil("TX490"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        </td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX126"), ENT_QUOTES, 'UTF-8'); ?> <span style="color:red">*</span></td>
        <td><input name="adsoyad" type="text" value="<?= htmlspecialchars($snc->adi . " " . $snc->soyadi, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX396"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <div class="prufilurllink">
                <a target="_blank" href="profil/<?= ($snc->nick_adi == '') ? htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8') : htmlspecialchars($snc->nick_adi, ENT_QUOTES, 'UTF-8'); ?>"><?= SITE_URL; ?>profil/<?= ($snc->nick_adi == '') ? htmlspecialchars($snc->id, ENT_QUOTES, 'UTF-8') : htmlspecialchars($snc->nick_adi, ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
        </td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX127"), ENT_QUOTES, 'UTF-8'); ?> <span style="color:red">*</span></td>
        <td><input name="email" type="text" value="<?= htmlspecialchars($snc->email, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX128"), ENT_QUOTES, 'UTF-8'); ?> <?= ($gayarlar->sms_aktivasyon == 1) ? '<span style="color:red">*</span>' : ''; ?></td>
        <td><input name="telefon" id="gsm" type="text" value="<?= htmlspecialchars($snc->telefon, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX390"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="sabit_telefon" type="text" id="telefon" value="<?= htmlspecialchars($snc->sabit_telefon, ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td><?= htmlspecialchars(dil("TX129"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="parola" type="password" placeholder="<?= htmlspecialchars(dil("TX254"), ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>
    <tr>
        <td><?= htmlspecialchars(dil("TX130"), ENT_QUOTES, 'UTF-8'); ?></td>
        <td><input name="parola_tekrar" type="password" placeholder="<?= htmlspecialchars(dil("TX254"), ENT_QUOTES, 'UTF-8'); ?>"></td>
    </tr>

    <tr>
        <td colspan="2">
            <span style="margin-bottom:10px; float: left;"><strong><?= htmlspecialchars(dil("TX644"), ENT_QUOTES, 'UTF-8'); ?></strong></span><div class="clear"></div>
            <textarea style="width:100%;" name="hakkinda" class="thetinymce" id="hakkinda" placeholder="<?= htmlspecialchars(dil("TX429"), ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($snc->hakkinda, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </td>
    </tr>

    <tr style="font-size:13px;display:none">
        <td colspan="2">
            <h5 style="margin-bottom:7px;"><strong><?= htmlspecialchars(dil("TX398"), ENT_QUOTES, 'UTF-8'); ?></strong></h5>
            <input id="telefond_check" class="checkbox-custom" name="telefond" value="1" type="checkbox" <?= ($snc->telefond == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="telefond_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX386"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="sabittelefond_check" class="checkbox-custom" name="sabittelefond" value="1" type="checkbox" <?= ($snc->sabittelefond == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="sabittelefond_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX387"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="epostad_check" class="checkbox-custom" name="epostad" value="1" type="checkbox" <?= ($snc->epostad == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="epostad_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX388"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <input id="avatard_check" class="checkbox-custom" name="avatard" value="1" type="checkbox" <?= ($snc->avatard == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="avatard_check" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX389"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            
            <h5 style="margin-bottom:7px;margin-top:10px;"><strong><?= htmlspecialchars(dil("TX399"), ENT_QUOTES, 'UTF-8'); ?></strong></h5>
            <input id="checkbox-6" class="checkbox-custom" name="mail_izin" value="1" type="checkbox" <?= ($snc->mail_izin == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="checkbox-6" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX251"), ENT_QUOTES, 'UTF-8'); ?></span></label>
            <div class="clear" style="margin-bottom:5px;"></div>
            <input id="checkbox-7" class="checkbox-custom" name="sms_izin" value="1" type="checkbox" <?= ($snc->sms_izin == 1) ? 'checked' : ''; ?> style="width:100px;">
            <label for="checkbox-7" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX252"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        </td>
    </tr>

    <tr>
        <td style="border:none" colspan="2">
            <a href="javascript:;" id="ButtonSubmit" onclick="ButtonSubmit();" class="btn"><i class="fa fa-refresh" aria-hidden="true"></i> <?= htmlspecialchars(dil("TX505"), ENT_QUOTES, 'UTF-8'); ?></a>
        </td>
    </tr>

    <tr>
        <td style="border:none" colspan="2" align="center"><div id="DanismanEkleForm_output" style="display:none"></div></td>
    </tr>

    </table>
    </form>
    <script src="<?= THEME_DIR; ?>tinymce/tinymce.min.js"></script>
    <script type="application/x-javascript">
    tinymce.init({
        selector: "#hakkinda",
        height: 200,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
    });
    </script>
    <script type="text/javascript">
    function ButtonSubmit() {
        var stbutton = document.getElementById("ButtonSubmit");
        var stonc = stbutton.getAttribute("onclick");
        var stinn = stbutton.innerHTML;
        stbutton.removeAttribute("onclick");
        stbutton.innerHTML = '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
        document.getElementById('hakkinda').innerHTML = tinymce.get('hakkinda').getContent();
        document.getElementById("DanismanEkleForm_output").style.display = 'none';
        $("#DanismanEkleForm").ajaxForm({
            target: '#DanismanEkleForm_output',
            complete: function () {
                document.getElementById("DanismanEkleForm_output").style.display = 'block';
                stbutton.setAttribute("onclick", stonc);
                stbutton.innerHTML = stinn;
            }
        }).submit();
    }
    </script>

</div>

<div id="ilanlari" class="tabcontent">
<?php
$git = $gvn->zrakam($_GET["git"]);
$qry = $pagent->sql_query("SELECT * FROM sayfalar WHERE site_id_555=999 AND dil='" . htmlspecialchars($dil, ENT_QUOTES, 'UTF-8') . "' AND ekleme=1 AND tipi=4 AND (durum=1 OR durum=0) AND acid=" . (int)$snc->id . " ORDER BY id DESC", $git, 6);
$query = $db->query($qry['sql']);
$adet = $qry['toplam'];
?>

<?php
if ($adet > 0) {
?>
<div id="hidden_result" style="display:none"></div>
<table width="100%" border="0" id="uyepanelilantable">
    <tr>
        <td id="mobtd" bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX232"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
        <td bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX233"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
        <td align="center" bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX234"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
        <td width="15%" align="center" bgcolor="#EFEFEF"><strong><?= htmlspecialchars(dil("TX235"), ENT_QUOTES, 'UTF-8'); ?></strong></td>
    </tr>

    <?php
    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
        $ilink = ($dayarlar->permalink == 'Evet') ? htmlspecialchars($row->url, ENT_QUOTES, 'UTF-8') . '.html' : 'index.php?p=sayfa&id=' . htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8');
        $ilan_tarih = date("d.m.Y", strtotime($row->tarih));
    ?>
    <tr id="row_<?= htmlspecialchars($row->id, ENT_QUOTES, 'UTF-8'); ?>">
        <td id="mobtd"><img src="https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/<?= htmlspecialchars($row->resim, ENT_QUOTES, 'UTF-8'); ?>" width="100" height="75"/></td>
        <td><a href="<?= htmlspecialchars($ilink, ENT_QUOTES, 'UTF-8'); ?>"><strong><?= htmlspecialchars($row->baslik, ENT_QUOTES, 'UTF-8'); ?></strong></a><br>
        <span class="ilantarih"><?= htmlspecialchars(dil("TX236"), ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($ilan_tarih, ENT_QUOTES, 'UTF-8'); ?></span>
        <span class="ilantarih"><?php if ($row->durum == 1 OR $row->durum == 3) { ?><?= htmlspecialchars(dil("TX237"), ENT_QUOTES, 'UTF-8'); ?><?= htmlspecialchars($row->hit, ENT_QUOTES, 'UTF-8'); ?><?php } ?></span>
        </td>
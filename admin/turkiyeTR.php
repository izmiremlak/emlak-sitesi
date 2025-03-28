<?php 
include "../functions.php";
if($hesap->id != ""){
    header("Location:index.php");
    die("Access Denied User"); 
    exit;
}

if(strstr($_SERVER["HTTP_HOST"],"izmirtr.com")){
    $demo = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/images/favicon_1.ico">
    <title>Yönetim Paneli</title>
    <link href="assets/css/admin.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]-->

    <script type="text/javascript" src="assets/istmark/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="assets/istmark/jquery.form.min.js"></script>
    <!-- reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body <?=($demo == 1) ? 'onload="AjaxFormS(\'LoginForm\',\'login_status\');"' : '';?>>
    <div class="wrapper-page">
        <div class="panel panel-color panel-primary panel-pages">
            <div class="panel-heading bg-img" style="background-color:#333;">
                <div class="bg-overlay"></div>
                <h3 class="text-center m-t-10 text-white">YÖNETİM PANELİ</h3>
            </div>
            <div class="panel-body">
                <div style="" id="login_status"></div>
                
                <form class="form-horizontal m-t-20" action="ajax.php?p=login" id="LoginForm" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" type="text" name="email" placeholder="E-Posta" value="<?=($demo == 1) ? 'demo@example.com' : '';?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" type="password" name="parola" placeholder="Parola" value="<?=($demo == 1) ? 'demo' : '';?>">
                        </div>
                    </div>
                    <!-- reCAPTCHA -->
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="g-recaptcha" data-sitekey="6LeOm_8qAAAAAK2kYZDabxefz7VJO6Wq_ppVTDZg"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" name="otut" value="1" type="checkbox" checked>
                                <label for="checkbox-signup">Beni Hatırla</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-default btn-rounded waves-effect m-b-5" type="submit" onclick="AjaxFormS('LoginForm','login_status');">Oturum Aç</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-7"><a href="forget_password.php"><i class="fa fa-lock m-r-5"></i> Parolamı Hatırlat</a></div>
                        <div class="col-sm-5 text-right"><a href="../"><i class="fa fa-home"></i> Anasayfaya Dön</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    var resizefunc = [];
    function AjaxFormS(formId, statusId) {
        // "Form gönderiliyor..." mesajını göster ve en az 1 saniye kalmasını sağla
        $('#' + statusId).html('<p style="color:blue;">Form gönderiliyor...</p>');

        // reCAPTCHA’nın yüklendiğinden emin ol
        if (typeof grecaptcha === 'undefined') {
            $('#' + statusId).html('<p style="color:red;">Hata: reCAPTCHA yüklenemedi!</p>');
            return false;
        }

        // Token kontrolü ve AJAX isteği için gecikme
        setTimeout(function() {
            var recaptchaResponse = grecaptcha.getResponse();

            if (recaptchaResponse.length === 0) {
                $('#' + statusId).html('<p style="color:red;">Hata: Lütfen "Ben robot değilim" kutusunu işaretleyin!</p>');
                return false;
            }

            // Form verilerini topla
            var formData = $('#' + formId).serialize() + '&g-recaptcha-response=' + recaptchaResponse;

            // Demo modunda gönderilen verileri kontrol et
            <?php if($demo == 1) { ?>
                console.log("Demo modunda gönderilen veri: " + formData);
            <?php } ?>

            // AJAX isteği gönder
            $.ajax({
                url: 'ajax.php?p=login',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Sunucudan gelen yanıtı kontrol et
                    console.log("Sunucu yanıtı: " + response);
                    $('#' + statusId).html(response);
                    if (response.indexOf("Giriş yapılıyor...") !== -1) {
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 1000); // 1 saniye bekleyip yönlendir
                    } else if (response.indexOf("hatalı mail") !== -1) {
                        $('#' + statusId).html('<p style="color:red;">Hata: Hatalı e-posta adresi girdiniz!</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX hatası: " + error + " (HTTP Kodu: " + xhr.status + ")");
                    $('#' + statusId).html('<p style="color:red;">Hata: Sunucu ile bağlantı kurulamadı! (HTTP Kodu: ' + xhr.status + ')</p>');
                }
            });
        }, 500); // Token için 500ms gecikme
    }
    </script>
    <script src="assets/js/admin.min.js"></script>
</body>
</html>
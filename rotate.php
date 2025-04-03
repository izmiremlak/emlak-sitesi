<?php
// Gerekli fonksiyonları içe aktarır.
include "functions.php";

// Gelen verileri temizler ve doğrular.
$id = $gvn->rakam($_GET["id"]);
if ($id == '' || !is_numeric($id) || strlen($id) > 15 || $hesap->id == '') {
    die();
}

// Görseli veritabanında sorgular.
$sorgula = $db->prepare("SELECT * FROM galeri_foto WHERE site_id_555=999 AND id=? AND sayfa_id!=0");
$sorgula->execute([$id]);
if ($sorgula->rowCount() < 1) {
    die();
}
$gorsel = $sorgula->fetch(PDO::FETCH_OBJ);

// Sayfayı veritabanında sorgular.
$snc = $db->prepare("SELECT acid, id FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND id=?");
$snc->execute([$gorsel->sayfa_id]);
if ($snc->rowCount() < 1) {
    die();
}
$snc = $snc->fetch(PDO::FETCH_OBJ);

// Kullanıcı yetkisini kontrol eder.
if ($hesap->tipi != 1 && $hesap->tipi != 2) {
    $acc = $db->query("SELECT id, kid FROM hesaplar WHERE site_id_555=999 AND id=" . $snc->acid)->fetch(PDO::FETCH_OBJ);
    $kid = $acc->kid;
    if ($snc->acid != $hesap->id && $hesap->id != $kid) {
        die();
    }
}

// Görsel dosyasını belirler.
$resim = $gorsel->resim;
$uzanti = $fonk->uzanti($resim);
$radi = str_replace($uzanti, "", $resim);
$original_resim = "uploads/" . $radi . "_original" . $uzanti;

// Dosyanın varlığını kontrol eder.
if (!file_exists($original_resim)) {
    die('<center><br><h2>Bu görsel için döndürme aracı kullanılamaz. Yalnızca 19.07.2017 tarihinden sonra yüklediğiniz resimler için kullanabilirsiniz.</h2><br><button onclick="window.close();">Kapat</button></center>');
}
?>

<html>
<head>
    <title>Görseli Döndürme Aracı</title>
    <meta charset="utf8">
    <base href="<?=SITE_URL;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="<?=SITE_URL.THEME_DIR;?>css/font-awesome.min.css" media="none" onload="if(media!='all')media='all'"/>
    <link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,latin-ext' media="none" onload="if(media!='all')media='all'"/>

    <style type="text/css">
        * {margin:0;padding:0;}
        body {background:#3B3F3F;font-family: 'Titillium Web', sans-serif;}
        #toolBar {
            margin-top:30px;
            width:100%;
            min-height:50px;
            display:block;
            background-color:#8B0D0D;
            color:#FFF;
            position:fixed;
            bottom:0; right:0;
            z-index:5;
        }
        #toolBar .inner {
            width:100%;
            margin-left:auto;
            margin-right:auto;
            margin-top:16px;
            margin-bottom:0;
        }
        .buton1 {
            background-color:#C32626;
            padding:3px 12px;
            color:#FFF;
            font-weight:bold;
            font-size:24;
            cursor:pointer;
            border-radius: 6px;
            margin-left:3px;
            margin-right:3px;
        }
        #load_overlay {
            display:none;
            z-index:1;
            width:100%;
            height:100%;
            position:fixed;
            left:0;
            top:0;
        }
        .loading_background {
            width:100%;
            height:100%;
            opacity:0.5;
            background-color:#FFF;
            display:block;
            position:fixed;
            top:0;
            left:0;
        }
        .loading_inner {
            position:absolute;
            left:25%;
            top:25%;
            width:50%;
            height:300px;
            z-index:2;
            margin-left:auto;
            margin-right:auto;
            text-align:center;
        }
        .cssload-loader {
            width: 244px;
            height: 49px;
            line-height: 49px;
            text-align: center;
            position: absolute;
            left: 50%;
            transform: translate(-50%, -50%);
            text-transform: uppercase;
            font-weight: 900;
            font-size:18px;
            color: rgb(206,66,51);
            letter-spacing: 0.2em;
        }
        .cssload-loader::before, .cssload-loader::after {
            content: "";
            display: block;
            width: 15px;
            height: 15px;
            background: rgb(206,66,51);
            position: absolute;
            animation: cssload-load 0.81s infinite alternate ease-in-out;
        }
        .cssload-loader::before {
            top: 0;
        }
        .cssload-loader::after {
            bottom: 0;
        }
        @keyframes cssload-load {
            0% {
                left: 0;
                height: 29px;
                width: 15px;
            }
            50% {
                height: 8px;
                width: 39px;
            }
            100% {
                left: 229px;
                height: 29px;
                width: 15px;
            }
        }
        .svg-success {
            stroke-width: 2px;
            stroke: #8EC343;
            fill:none;
            & path {
                stroke-dasharray:17px, 17px; 
                stroke-dashoffset: 0px;
                animation: checkmark 0.25s ease-in-out 0.7s backwards;
            }
            & circle {
                stroke-dasharray:76px, 76px;
                stroke-dashoffset: 0px;
                transform:rotate(-90deg);
                transform-origin: 50% 50%;
                animation: checkmark-circle 0.6s ease-in-out forwards;
            }
        }
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 17px;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes checkmark-circle {
            0% {
                stroke-dashoffset: 76px;
            }
            100% {
                stroke-dashoffset: 0px;
            }
        }
        .frame {
            margin-bottom: 20px;
        }
        @media only screen and (min-width: 320px) and (max-width: 769px) {
            .frame img {width:100%;height:auto;}
            #complete {width:100%;text-align:center;  }
        }
    </style>

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="assets/js/jQueryRotateCompressed.js"></script>
    
    <script type="text/javascript">
    var derece=0, donme=90;

    $(document).ready(function(){
        var picture = $('#image');

        $("#sol_cevir").click(function(){
            if(derece-donme < -360){
                derece = -donme;
            } else {
                derece -= donme;
            }
            $("#image").rotate(derece);
        });

        $("#sag_cevir").click(function(){
            if(derece+donme > 360){
                derece = donme;
            } else {
                derece += donme;
            }
            $("#image").rotate(derece);
        });

        $("#kaydet").click(function(){
            $("#load_overlay").fadeIn(500);
            $("#yukleme").css("display","block");
            $("#complete").css("display","none");
            $.post("<?=SITE_URL;?>ajax.php?p=rotate&id=<?=$id;?>",{rotate:derece},function(output){
                if(output == 'OK'){
                    $("#yukleme").css("display","none");
                    $("#complete").css("display","block");
                    $("#complete").html('<strong style="color:white;text-align:center;font-size:120px;"><i class="fa fa-check"></i></strong><br><br><h4 style="color:white;font-size:24px;">İŞLEM TAMAMLANDI</h4>');
                    setTimeout(function() {
                        window.close();
                    }, 1000);
                } else {
                    $("#sonuc").html(output);
                    $("#load_overlay").fadeOut(500);
                }
            });
        });
    });
    </script>
</head>
<body>
    <div id="load_overlay">
        <div class="loading_background"></div>
        <div class="loading_inner">
            <div id="yukleme">
                <div class="cssload-loader">Ayarlanıyor...</div>
            </div>
            <div id="complete"></div>
        </div>
    </div>

    <center>
        <div class="frame">
            <img width="80%" src="<?=$original_resim;?>?time=<?=time();?>" id="image">
        </div>
    </center>

    <div id="toolBar">
        <div class="inner">
            <center>
                <a id="sol_cevir" class="buton1"><i class="fa fa-undo" aria-hidden="true"></i></a>
                <a id="sag_cevir" class="buton1"><i class="fa fa-repeat" aria-hidden="true"></i></a>
                <a id="kaydet" class="buton1"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                <div style="clear:both;margin-top:5px;"></div>
                <div id="sonuc" style="display:none;"></div>
            </center>
        </div>
    </div>
</body>
</html>
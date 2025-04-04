<?php include "../functions.php";

if($_GET["filtre"] != ''){
header("Location:.");
}

if($hesap->id == ""){
header("Location:login.php");
die(); exit;
}


if($hesap->tipi == 0){
header("Location:logout.php");
die(); exit;
}


$dilx		= $db->query("SELECT * FROM diller_19541956 WHERE kisa_adi='".$dil."'")->fetch(PDO::FETCH_OBJ);
$p			= $gvn->harf_rakam($_GET["p"]);

$mesaj1		= $db->query("SELECT id FROM mail_19541956 WHERE tipi=0 AND durumb=0")->rowCount();
$mesaj2		= $db->query("SELECT id FROM mail_19541956 WHERE tipi=1 AND durumb=0")->rowCount();
$mesaj3		= $db->query("SELECT id FROM mail_19541956 WHERE tipi=2 AND durumb=0")->rowCount();
$mesajlar	= ($mesaj1 + $mesaj2 + $mesaj3);

$satis1		= $db->query("SELECT id FROM upaketler_19541956 WHERE durumb=0")->rowCount();
$satis2		= $db->query("SELECT id FROM dopingler_group_19541956 WHERE durumb=0")->rowCount();
$satis3		= $db->query("SELECT id FROM onecikan_danismanlar_19541956 WHERE durumb=0")->rowCount();
$satislar	= ($satis1 + $satis2 + $satis3);

$msjcnt2	= $db->query("SELECT id FROM sayfalar WHERE site_id_555=999 AND ekleme=1 AND durum=0 AND tipi=4")->rowCount();

if($hesap->email == 'info@izmirtr.com' AND $hesap->parola == 'admin12345678?' AND $p != 'hesap_ayarlari'){
header("Location:index.php?p=hesap_ayarlari");
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="izmirtr">
    <meta name="author" content="izmirtr.com">
    <link rel="shortcut icon" href="assets/images/favicon_1.ico">
    <title>Yönetim Paneli</title>
    <link href="assets/vendor/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/css/admin.min.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type='text/css' href="../modules/css/font-awesome.min.css"/>
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]-->

<style>
.button-menu-mobile {display:none;}
</style>
</head>

<body class="fixed-left">
    <div id="wrapper">


        <div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">
                <div class="user-details">
                    <div class="pull-left"><img src="<?=($hesap->avatar == '') ? 'https://www.turkiyeemlaksitesi.com.tr/assets/images/users/no-avatar.png' : 'https://www.turkiyeemlaksitesi.com.tr/uploads/thumb/'.$hesap->avatar; ?>" alt="" class="thumb-md img-circle"></div>
                    <div class="user-info">
                        <div class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?=$hesap->adi.' '.$hesap->soyadi;?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?p=hesap_ayarlari"><i class="md md-settings"></i> Hesap Ayarları</a></li>
                                <li><a href="logout.php"><i class="md md-settings-power"></i> Çıkış Yap</a></li>
                            </ul>
                        </div>
                        <p class="text-muted m-0"><a href="../" target="_blank" class="sitegorlink">» Siteyi Görüntüle</a></p>
                    </div>
                </div>
                <div id="sidebar-menu">
                <button class="button-menu-mobile open-left"><i class="fa fa-bars"></i></button>
<ul>
<li><a href="index.php" class="waves-effect waves-light <?=($p == '') ? 'active' : '';?>"><i class="md md-home"></i><span>Başlangıç</span></a></li>
<li><a href="index.php?p=gayarlar" class="waves-effect waves-light <?=($p == 'gayarlar') ? 'active' : '';?>"><i class="md md-settings"></i><span>Genel Ayarlar</span></a></li>

<li><a class="waves-effect waves-light <?=($p == 'uyeler' OR $p == 'uye_duzenle') ? 'active' : '';?>"><i class="fa fa-users"></i><span>Üyelik</span></a>
<ul>
<li><a href="index.php?p=uyeler" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Üye Listesi</span></a></li>
<li><a href="index.php?p=uyelik_ayarlari" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Standart Ayarlar</span></a></li>
<li><a href="index.php?p=uyelik_paketleri" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Mağaza Paketleri</span></a></li>
<li><a href="index.php?p=mail_sablonlar"><span><i class="fa fa-angle-right" aria-hidden="true"></i> Bildirim Şablonları</span></a></li>
</ul>
</li>


<li><a href="index.php?p=ilanlar" class="waves-effect waves-light <?=($p == 'ilanlar') ? 'active' : '';?>"><i class="fa fa-road" aria-hidden="true"></i><span>İlan Yönetimi</span> <?=($msjcnt2 > 0 ) ? '<span class="badge badge-danger">'.$msjcnt2.'</span>' : ''; ?></a></li>


<li><a class="waves-effect waves-light <?=($p == 'upaketler') ? 'active' : '';?>"><i class="fa fa-try"></i><span>Satışlar</span> <?=($satislar > 0 ) ? '<span class="badge badge-danger">'.$satislar.'</span>' : ''; ?></a>
<ul>
<li><a href="index.php?p=upaketler" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Mağaza Satışları</span> <?=($satis1 > 0 ) ? '<span class="badge badge-danger">'.$satis1.'</span>' : ''; ?></a></li>
<li><a href="index.php?p=dopingler" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Dopingler</span> <?=($satis2 > 0 ) ? '<span class="badge badge-danger">'.$satis2.'</span>' : ''; ?></a></li>
<li><a href="index.php?p=onecikan_danismanlar" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Danışmanlar</span> <?=($satis3 > 0 ) ? '<span class="badge badge-danger">'.$satis3.'</span>' : ''; ?></a></li>
</ul>
</li>



<li><a href="#" class="waves-effect waves-light <?=($p == 'gelen_mesajlar') ? 'active' : '';?>"><i class="md md-mail"></i><span>Mesajlar</span> <?=($mesajlar > 0 ) ? '<span class="badge badge-danger">'.$mesajlar.'</span>' : ''; ?></a>
<ul>
<li><a href="index.php?p=gelen_mesajlar" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>İletişim Formu</span> <?=($mesaj1 > 0 ) ? '<span class="badge badge-danger">'.$mesaj1.'</span>' : ''; ?></a></li>
<li><a href="index.php?p=hatali_ilanlar" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Hatalı İlanlar</span> <?=($mesaj2 > 0 ) ? '<span class="badge badge-danger">'.$mesaj2.'</span>' : ''; ?></a></li>
<li><a href="index.php?p=talep_formlari" class="waves-effect waves-light"><i class="fa fa-angle-right" aria-hidden="true"></i> <span>Talep Formları</span> <?=($mesaj3 > 0 ) ? '<span class="badge badge-danger">'.$mesaj3.'</span>' : ''; ?></a></li>
</ul>
</li>	

<li><a href="#" class="waves-effect waves-light"><i class="fa fa-plus" aria-hidden="true"></i> <span>Web Sitesi Yönetimi</span></a>
<ul>
<li><a href="#" class="waves-effect waves-light <?=($p == 'toplu_email' OR $p == 'toplu_sms') ? 'active' : '';?>"><i class="md md-mail"></i><span>Toplu SMS / Mail</span> </a>
<ul>
<li><a href="index.php?p=toplu_email" class="waves-effect waves-light <?=($p == 'toplu_email') ? 'active' : '';?>"><i class="md md-mail"></i><span>Toplu E-Mail</span></a></li>
<li><a href="index.php?p=toplu_sms" class="waves-effect waves-light <?=($p == 'toplu_sms') ? 'active' : '';?>"><i class="md md-mail"></i><span>Toplu SMS</span></a></li>
</ul>
</li>
<li><a href="index.php?p=seolinkler" class="waves-effect waves-light <?=($p == 'seolinkler') ? 'active' : '';?>"><i class="fa fa-link" aria-hidden="true"></i><span>SEO Linkler</span></a></li>

<li><a href="index.php?p=sayfalar" class="waves-effect waves-light <?=($p == 'sayfalar') ? 'active' : '';?>"><i class="ion-ios7-paper"></i><span>Sayfalar</span></a></li>

<li><a href="index.php?p=projeler" class="waves-effect waves-light <?=($p == 'projeler') ? 'active' : '';?>"><i class="fa fa-building-o" aria-hidden="true"></i><span>Projeler</span></a></li>
<li><a href="index.php?p=foto_slider" class="waves-effect waves-light <?=($p == 'foto_slider') ? 'active' : '';?>"><i class="md md-filter"></i><span>Slider</span></a></li>

<li><a href="index.php?p=yazilar" class="waves-effect waves-light <?=($p == 'yazilar') ? 'active' : '';?>"><i class="ion-ios7-paper-outline"></i><span>Duyurular</span></a></li>
<li><a href="index.php?p=haber_ve_duyurular" class="waves-effect waves-light <?=($p == 'haber_ve_duyurular') ? 'active' : '';?>"><i class="ion-speakerphone"></i><span>Haberler</span></a></li>

<li><a href="index.php?p=sehirler" class="waves-effect waves-light <?=($p == 'sehirler') ? 'active' : '';?>"><i class="md-room"></i><span>İl ve İlçe Bloklar</span></a></li>
<li><a href="index.php?p=subeler" class="waves-effect waves-light <?=($p == 'subeler') ? 'active' : '';?>"><i class="md-room"></i><span>Şubeler</span></a></li>

<li><a href="index.php?p=reklamlar" class="waves-effect waves-light <?=($p == 'reklamlar' || $p == 'reklam_ekle' || $p == 'reklam_duzenle') ? 'active' : '';?>"><i class="fa fa-rocket"></i><span>Reklamlar</span></a></li>
<li><a href="index.php?p=menuler" class="waves-effect waves-light <?=($p == 'menuler') ? 'active' : '';?>"><i class="md md-menu"></i><span>Üst Menü Ayarları</span></a></li>
</ul>
</li>


<li><a href="#" class="waves-effect waves-light"><i class="md md-flag"></i><span>Diller ve Bölge</span> </a>
<ul>
<?php
$dilsr		= $db->query("SELECT * FROM diller_19541956 ORDER BY sira ASC");
while($row	= $dilsr->fetch(PDO::FETCH_OBJ)){
?>
<li><a href="index.php?p=dil_duzenle&id=<?=$row->id;?>&dil=<?=$row->kisa_adi;?>"><?=$row->adi;?></a></li>
<?
}
?>
<li><a href="index.php?p=dil_ekle">Dil Ekle</a></li>
<li><a href="index.php?p=bolgeler" class="waves-effect waves-light <?=($p == 'bolgeler') ? 'active' : '';?>"><i class="md-room"></i><span>Bölgeler</span></a></li>
</ul>
</li>

</ul>
                    
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
            </div>
        </div>
		
        <div class="content-page">
		<!-- Content Start -->
		<? if($dil != 'tr'){ ?>
		<div class="alert alert-danger">Şuanda <strong><?=$dilx->adi;?></strong> dil versiyonundasınız. Yaptığınız tüm işlemler <strong><?=$dilx->adi;?></strong> dili için geçerli olacaktır.</div><? } ?>

		<?php
		$pdir	= 'pages/'.$p.'.php';

		if($p == ''){
		require "pages/index.php";
		}elseif(file_exists($pdir)){
		require $pdir;
		}else{
		require "pages/404.php";
		}

		?>
	<script type="text/javascript" src="assets/istmark/jquery.form.min.js"></script>
	<script type="text/javascript" src="assets/istmark/main_script.js"></script>
	
	
	<!-- Editor Resim Yükleme Şeysi Start -->
<div id="resim_progress" style="display:none; width:100%; height:100%; position:fixed; top:0; left:0; background: rgba(0, 0, 0, 0.6); color:#FFF;text-align:center;">
<center>
<h4 style="color:#fff;margin-top:20%;">Yükleniyor...</h4>
<img src="assets/images/ajax-loader.gif" />
</center>
</div>
<!-- Editor Resim Yükleme şeysi End -->

</body>
</html>
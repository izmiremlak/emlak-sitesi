<?php
// Hata yönetimi: Hataları sitede göster ve bir dosyaya logla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Özelleştirilmiş hata yöneticisi ayarla
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    // Hata mesajını log dosyasına yaz
    $logMessage = "Error [$errno] $errstr in $errfile on line $errline\n";
    error_log($logMessage, 3, '/path/to/error.log'); // Log dosyasının yolunu güncelleyin
    
    // Hata mesajını sitede göster
    echo "<div class='error-message'>Bir hata oluştu. Lütfen daha sonra tekrar deneyin.</div>";
});

// SEO META TAGS
echo '<meta name="description" content="Genel Ayarlar Sayfası - Site Genel Ayarları, SEO, Güvenlik ve Daha Fazlası.">';
echo '<meta name="robots" content="index, follow">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<meta name="author">';
?>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">Genel Ayarlar</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs tabs">
                    <li class="active tab">
                    <a href="#tab1" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">Site Ayarları</span></a></li>
                    
                    <li class="tab">
                    <a href="#tab2" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">Site Bilgileri</span></a>
                    </li>
                    
                    <li class="tab">
                    <a href="#tab7" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">Tahsilat Ayarları</span></a>
                    </li>
                    
                    <li class="tab">
                    <a href="#tab3" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">SMTP Bilgileri</span></a>
                    </li>
                    
                    <li class="tab">
                    <a href="#tab4" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">SMS Ayarları</span></a>
                    </li>
                    
                    <li class="tab">
                    <a href="#tab5" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">Footer Linkler</span></a>
                    </li>
                    
                    <li class="tab">
                    <a href="#tab6" data-toggle="tab" aria-expanded="false">
                    <span class="hidden-xs">Arka Plan Görselleri</span></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div id="tab1_status"></div>
                        <form role="form" class="form-horizontal" id="tab1_form" method="POST" action="ajax.php?p=gayarlar" onsubmit="return false;" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Üst Logo Yükle</h3>
                                    </div>
                                    <div class="panel-body" style="height:150px;">
                                        <div class="form-group">
                                            <label for="logo" class="col-sm-3 control-label">Logo</label>
                                            Logo enfazla 230px - 70 px olmalı
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="logo" name="logo" style="width:210px;">
                                                <br />
                                                <img src="../uploads/thumb/<?=$gayarlar->logo;?>" id="logo_src"  height="50"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Footer(Alt) Logo Yükle</h3>
                                    </div>
                                    <div class="panel-body" style="height:150px;">
                                        <div class="form-group">
                                            <label for="footer_logo" class="col-sm-3 control-label">Footer(Alt) Logo</label>
                                            Logo enfazla 210px - 50 px olmalı
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="footer_logo" name="footer_logo" style="width:210px;">
                                                <br />
                                                <img style="background:#ccc;" src="../uploads/thumb/<?=$gayarlar->footer_logo;?>" id="footer_logo_src" height="50" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Favicon Yükle ( Site Domain çubuğunun başındaki küçük logo )</h3>
                                    </div>
                                    <div class="panel-body" style="height:150px;">
                                        <div class="form-group">
                                            <label for="favicon" class="col-sm-3 control-label">Favicon</label>
                                            Logo enfazla 15px x 15 px olmalı
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="ficon" name="ficon" style="width:210px;">
                                                <br />
                                                <img src="../favicon.ico" id="ficon_src" height="15"/>
                                                <font style="margin-left:10px;font-size:14px;margin-top:5px;">Favicon dosyası  ".ico" uzantılı olmalıdır.</font>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Watermark Yükle</h3>
                                    </div>
                                    <div class="panel-body" style="height:150px;">
                                        <div class="form-group">
                                            <label for="watermark" class="col-sm-3 control-label">Watermark</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="watermark" name="watermark">
                                                <br />
                                                <a target="_blank" href="../watermark.png"><img style="background:#333;float:left;margin-right:5px;" src="../watermark.png" id="watermark_src" height="50"/></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <style>
                                .fa-sort {color:#ccc;cursor:move}
                            </style>

                            <div class="panel-group panel-group-joined" id="accordion-test">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion-test" href="#digerayarlar" class="collapsed" aria-expanded="false">
                                                Genel Ayarlar<br>
                                                <span style="font-size:15px;font-weight:100;">(Özelleştirilebilir Tüm Ayarlar)</span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="digerayarlar" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div style="padding:20px;">
                                            <div class="form-group">
                                                <label for="default_dil" class="col-sm-3 control-label">Default Dil</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="default_dil" id="default_dil">
                                                        <option value="oto">Otomatik</option>
                                                        <?php
                                                        $dilsg = $db->query("SELECT * FROM diller_501 ORDER BY id ASC");
                                                        while($dili = $dilsg->fetch(PDO::FETCH_OBJ)){
                                                        ?>
                                                        <option value="<?=$dili->kisa_adi;?>" <?=($gayarlar->default_dil == $dili->kisa_adi) ? 'selected' : ''; ?>><?=$dili->adi;?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <span style="font-size:14px;">Site ilk açılışta görüntülenecek dil. (Otomatik seçilirse, ziyaretçi lokasyonuna göre uygun olan dil otomatik seçilir.)</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Yönetici Bildirim E-Posta</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="yemails" value="<?=$dayarlar->yemails;?>" placeholder="Birden fazla girmek için virgül ile ayırınız.">
                                                    <span style="font-size:14px;">E-Posta bildirimlerini alacak yetkili e-posta adresleri giriniz. Birden fazla girmek için virgül ile ayırınız.</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Yönetici Bildirim GSM</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="yphones" value="<?=$dayarlar->yphones;?>" placeholder="Birden fazla girmek için virgül ile ayırınız.">
                                                    <span style="font-size:14px;">SMS bildirimlerini alacak yetkili GSM numaraları giriniz. Birden fazla girmek için virgül ile ayırınız.</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="permalink" class="col-sm-3 control-label">SEF Link:</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="permalink_check" class="stm-checkbox" value="Evet" name="permalink" <?=($dayarlar->permalink == 'Evet') ? 'checked' : ''; ?>>
                                                    <label style="float:left;margin-right:10px;" for="permalink_check" class="stm-checkbox-label"></label><span style="margin-left:10px;font-size:14px;">(Site içi link yapısını sef (search engine friendly) link yapısına çevirir.)</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="urun_siparis" class="col-sm-3 control-label">Slider Üstü Arama:</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="urun_siparis_check" class="stm-checkbox" value="1" name="urun_siparis" <?=($gayarlar->urun_siparis == 1) ? 'checked' : ''; ?>>
                                                    <label style="float:left;margin-right:10px;" for="urun_siparis_check" class="stm-checkbox-label"></label>
                                                    <span style="margin-left:10px;font-size:14px;margin-top:5px;">(Anasayfada bulunan slider'in üzerindeki arama kısmıdır. İsteğe bağlı pasif edilebilir.)</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Watermark Damgalama:</label>
                                                <div class="col-sm-8">
                                                    <input type="checkbox" id="stok_check" class="stm-checkbox" value="1" name="stok" <?=($gayarlar->stok == 1) ? 'checked' : ''; ?>>
                                                    <label style="float:left;margin-right:10px;" for="stok_check" class="stm-checkbox-label"></label>
                                                    <span style="margin-left:10px;font-size:14px;margin-top:5px;">(Aktif edildiğinde ilan görsellerine yükleyeceğiniz watermark görseli basılacaktır.)</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">SSL</label>
                                                <div class="col-sm-9">
                                                    <div class="checkbox checkbox-success">
                                                        <input id="site_ssl_check" type="checkbox" name="site_ssl" value="1" <?=($gayarlar->site_ssl == 1) ? 'checked' : ''; ?>>
                                                        <label for="site_ssl_check"><STRONG>Aktif</STRONG></label> <span style="font-size:14px;"> (Sitenizi Https üzerinden çalıştıracaksanız aktif ediniz.)</span>
                                                    </div>
                                                </div>
                                            </div>  


<div class="form-group">
    <label class="col-sm-3 control-label">www. </label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="site_www_check" type="checkbox" name="site_www" value="1" <?= ($gayarlar->site_www == 1) ? 'checked' : ''; ?>>
            <label for="site_www_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Sitenizin başına otomatik www. eklenmesini istiyorsanız aktif ediniz.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Üyelik Sistemi</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="uyelik_check" type="checkbox" name="uyelik" value="1" <?= ($gayarlar->uyelik == 1) ? 'checked' : ''; ?>>
            <label for="uyelik_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Ziyaretçileriniz hesap oluşturarak ilan ekleyebilirler.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">T.C.K.N Zorunluluğu</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="tcnod_check" type="checkbox" name="tcnod" value="1" <?= ($gayarlar->tcnod == 1) ? 'checked' : ''; ?>>
            <label for="tcnod_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Üyelik esnasında bireysel üyelerden geçerli bir T.C. Kimlik Numarası istenir.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Mobil Onay</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="sms_aktivasyon_check" type="checkbox" name="sms_aktivasyon" value="1" <?= ($gayarlar->sms_aktivasyon == 1) ? 'checked' : ''; ?>>
            <label for="sms_aktivasyon_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Üyelik esnasında mobil onay istenir. SMS aktivasyonu gereklidir.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Adres Zorunluluğu</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="adresd_check" type="checkbox" name="adresd" value="1" <?= ($gayarlar->adresd == 1) ? 'checked' : ''; ?>>
            <label for="adresd_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Üyelik esnasında açık adres bilgisi istenir.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Anlık Mesajlaşma</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="anlik_sohbet_check" type="checkbox" name="anlik_sohbet" value="1" <?= ($gayarlar->anlik_sohbet == 1) ? 'checked' : ''; ?>>
            <label for="anlik_sohbet_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Üyeleriniz kendi aralarında anlık olarak mesajlaşabilirler.)</span>
        </div>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Doping Sistemi</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="dopingler_501_check" type="checkbox" name="dopingler_501" value="1" <?= ($gayarlar->dopingler_501 == 1) ? 'checked' : ''; ?>>
            <label for="dopingler_501_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(İlanlara doping özelliği vererek kazanç sağlayın.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Reklam Sistemi</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="reklamlar_check" type="checkbox" name="reklamlar" value="1" <?= ($gayarlar->reklamlar == 1) ? 'checked' : ''; ?>>
            <label for="reklamlar_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(Belirli alanlarda reklam yayını yapmak istiyorsanız aktif ediniz.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Doviz Kurları</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="doviz_check" type="checkbox" name="doviz" value="1" <?= ($gayarlar->doviz == 1) ? 'checked' : ''; ?>>
            <label for="doviz_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(İlan detayında doviz kuru çıkar.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Kredi Hesaplama</label>
    <div class="col-sm-9">
        <div class="checkbox checkbox-success">
            <input id="kredih_check" type="checkbox" name="kredih" value="1" <?= ($gayarlar->kredih == 1) ? 'checked' : ''; ?>>
            <label for="kredih_check"><strong>Aktif</strong></label> <span style="font-size:14px;">(İlan detayında Kredi Hesaplama çıkar.)</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Tema Renk 1:</label>
    <div class="col-sm-2">
        <div class="cp2 input-group colorpicker-component">
            <input name="renk1" type="text" value="<?= htmlspecialchars($gayarlar->renk1); ?>" class="form-control" />
            <span class="input-group-addon"><i></i></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Tema Renk 2:</label>
    <div class="col-sm-2">
        <div class="cp2 input-group colorpicker-component">
            <input name="renk2" type="text" value="<?= htmlspecialchars($gayarlar->renk2); ?>" class="form-control" />
            <span class="input-group-addon"><i></i></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="watermark" class="col-sm-3 control-label">Sitemap</label>
    <div class="col-sm-9">
        <?php
        $sql = $db->query("SELECT * FROM diller_501 ORDER BY sira ASC");
        while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            $oneki = $row->kisa_adi;
            $onekiup = strtoupper($oneki);
        ?>
            <span style="float: left; margin-top: 7px;"><strong>(<?= htmlspecialchars($onekiup); ?>)</strong> <a href="<?= htmlspecialchars(SITE_URL); ?>sitemap.xml?dil=<?= htmlspecialchars($oneki); ?>" target="_blank"> <?= htmlspecialchars(SITE_URL); ?>sitemap.xml?dil=<?= htmlspecialchars($oneki); ?></a></span>
        <?php } ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Banlist:</label>
    <div class="col-md-9">
        <button class="btn btn-danger waves-effect waves-light" type="button" onclick="ajaxHere('ajax.php?p=ban_list_temizle','hidden_result');"><i class="fa fa-trash"></i> Temizle</button> <span style="font-size:14px;">(Üyelik esnasında çok sayıda hatalı denemeler yaparak engelenen datayı temizleyebilirsiniz.)</span>
        <div id="hidden_result" style="display:none"></div>
    </div>
</div>

<div class="form-group" style="display:none">
    <label class="control-label col-md-3">Ürün Broşür Link:</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="urun_brosur_link" value="<?= htmlspecialchars($dayarlar->urun_brosur_link); ?>" />
    </div>
</div>
</div>
</div>
</div> <!--accordion blok bitis -->

<div class="panel panel-default"><!--accordion blok -->
<div class="panel-heading">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion-test" href="#anasayfayonetimi" class="collapsed" aria-expanded="false">
Anasayfa Ayarları<br>
<span style="font-size:15px;font-weight:100;">(Anasayfada yer alan kısımları, aşağıdaki ayarlar ile aktif/pasif edebilir ve sıralamasını değiştirebilirsiniz.)</span>
</a>
</h4>
</div>
<div id="anasayfayonetimi" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
<div style="padding:20px;">
<!-- Sürükle bırak kodları start -->
<?php
$bloklar = array();
$bloklar[$dayarlar->blok1_sira] = 'blok1';
$bloklar[$dayarlar->blok2_sira] = 'blok2';
$bloklar[$dayarlar->blok3_sira] = 'blok3';
$bloklar[$dayarlar->blok4_sira] = 'blok4';
$bloklar[$dayarlar->blok5_sira] = 'blok5';
$bloklar[$dayarlar->blok6_sira] = 'blok6';
$bloklar[$dayarlar->blok7_sira] = 'blok7';
$bloklar[$dayarlar->blok8_sira] = 'blok8';
$bloklar[$dayarlar->blok9_sira] = 'blok9';
ksort($bloklar);
?>
<ul id="list" class="uk-nestable" data-uk-nestable="{maxDepth:1}">
<?php
foreach($bloklar as $k=>$v){

if($v == 'blok1'){ // blok1 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Anasayfa Vitrin İlanları:</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok1_check" class="stm-checkbox" value="1" name="blok1" <?=($dayarlar->blok1 == 1) ? 'checked' : '';?>>
        <label for="blok1_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?php
} // blok1 end

if($v == 'blok2'){ // blok2 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Haberler:</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok2_check" class="stm-checkbox" value="1" name="blok2" <?=($dayarlar->blok2 == 1) ? 'checked' : '';?>>
        <label for="blok2_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?php
} // blok2 end


if($v == 'blok3'){ // blok3 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
    <div class="form-group">
        <div style="width:250px;float:left;font-weight:bold;text-align:right;">İlan Ver Tanıtımı:</div>
        <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
            <input type="checkbox" id="blok3_check" class="stm-checkbox" value="1" name="blok3" <?=($dayarlar->blok3 == 1) ? 'checked' : '';?>>
            <label for="blok3_check" class="stm-checkbox-label"></label>
        </div>
        <div style="width:50px;float:left;margin-top: -5px;">
            <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
        </div>
    </div>
</li>
<?
} // blok3 end

if($v == 'blok4'){ // blok4 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
    <div class="form-group">
        <div style="width:250px;float:left;font-weight:bold;text-align:right;">İl ve İlçe Blokları:</div>
        <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
            <input type="checkbox" id="blok4_check" class="stm-checkbox" value="1" name="blok4" <?=($dayarlar->blok4 == 1) ? 'checked' : '';?>>
            <label for="blok4_check" class="stm-checkbox-label"></label>
        </div>
        <div style="width:50px;float:left;margin-top: -5px;">
            <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
        </div>
    </div>
</li>
<?
} // blok4 end


if($v == 'blok5'){ // blok5 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Anasayfa Özel İlanlar:</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok5_check" class="stm-checkbox" value="1" name="blok5" <?=($dayarlar->blok5 == 1) ? 'checked' : '';?>>
        <label for="blok5_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?
} // blok5 end

if($v == 'blok6'){ // blok6 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Öne Çıkan İlanlarda Göster:</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok6_check" class="stm-checkbox" value="1" name="blok6" <?=($dayarlar->blok6 == 1) ? 'checked' : '';?>>
        <label for="blok6_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?
} // blok6 end

if($v == 'blok7'){ // blok7 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Anasayfa Danışmanlar :</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok7_check" class="stm-checkbox" value="1" name="blok7" <?=($dayarlar->blok7 == 1) ? 'checked' : '';?>>
        <label for="blok7_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?
} // blok7 end

if($v == 'blok8'){ // blok8 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Reklam Alanı Üst (728x90):</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok8_check" class="stm-checkbox" value="1" name="blok8" <?=($dayarlar->blok8 == 1) ? 'checked' : '';?>>
        <label for="blok8_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?
} // blok8 end

if($v == 'blok9'){ // blok9 start
?>
<li class="uk-nestable-item" data-id="<?=$k;?>" data-name="<?=$v;?>">
<div class="form-group">
    <div style="width:250px;float:left;font-weight:bold;text-align:right;">Reklam Alanı Alt (728x90):</div>
    <div style="width: 50px;float: left;margin-top: -20px;margin-right: 15px;margin-left: 15px;">
        <input type="checkbox" id="blok9_check" class="stm-checkbox" value="1" name="blok9" <?=($dayarlar->blok9 == 1) ? 'checked' : '';?>>
        <label for="blok9_check" class="stm-checkbox-label"></label>
    </div>
    <div style="width:50px;float:left;margin-top: -5px;">
        <font style="color:black; font-size:24px;"><i class="fa fa-sort" aria-hidden="true"></i></font>
    </div>
</div>
</li>
<?
} // blok9 end

} // bloklist end & foreach end
?>
</ul>
<!-- sürükle bırak kodları end -->
</div></div>
</div><!--accordion blok bitis -->

<div class="panel panel-default"><!--accordion blok  -->
<div class="panel-heading">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion-test" href="#sidebaryonetimi" class="collapsed" aria-expanded="false">
Sidebar Ayarları<br>
<span style="font-size:15px;font-weight:100;">(Sayfa yapılarında sol tarafda bulunan sidebar alanını, aşağıdaki ayarlar ile aktif/pasif edebilir ve görünmemesini sağlayabilirsiniz.)</span>
</a>
</h4>
</div>

<div id="sidebaryonetimi" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
<div style="padding:20px;">
<div class="form-group" style="display:none">
    <label class="col-sm-3 control-label">Ürünler Sidebar:</label>
    <div class="col-sm-9">
        <input type="checkbox" id="urunler_sidebar_check" class="stm-checkbox" value="1" name="urunler_sidebar" <?=($gayarlar->urunler_sidebar == 1) ? 'checked' : '';?>>
        <label for="urunler_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Sayfalar Sidebar:</label>
    <div class="col-sm-0">
        <input type="checkbox" id="sayfa_sidebar_check" class="stm-checkbox" value="1" name="sayfa_sidebar" <?=($gayarlar->sayfa_sidebar == 1) ? 'checked' : '';?>>
        <label for="sayfa_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Haberler Sidebar:</label>
    <div class="col-sm-0">
        <input type="checkbox" id="haberler_sidebar_check" class="stm-checkbox" value="1" name="haberler_sidebar" <?=($gayarlar->haberler_sidebar == 1) ? 'checked' : '';?>>
        <label for="haberler_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Duyurular Sidebar:</label>
    <div class="col-sm-0">
        <input type="checkbox" id="blog_sidebar_check" class="stm-checkbox" value="1" name="blog_sidebar" <?=($gayarlar->blog_sidebar == 1) ? 'checked' : '';?>>
        <label for="blog_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Gelişmiş Arama:</label>
    <div class="col-sm-0">
        <input type="checkbox" id="hizmetler_sidebar_check" class="stm-checkbox" value="1" name="hizmetler_sidebar" <?=($gayarlar->hizmetler_sidebar == 1) ? 'checked' : '';?>>
        <label for="hizmetler_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>

<div class="form-group" style="display:none">
    <label class="col-sm-3 control-label">Projeler Sidebar:</label>
    <div class="col-sm-0">
        <input type="checkbox" id="projeler_sidebar_check" class="stm-checkbox" value="1" name="projeler_sidebar" <?=($gayarlar->projeler_sidebar == 1) ? 'checked' : '';?>>
        <label for="projeler_sidebar_check" class="stm-checkbox-label"></label>
    </div>
</div>
</div>
</div>
</div> <!--accordion blok bitis -->

</div> <!--accordion genel bitis -->


<button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab1_form','tab1_status');">Güncelle</button>
</div>
</form>
</div>

<div class="tab-pane" id="tab2">
    <div id="tab2_status"></div>
    <form role="form" class="form-horizontal" id="tab2_form" method="POST" action="ajax.php?p=dayarlar" onsubmit="return false;" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Anasayfa Başlık (Title)</label>
            Site domain başlığındaki yazı
            <div class="col-sm-9">
                <input type="text" class="form-control" id="title" name="title" value="<?=$dayarlar->title;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="keywords" class="col-sm-3 control-label">Anahtar Kelimeler (Keywords)</label>
            <div class="col-sm-9">
                <input name="keywords" id="keywords" class="form-control tags" value="<?=$dayarlar->keywords;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Site Açıklaması (Description)</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" id="description" name="description"><?=$dayarlar->description;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="facebook" class="col-sm-3 control-label">Facebook</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="facebook" name="facebook" value="<?=$dayarlar->facebook;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="twitter" class="col-sm-3 control-label">Twitter</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="twitter" name="twitter" value="<?=$dayarlar->twitter;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="instagram" class="col-sm-3 control-label">Instagram</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="instagram" name="instagram" value="<?=$dayarlar->instagram;?>">
            </div>
        </div>
        <div class="form-group" style="display:none">
            <label for="google" class="col-sm-3 control-label">Google+</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="google" name="google" value="<?=$dayarlar->google;?>">
            </div>
        </div>
        <div class="form-group" style="display:none">
            <label for="slogan1" class="col-sm-3 control-label">Slogan 1</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="slogan1" name="slogan1" value="<?=$dayarlar->slogan1;?>">
            </div>
        </div>
        <div class="form-group" style="display:none">
            <label for="slogan2" class="col-sm-3 control-label">Slogan 2</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="slogan2" name="slogan2" value="<?=$dayarlar->slogan2;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="slogan3" class="col-sm-3 control-label">Footer Yazı</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="slogan3" name="slogan3" value="<?=$dayarlar->slogan3;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="telefon" class="col-sm-3 control-label">Telefon</label>
            Anasayfa üst ve Altta Gözükmesini istediğiniz Telefon numaranızı buraya yazınız.
            <div class="col-sm-9">
                <input type="text" class="form-control" id="telefon" name="telefon" value="<?=$dayarlar->telefon;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="faks" class="col-sm-3 control-label">Faks</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="faks" name="faks" value="<?=$dayarlar->faks;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="gsm" class="col-sm-3 control-label">GSM</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="gsm" name="gsm" value="<?=$dayarlar->gsm;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">E-Posta</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" value="<?=$dayarlar->email;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="adres" class="col-sm-3 control-label">Adres</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" id="adres" name="adres"><?=$dayarlar->adres;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="analytics" class="col-sm-3 control-label">Analytics Kodu</label>
            <div class="col-sm-9">
                <textarea class="form-control" placeholder="Google Analytics kodunuzu bu alana ekleyiniz." rows="5" id="analytics" name="analytics"><?=$dayarlar->analytics;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="verification" class="col-sm-3 control-label">Google Doğrulama Etiketi</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="2" id="verification" placeholder="Webmaster Tools doğrulama kodunuzu bu alana ekleyebilirsiniz." name="verification"><?=$dayarlar->verification;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="verification" class="col-sm-3 control-label">Google Api Key</label>
            Google Harita ve Sokak görünümü için https://cloud.google.com/apis alacağınız API KEY i buraya yazın
            <div class="col-sm-9">
                <input type="text" class="form-control" id="google_api_key" placeholder="" name="google_api_key" value="<?=$gayarlar->google_api_key;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="embed" class="col-sm-3 control-label">Embed Kodu</label>
            <div class="col-sm-9">
                <textarea class="form-control" placeholder="Canlı destek kodu ve benzeri harici kodları bu alana ekleyebilirsiniz." rows="5" id="embed" name="embed"><?=$dayarlar->embed;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="google_maps" class="col-sm-3 control-label">Google Maps<br><span style="font-weight:lighter;font-size:14px;">Harita üzerindeki işaretçiyi tutup istediğiniz alana sürükleyip bırakınız. </span></label>
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="col-sm-1 control-label">Şehir</label>
                    <div class="col-sm-11">
                        <select name="map_il" class="form-control" onchange="yazdir();ajaxHere('ajax.php?p=ilce_getir_string&il_adi='+this.options[this.selectedIndex].value,'map_ilce');">
                            <option value="">Seçiniz</option>
                            <?php
                            $sql = $db->query("SELECT id,il_adi FROM il ORDER BY id ASC");
                            while($row = $sql->fetch(PDO::FETCH_OBJ)){
                            ?><option><?=$row->il_adi;?></option><?
                            }
                            ?>
                        </select>
                    </div><!-- col end -->
                </div><!-- row end -->
				
<div class="form-group">
    <label class="col-sm-1 control-label">İlçe</label>
    <div class="col-sm-11">
        <select onchange="yazdir();" name="map_ilce" id="map_ilce" class="form-control">
            <option value="">Önce Şehir Seçiniz</option>
        </select>
    </div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
    <label class="col-sm-1 control-label">Mahalle</label>
    <div class="col-sm-11">
        <input onchange="yazdir();" type="text" class="form-control" name="map_mahalle" value="">
    </div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
    <label class="col-sm-1 control-label">Cadde</label>
    <div class="col-sm-11">
        <input onchange="yazdir();" type="text" class="form-control" name="map_cadde" value="">
    </div><!-- col end -->
</div><!-- row end -->

<div class="form-group">
    <label class="col-sm-1 control-label">Sokak</label>
    <div class="col-sm-11">
        <input onchange="yazdir();" type="text" class="form-control" name="map_sokak" value="">
    </div><!-- col end -->
</div><!-- row end -->

<input type="text" class="form-control" id="map_adres" name="map_adres" placeholder="Adres yazınız..." style="display: none;">
<input type="text" id="coords" name="google_maps" value="<?=(strlen($dayarlar->google_maps)>=100 || $dayarlar->google_maps== '') ? '41.003917,28.967299' : $dayarlar->google_maps;?>" style="display:none;" />
<div id="map" style="width: 100%; height: 300px"></div>

<?php
$coords = (strlen($dayarlar->google_maps)>=100 || $dayarlar->google_maps== '') ? "41.003917,28.967299" : $dayarlar->google_maps;
list($lat,$lng) = explode(",", $coords);
?>
<input type="hidden" value="<?php echo $lat; ?>" id="g_lat">
<input type="hidden" value="<?php echo $lng; ?>" id="g_lng">
<script type="text/javascript">
  function initMap() {
    var g_lat = parseFloat(document.getElementById("g_lat").value);
    var g_lng = parseFloat(document.getElementById("g_lng").value);
    var map = new google.maps.Map(document.getElementById('map'), {
      dragable:true,
      zoom: 15,
      center: {lat:g_lat,lng:g_lng}
    });
    var geocoder = new google.maps.Geocoder();

    var marker = new google.maps.Marker({
        position:{
          lat:g_lat,
          lng:g_lng
        },
        map:map,
        draggable:true
      });

    jQuery('#map_adres').on('change', function(){
        var val = $(this).val();
        geocodeAddress(marker,geocoder, map,val);
    });

   google.maps.event.addListener(marker,'dragend',function(){
    dragend(marker);
   });
  }

  function geocodeAddress(marker,geocoder, resultsMap,address) {
    if(address){
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            marker.setMap(resultsMap);
            marker.setPosition(results[0].geometry.location);
            dragend(marker);
          } else {
            console.log('Geocode was not successful for the following reason: ' + status+" word: "+address);
          }
        });
    }
  }

  function dragend(marker){
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng();
    $("#coords").val(lat+","+lng);
  }
</script>
</div>
</div>

<div align="right">
  <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab2_form','tab2_status');">Güncelle</button>
</div>
</form>
</div>

<div class="tab-pane" id="tab3">
    <div id="tab3_status"></div>
    <form role="form" class="form-horizontal" id="tab3_form" method="POST" action="ajax.php?p=smtp_ayarlar" onsubmit="return false;" enctype="multipart/form-data">
        <?=$fonk->bilgi("İletişim formunuzun çalışabilmesi için aşağıdaki bilgileri doldurmak zorunludur. Sunucunuza ait bir smtp e-posta hesabı gereklidir. <br><b style='color:red'>Lütfen Yandex veya Gmail gibi ücretsiz servisleri kullanmayınız.</b>"); ?>
        <div class="form-group">
            <label for="smtp_fromname" class="col-sm-3 control-label">Gönderici Bilgisi:</label>
            Siteniz üzerinden gönderilen tüm maillerin gönderici bilgisini buradan düzenleyebilirsiniz.
            <div class="col-sm-9">
                <input type="text" class="form-control" id="smtp_fromname" name="smtp_fromname" placeholder="Example" value="<?=$gayarlar->smtp_fromname;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="smtp_host" class="col-sm-3 control-label">SMTP Server:</label>
            buraya ( mail.domain adı ) nı yazın.
            <div class="col-sm-9">
                <input type="text" class="form-control" id="smtp_host" name="smtp_host" placeholder="Örn: mail.domain.com" value="<?=$gayarlar->smtp_host;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="smtp_port" class="col-sm-3 control-label">SMTP Port:</label>
            Buraya ( 0 - sıfır) yazın
            <div class="col-sm-9">
                <input type="text" class="form-control" id="smtp_port" name="smtp_port" placeholder="Genelde 587'dir." value="<?=$gayarlar->smtp_port;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="smtp_protokol" class="col-sm-3 control-label">SMTP Protokol: </label>
            Burada ( Yok ) u seçin
            <div class="col-sm-9">
                <select name="smtp_protokol" id="smtp_protokol" class="form-control">
                    <option value="" <?=($gayarlar->smtp_protokol == '')  ? 'selected' : ''; ?>>Yok</option>
                    <option value="tls" <?=($gayarlar->smtp_protokol == 'tls')  ? 'selected' : ''; ?>>TLS</option>
                    <option value="ssl" <?=($gayarlar->smtp_protokol == 'ssl')  ? 'selected' : ''; ?>>SSL</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="smtp_username" class="col-sm-3 control-label">E-Posta:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="smtp_username" name="smtp_username" placeholder="Örn: info@example.com" value="<?=$gayarlar->smtp_username;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="smtp_password" class="col-sm-3 control-label">E-Posta Şifre:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="smtp_password" name="smtp_password" value="<?=$gayarlar->smtp_password;?>">
            </div>
        </div>

        <div align="right">
            <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab3_form','tab3_status');">Güncelle</button>
        </div>
    </form>
</div>

<div class="tab-pane" id="tab4">
    <div id="tab4_status"></div>
    <form role="form" class="form-horizontal" id="tab4_form" method="POST" action="ajax.php?p=sms_ayarlar" onsubmit="return false;" enctype="multipart/form-data">
        <?=$fonk->bilgi("Site Bildirimlerini gsm numaranıza sms olarak bildirilmesini istiyorsanız. Aşağıdaki ilgili alanları hizmet sağlayıcınızdan isteyiniz. Detaylı bilgi için hizmet aldığınız firma ile görüşünüz."); ?>
        <div class="form-group">
            <?php $sms_firma = $gayarlar->sms_firma; ?>
            <label for="sms_firma" class="col-sm-3 control-label">Servis Sağlayıcı:</label>
            <div class="col-sm-9">
                <select class="form-control" id="sms_firma" name="sms_firma">
                    <option value="0">Seçiniz</option>
                    <option value="1" <?=($sms_firma == 1) ? 'selected' : '';?>>Varsayılan</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="sms_baslik" class="col-sm-3 control-label">SMS Başlık:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="sms_baslik" name="sms_baslik" placeholder="" value="<?=$gayarlar->sms_baslik;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="sms_username" class="col-sm-3 control-label">Kullanıcı Adı:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="sms_username" name="sms_username" placeholder="" value="<?=$gayarlar->sms_username;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="sms_password" class="col-sm-3 control-label">Şifre:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="sms_password" name="sms_password" value="<?=$gayarlar->sms_password;?>">
            </div>
        </div>
        <div class="form-group">
            <label for="rez_tel" class="col-sm-3 control-label">Yönetici GSM:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="rez_tel" name="rez_tel" value="<?=$gayarlar->rez_tel;?>">
            </div>
        </div>


<div align="right">
    <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab4_form','tab4_status');">Güncelle</button>
</div>
</form>
</div><!-- tab4 end -->

<div class="tab-pane" id="tab5">
    <div id="tab5_status"></div>
    <form role="form" class="form-horizontal" id="tab5_form" method="POST" action="ajax.php?p=foot_baglanti" onsubmit="return false;" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 1</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text1" value="<?=$dayarlar->foot_text1;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa1">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa1 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link1" value="<?=$dayarlar->foot_link1;?>" placeholder="Harici URL">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 2</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text2" value="<?=$dayarlar->foot_text2;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa2">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa2 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link2" value="<?=$dayarlar->foot_link2;?>" placeholder="Harici URL">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 3</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text3" value="<?=$dayarlar->foot_text3;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa3">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa3 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link3" value="<?=$dayarlar->foot_link3;?>" placeholder="Harici URL">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 4</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text4" value="<?=$dayarlar->foot_text4;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa4">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa4 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link4" value="<?=$dayarlar->foot_link4;?>" placeholder="Harici URL">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 5</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text5" value="<?=$dayarlar->foot_text5;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa5">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa5 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link5" value="<?=$dayarlar->foot_link5;?>" placeholder="Harici URL">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Footer Bağlantı 6</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="foot_text6" value="<?=$dayarlar->foot_text6;?>" placeholder="Başlık">
            </div>
            <div class="col-sm-2">
                <select class="form-control" name="foot_sayfa6">
                    <option value="0">Sayfa Seç</option>
                    <?php
                    $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
                    while($row = $sql->fetch(PDO::FETCH_OBJ)){
                    ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa6 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-1">
                <strong>veya</strong>                           
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="foot_link6" value="<?=$dayarlar->foot_link6;?>" placeholder="Harici URL">
            </div>
        </div>                                                                                                                                                             											
		
		
		<div class="form-group">
    <label class="col-sm-3 control-label">Footer Bağlantı 7</label>
    <div class="col-sm-2">
        <input type="text" class="form-control" name="foot_text7" value="<?=$dayarlar->foot_text7;?>" placeholder="Başlık">
    </div>
    <div class="col-sm-2">
        <select class="form-control" name="foot_sayfa7">
            <option value="0">Sayfa Seç</option>
            <?php
            $sql = $db->query("SELECT * FROM sayfalar WHERE site_id_555=501 AND dil='".$dil."' ORDER BY id DESC");
            while($row = $sql->fetch(PDO::FETCH_OBJ)){
            ?><option value="<?=$row->id;?>" <?=($dayarlar->foot_sayfa7 == $row->id) ? 'selected' : ''; ?>><?=$row->baslik;?></option><?
            }
            ?>
        </select>
    </div>
    <div class="col-sm-1">
        <strong>veya</strong>                           
    </div>
    <div class="col-sm-3">
        <input type="text" class="form-control" name="foot_link7" value="<?=$dayarlar->foot_link7;?>" placeholder="Harici URL">
    </div>
</div>

<div align="right">
    <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab5_form','tab5_status');">Güncelle</button>
</div>
</form>
</div><!-- tab5 end -->

<div class="tab-pane" id="tab6">
    <div id="tab6_status"></div>
    <form role="form" class="form-horizontal" id="tab6_form" method="POST" action="ajax.php?p=arkaplan_gorselleri" onsubmit="return false;" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-sm-3 control-label">İlanlar</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim1" value="" > <br />
                <img src="../uploads/<?=$gayarlar->bayiler_resim;?>" width="300" height="auto" id="resim1_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Şubeler</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim2" value="" > <br />
                <img src="../uploads/<?=$gayarlar->subeler_resim;?>" width="300" height="auto" id="resim2_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Sayfalar</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim4" value="" > <br />
                <img src="../uploads/<?=$gayarlar->ekatalog_resim;?>" width="300" height="auto" id="resim4_src">
                <p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Üye Paneli</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim3" value="" > <br />
                <img src="../uploads/<?=$gayarlar->belgeler_resim;?>" width="300" height="auto" id="resim3_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Bireysel Üye</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim5" value="" > <br />
                <img src="../uploads/<?=$gayarlar->foto_galeri_resim;?>" width="300" height="auto" id="resim5_src">
                <p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Kurumsal Üye</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim6" value="" > <br />
                <img src="../uploads/<?=$gayarlar->video_galeri_resim;?>" width="300" height="auto" id="resim6_src">
                <p style="margin-left:10px;font-size:13px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Haberler</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim8" value="" > <br />
                <img src="../uploads/<?=$gayarlar->haber_ve_duyurular_resim;?>" width="300" height="auto" id="resim8_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Duyurular</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim9" value="" > <br />
                <img src="../uploads/<?=$gayarlar->yazilar_resim;?>" width="300" height="auto" id="resim9_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Projeler</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim11" value="" > <br />
                <img src="../uploads/<?=$gayarlar->projeler_resim;?>" width="300" height="auto" id="resim11_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">İletişim</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" name="resim12" value="" > <br />
                <img src="../uploads/<?=$gayarlar->iletisim_resim;?>" width="300" height="auto" id="resim12_src">
                <p style="margin-left:10px;font-size:14px;margin-top:5px;">Yükleyeceğiniz görselin boyutları <?=$gorsel_boyutlari['headerbg']['orjin_x']; ?> x <?=$gorsel_boyutlari['headerbg']['orjin_y']; ?> px olmalıdır.</p>
            </div>
        </div>

        <div align="right">
            <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tab6_form','tab6_status');">Güncelle</button>
        </div>
    </form>
</div><!-- tab6 end -->


<div class="tab-pane" id="tab7"><!-- tab7 start -->

    <div id="tabodeme_status"></div>

    <form role="form" class="form-horizontal" id="tabodeme_form" method="POST" action="ajax.php?p=odeme_ayarlar" onsubmit="return false;" enctype="multipart/form-data">

        <div class="panel-group panel-group-joined" id="accordion-test">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion-test" href="#paytr" class="collapsed" aria-expanded="false">
                            <img src="https://www.paytr.com/img/general/paytr.png"   style="height: 35px;"/>
                        </a>
                    </h4>
                </div>
                <div id="paytr" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="checkbox48" class="col-sm-3 control-label">PayTR SanalPos:</label>
                            <div class="col-sm-9">
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox48" type="checkbox" name="paytr" value="1" <?=($gayarlar->paytr == 1) ? 'checked' : '';?>>
                                    <label for="checkbox48"><strong>Aktif</strong></label><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <p>Anında Ödeme Bildirimi için gerekli adresler;<br>
                                Başarılı Dönüş URL: <strong><?=SITE_URL;?>odeme-tamamlandi</strong><br />
                                Başarısız Dönüş URL: <strong><?=SITE_URL;?>odeme-basarisiz</strong><br />
                                Bildirim(Notify) URL: <strong><?=SITE_URL;?>paytr_notify.php</strong></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paytr_magaza_no" class="col-sm-3 control-label">Mağaza No:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="paytr_magaza_no" name="paytr_magaza_no" value="<?=$gayarlar->paytr_magaza_no;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paytr_magaza_key" class="col-sm-3 control-label">Mağaza Key:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="paytr_magaza_key" name="paytr_magaza_key" value="<?=$gayarlar->paytr_magaza_key;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="paytr_magaza_salt" class="col-sm-3 control-label">Mağaza Salt:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="paytr_magaza_salt" name="paytr_magaza_salt" value="<?=$gayarlar->paytr_magaza_salt;?>">
                            </div>
                        </div>

                        <div align="right">
                            <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tabodeme_form','tabodeme_status');">Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion-test" href="#iyzico" class="collapsed" aria-expanded="false">
                            <img src="https://media.iyzico.com/f/assets/images/content/logo.svg?v=v2.0.11"   style="height: 35px;"/>
                        </a>
                    </h4>
                </div>
                <div id="iyzico" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="iyzico_checkbox48" class="col-sm-3 control-label">Iyzico SanalPos:</label>
                            <div class="col-sm-9">
                                <div class="checkbox checkbox-success">
                                    <input id="iyzico_checkbox48" type="checkbox" name="iyzico" value="1" <?=($gayarlar->iyzico == 1) ? 'checked' : '';?>>
                                    <label for="iyzico_checkbox48"><strong>Aktif</strong></label><br>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="iyzico_key" class="col-sm-3 control-label">Api Key:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="iyzico_key" name="iyzico_key" value="<?=$gayarlar->iyzico_key;?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="iyzico_secret_key" class="col-sm-3 control-label">Secret Key:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="iyzico_secret_key" name="iyzico_secret_key" value="<?=$gayarlar->iyzico_secret_key;?>">
                            </div>
                        </div>

                        <div align="right">
                            <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tabodeme_form','tabodeme_status');">Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion-test" href="#efthavale" class="collapsed" aria-expanded="false">
                            <img src="assets/images/eft-havale.png"   style="height: 35px;"/>
                        </a>
                    </h4>
                </div>
                <div id="efthavale" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-11">
                                <strong>Banka Hesap Bilgilerinizi Giriniz;</strong><br><br>
                                <textarea class="summernote form-control" rows="9" id="hesap_numaralari" name="hesap_numaralari"><?=$dayarlar->hesap_numaralari;?></textarea>
                            </div>
                        </div>

                        <div align="right">
                            <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tabodeme_form','tabodeme_status');">Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="collapsed" aria-expanded="false">
                            <img src="assets/images/pp-logo-100px.png"/>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="checkbox42" class="col-sm-3 control-label">Paypal Ödeme:</label>
                            <div class="col-sm-9">
                                <div class="checkbox checkbox-success">
                                    <input id="checkbox42" type="checkbox" name="paypal" value="1" <?=($gayarlar->paypal == 1) ? 'checked' : '';?>>
                                    <label for="checkbox42"><strong>Aktif</strong></label><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div><!-- tab7 end -->


<div class="form-group">
    <label class="col-sm-3 control-label"></label>
    <div class="col-sm-9">
        <p>Anında Ödeme Bildirimi (IPN) için gerekli adresler;<br>
        Dönüş URL: <strong><?=SITE_URL;?>odeme-tamamlandi</strong><br />
        Bildirim URL: <strong><?=SITE_URL;?>paypal_notify.php?secret=<?=PAY_SECRET;?></strong></p>
    </div>
</div>

<div class="form-group">
    <label for="paypal_odeme_email" class="col-sm-3 control-label">Ödeme Alacak E-Posta:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="paypal_odeme_email" name="paypal_odeme_email" value="<?=$gayarlar->paypal_odeme_email;?>">
    </div>
</div>

<div align="right">
    <button type="submit" class="btn btn-purple waves-effect waves-light" onclick=" AjaxFormS('tabodeme_form','tabodeme_status');">Güncelle</button>
</div>
</div>
</div>
</div>

</div>
</form>
</div><!-- tab7 end -->

</div>
</div>

</div>

</div>

</div>

<script>
    var resizefunc = [];
</script>
<script src="assets/js/admin.min.js"></script>
<link href="assets/plugins/notifications/notification.css" rel="stylesheet">
<link href="assets/plugins/tagsinput/jquery.tagsinput.css" rel="stylesheet">
<link href="assets/plugins/toggles/toggles.css" rel="stylesheet">
<link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
<link href="assets/vendor/summernote/dist/summernote.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/components/nestable.almost-flat.min.css" />
<link rel="stylesheet" href="assets/css/components/nestable.min.css" />
<link rel="stylesheet" href="assets/css/components/nestable.gradient.min.css" />
<style>
    .col-sm-0 {
        float: left;
        margin-top: -15px;
        margin-right: 10px;
    }
    
    input.stm-checkbox {
        width: 0px;
        height: 0px;
        opacity: 0;
    }

    label.stm-checkbox-label {
        width: 38px;
        cursor: pointer;
        height: 23px;
        display: block;
        background-color: #e9e9e9;
        border-radius: 12px;
        border: 1px solid #dadada;
        position: relative;
        z-index: 8;
        transition: background-color 400ms;
    }

    label.stm-checkbox-label::after {
        content: "";
        width: 22px;
        height: 22px;
        display: block;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        background-color: rgb(255, 255, 255);
        border-radius: 19px;
        position: relative;
        z-index: 9;
        left: 0;
        transition: left 400ms;
    }

    input.stm-checkbox:checked + label.stm-checkbox-label {
        background-color: #62a8ea;
        transition: background-color 400ms;
    }

    input.stm-checkbox:checked + label.stm-checkbox-label::after {
        left: 18px;
        transition: left 400ms;
    }

    .colorpicker-2x .colorpicker-saturation {
        width: 200px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-hue,
    .colorpicker-2x .colorpicker-alpha {
        width: 30px;
        height: 200px;
    }

    .colorpicker-2x .colorpicker-color,
    .colorpicker-2x .colorpicker-color div {
        height: 30px;
    }
</style>
<script src="assets/vendor/summernote/dist/summernote.min.js"></script>
<script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
<script src="assets/plugins/notifications/notify-metro.js"></script>
<script src="assets/plugins/notifications/notifications.js"></script>
<script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script src="assets/plugins/toggles/toggles.min.js"></script>
<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/spinner/spinner.min.js"></script>

<script src="assets/js/uikit.min.js"></script>
<script src="assets/js/components/nestable.min.js"></script>

<script>
    jQuery(document).ready(function() {
        // Tags Input
        jQuery('.tags').tagsInput({ width: 'auto' });

        // Form Toggles
        jQuery('.toggle').toggles({ on: true });

        // Time Picker
        jQuery('.timepicker').timepicker({ defaultTIme: false });
        jQuery('.timepicker2').timepicker({ showMeridian: false });
        jQuery('.timepicker3').timepicker({ minuteStep: 15 });

        // Date Picker
        jQuery('.datepicker').datepicker();
        jQuery('.datepicker-inline').datepicker();
        jQuery('.datepicker-multiple').datepicker({
            numberOfMonths: 3,
            showButtonPanel: true
        });

        //colorpicker start
        $('.cp2').colorpicker({
            customClass: 'colorpicker-2x',
            sliders: {
                saturation: {
                    maxLeft: 200,
                    maxTop: 200
                },
                hue: {
                    maxTop: 200
                },
                alpha: {
                    maxTop: 200
                }
            }
        });

        //spinner start
        $('#spinner1').spinner();
        $('#spinner2').spinner({ disabled: true });
        $('#spinner3').spinner({ value: 0, min: 0, max: 10 });
        $('#spinner4').spinner({ value: 0, step: 5, min: 0, max: 200 });
        //spinner end
    });

    $('.uk-nestable').on('change.uk.nestable', function(e) {
        var data = $("#list").data("nestable").serialize();
        $.post("ajax.php?p=blok_guncelle", { value: data }, function(a) {
            $("#tab1_status").html(a);
        });
    });

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
        });
    });

    function yazdir() {
        var il = $("select[name='map_il']").val();
        var ilce = $("select[name='map_ilce']").val();
        var maha = $("input[name='map_mahalle']").val();
        var cadde = $("input[name='map_cadde']").val();
        var sokak = $("input[name='map_sokak']").val();
        var neler = "";

        if (il != undefined) {
            neler += il;
            if (ilce != undefined) {
                neler += ", " + ilce;
                if (maha != undefined) {
                    neler += ", " + maha;
                }
                if (cadde != undefined) {
                    neler += ", " + cadde;
                }
                if (sokak != undefined) {
                    neler += ", " + sokak;
                }
            }
        }

        $("input[name='map_adres']").val(neler);
        GetMap();
    }

    function GetMap() {
        $("#map_adres").trigger("change");
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gayarlar->google_api_key; ?>&callback=initMap"></script>
		
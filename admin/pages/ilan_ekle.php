<?php
declare(strict_types=1); // Sıkı tip kontrolü

// Rastgele ilan numarası oluşturma
$ilan_no = random_int(10000000, 99999999); 

// Güvenlik için girişleri temizleme
$acid = isset($_GET['acid']) ? htmlspecialchars($gvn->rakam($_GET['acid'])) : null;
$id = isset($_GET['id']) ? htmlspecialchars($gvn->rakam($_GET['id'])) : null;

if ($id !== null) {
    try {
        $snc = $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=999 AND id=:ids");
        $snc->execute(['ids' => $id]);
        if ($snc->rowCount() > 0) {
            $snc = $snc->fetch(PDO::FETCH_OBJ);
        } else {
            header("Location:index.php?p=ilan_ekle");
            exit;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Hatayı log dosyasına yaz
        echo "<div class='error'>Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</div>"; // Hatayı ekrana yazdır
    }
}

if ($acid !== null) {
    try {
        $kontrol = $db->prepare("SELECT id, adi, soyadi, concat_ws(' ', adi, soyadi) FROM hesaplar WHERE site_id_555=999 AND id=?");
        $kontrol->execute([$acid]);
        if ($kontrol->rowCount() > 0) {
            $acc = $kontrol->fetch(PDO::FETCH_OBJ);
        }
    } catch (PDOException $e) {
        error_log($e->getMessage()); // Hatayı log dosyasına yaz
        echo "<div class='error'>Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</div>"; // Hatayı ekrana yazdır
    }
}
?>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="pull-left page-title">Yeni İlan Ekle</h4>
            </div>
        </div>
		
		
		
		
<div class="panel-group" id="accordion-test-2">
    <div class="panel panel-pink panel-color">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="true" class="collapsed">
                    İLAN PAYLAŞIMI ve PORTALLARDA İLAN YAYINLAMA AÇIKLAMASI
                </a>
            </h4>
        </div>
        <div id="collapseOne-2" class="panel-collapse collapse" aria-expanded="true">
            <div class="panel-body">
                <font color="red"><strong> SÖZLEŞMELİ İLAN PAYLAŞIMI </strong></font><br/>
                <font color="black">Elinizdeki Sözleşmeli İlanlarınızı<font color="red"> Üyelerimiz</font> <font color="black">ile Paylaşabilir, Onların Paylaştığı Sözleşmeli İlanları, Kendi İlanlarınızda Kullanabilirsiniz. 
                İlanın içinde Sizi Çağrıştıracak, Firma İsmi, Telefon, Logo vs Olmamasına Lütfen Dikkat Ediniz.
                <br/>İlan Açıklamanızın en altına</font> <font color="red"><strong> Bu İlan, Yetkilisi Tarafından Paylaşıma Açılmıştır</strong> </font>Yazınız.</font><br/><br/>
                <font color="red"><strong>KAPALI PORTFÖY İLAN PAYLAŞIMI </strong></font><br/>
                <font color="black">Bildiğiniz gibi 1 Ocak 2024 tarihinden itibaren Sözleşme Yapılmayan İlanlar, Emlak Portallarında Yayınlanamayacaktır</font><br/>
                Bu nedenle Sözleşme yapamadığınız, Sözlü olarak onay aldığınız veya Sitelerde Yayınlamak İstemediğiniz</font><br/><br/>
                <font color="red"><strong> Kapalı Portföy İlanlarınızı Sitenize Girerek Saklayabilir, Linkini Müşterinizle Paylaşabilirsiniz.</strong></font><br/>
                <font color="black"> İsterseniz, Birlikte Çalıştığınız Emlakcılar ve Emlak Danışmanları ile Grup Oluşturarak, Aranızda Paylaşabilirsiniz.</font><br/>
                <font color="red"><strong> ÖNEMLİ : </strong></font> <font color="black"> Sitenize girdiğiniz veya Paylaştığınız KAPALI PORTFÖY İlanlarınız, Hiçbir Sitede Yayınlanmaz. Sitelerinize girerek Kapalı Portföy İlanlarınızı Saklayabilirsiniz.</font><br/><br/>
                <font color="red"><strong> İLANLARINIZIN PORTALLARIMIZDA YAYINLANMASI</strong></font><br/>
                <font color="black"> İlanlarınızı, Sitenize Girerken İşaretleyerek </font><font color="red"><strong> www.izmiremlaksitesi.com.tr – www.istanbulemlaksitesi.com.tr – www.ankaraemlaksitesi.com.tr </strong></font><font color="black"> adreslerinde Yayınlanmasını Sağlayabilirsiniz.</font><br/>
            </div>
        </div>
    </div>
</div>





<?php
$asama = isset($_GET['asama']) ? htmlspecialchars($gvn->rakam($_GET['asama'])) : null;

if ($id !== null) {
    if ($asama == 0 || $asama == '') { // aşama 0 foto galeri ayarı...
        $gurl = "ajax.php?p=ilan_duzenle&id=" . $id . "&galeri=1";
        $yfotolar = $db->query(" 
		
		
		
		
<?php
$asama = isset($_GET['asama']) ? htmlspecialchars($gvn->rakam($_GET['asama'])) : null;

if ($id !== null) {
    if ($asama == 0 || $asama == '') { // aşama 0 foto galeri ayarı...
        $gurl = "ajax.php?p=ilan_duzenle&id=" . $id . "&galeri=1";
        $yfotolar = $db->query("SELECT * FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=" . $snc->id . " ORDER BY sira ASC");
        $yfotolarcnt = $yfotolar->rowCount();
        ?>
        <div id="galeri_foto_ekle">
            <script type="text/javascript">
                function YuklemeBitti() {
                    window.location.href = "index.php?p=ilan_ekle&id=<?= $id; ?>";
                }
            </script>
            <h4 style="font-weight:bold;font-size:18px;">İlana ait Fotoğraflar Yükleyin;</h4>
            <div class="alert alert-info" role="alert">
                <strong style="color:red;">İlan Fotoğraflarının Uzantısı .jpeg Olmalıdır.</strong><br>
                <strong style="color:red;">İlan fotoğraflarını yüklerken dikkatlice seçiniz.</strong>
            </div>
            <div class="m-b-30">
                <form action="#" class="dropzone" id="dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple="multiple">
                    </div>
                </form>
            </div>
            <h4 style="font-weight:bold;font-size:18px;">Kapak Fotoğrafı Seçin;</h4>
            <div class="alert alert-info" role="alert">İlanınız için, yüklediğiniz fotoğraflardan bir kapak görseli seçmeyi unutmayın. Fotoğrafların Yerlerini kaydırarak sıralayabilirsiniz.</div>
            <div id="silsnc"></div>
            <form role="form" class="form-horizontal" action="ajax.php?p=galeri_guncelle&ilan_id=<?= $snc->id; ?>&from=insert" method="POST" id="GaleriGuncelleForm">
                <div class="row port">
                    <div class="portfolioContainer">
                        <ul id="list" class="uk-nestable" data-uk-nestable="{maxDepth:1}">
                            <?php
                            $linkcek = "https://www.turkiyeemlaksitesi.com.tr";
                            $i = 0;
                            while ($row = $yfotolar->fetch(PDO::FETCH_OBJ)) {
                                $i += 1;
                                ?>
                                <li class="uk-nestable-item" data-id="<?= $i; ?>" data-idi="<?= $row->id; ?>" id="foto_<?= $row->id; ?>">
                                    <div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator" id="foto_<?= $row->id; ?>">
                                        <div class="gal-detail thumb">
                                            <div class="ilanfototasi"><i class="fa fa-arrows-alt" aria-hidden="true"></i></div>
                                            <a href="<?= $linkcek; ?>/uploads/<?= $row->resim; ?>" class="image-popup"><img src="<?= $linkcek; ?>/uploads/thumb/<?= $row->resim; ?>" width="150" height="150" class="thumb-img" alt="work-thumbnail">
                                            </a>
                                            <div class="clearfix"></div>
                                            <div class="radio radio-success radio-single">
                                                <input type="radio" id="<?= $row->id; ?>" name="kapak" value="<?= $row->resim; ?>" <?= ($snc->resim == $row->resim) ? 'checked' : ''; ?>><label for="<?= $row->id; ?>">Kapak Görseli Seç</label>
                                            </div>
                                            <a style="margin-top: -60px; float: right;" href="javascript:;" onclick="ajaxHere('ajax.php?p=galeri_foto_sil&id=<?= $row->id; ?>','silsnc');"><button type="button" class="btn btn-icon waves-effect waves-light btn-danger"><i class="fa fa-remove"></i></button></a>
                                            <a style="margin-top: -60px; margin-right:40px; float: right;" href='javascript:window.open ("<?= SITE_URL . "rotate/" . $row->id; ?>", "mywindow","status=1,toolbar=0,resizable=1,width="+window.innerWidth+",height="+window.innerHeight);'><button type="button" class="btn btn-icon waves-effect waves-light btn-success"><i class="fa fa-repeat"></i></button></a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div align="right">
                    <button type="button" class="btn btn-success waves-effect waves-light" onclick=" AjaxFormS('GaleriGuncelleForm','silsnc');">Devam Et <i class="fa fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
        <?php
    } // aşama 0 foto galeri ayarı...
}




<?php
if ($asama == 1) { // video sistemi start...
    ?>
    <div id="galeri_video_ekle">
        <h4 style="font-weight:bold;margin-bottom:20px;color:#be2527;font-size:18px;"><?=dil("TX444");?></h4>
        <div class="alert alert-info" role="alert"><?=dil("TX457");?></div>
        <div style="height:200px;float:left;width:100%;">
            <form action="ajax.php?p=galeri_video_guncelle&ilan_id=<?= $snc->id; ?>&from=insert<?= ($snc->video != '') ? '&video=1' : '&video=0'; ?>" method="POST" id="VideoForm" enctype="multipart/form-data">
                <center><input type="file" name="video" id="VideoSec" /></center>
                <div class="clear"></div>
            </form>
            <div class="yuklebar" id="YuklemeBar" style="display:none">
                <span id="percent">0%</span>
                <div class="yuklebarasama animated flash" id="YuklemeDurum"></div>
            </div>
            <div class="clear"></div>
        </div>
        <hr style="border: 1px solid #eee;">
        <br>
        <div align="right">
            <a style="margin-left: 15px;" class="btn btn-info" href="javascript:YuklemeBaslat();"><?=dil("TX442");?> <i class="fa fa-cloud-upload" aria-hidden="true"></i></a>  
            <a class="btn btn-success" href="javascript:atla();"><?=dil("TX443");?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="clear"></div>
        <div align="right"><br>
            <div id="VideoForm_output" style="display:none"></div>
        </div>
    </div>
    <?php
} // video sistemi end

if ($asama == 2 && $gayarlar->dopingler_19541956 == 1) {
    list($dzaman1a, $dzaman1b) = explode("|", $gayarlar->dzaman1);
    list($dzaman2a, $dzaman2b) = explode("|", $gayarlar->dzaman2);
    list($dzaman3a, $dzaman3b) = explode("|", $gayarlar->dzaman3);
    $dzaman1b = $periyod[$dzaman1b];
    $dzaman2b = $periyod[$dzaman2b];
    $dzaman3b = $periyod[$dzaman3b];
    $from = "insert";
    ?>
    <div id="doping_ekle">
        <div class="clear"></div>
        <form action="ajax.php?p=ilan_dopingle&id=<?= $id; ?>&from=<?= $from; ?>" method="POST" id="DopingleForm">
            <h4 style="font-weight:bold;margin-bottom:20px;color:#be2527;font-size:18px;"><?=dil("TX517");?></h4>
            <div class="alert alert-info" role="alert"><?=dil("TX518");?></div>
            <br>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#eee"><h5><strong><?=dil("TX519");?></strong></h5></td>
                    <td align="center" bgcolor="#eee"><strong><?= $dzaman1a . " " . $dzaman1b; ?></strong></td>
                    <td align="center" bgcolor="#eee"><strong><?= $dzaman2a . " " . $dzaman2b; ?></strong></td>
                    <td align="center" bgcolor="#eee"><strong><?= $dzaman3a . " " . $dzaman3b; ?></strong></td>
                    <td align="center" bgcolor="#eee"><strong>Sınırsız</strong></td>
                </tr>
                <?php
                $bugun = date("Y-m-d");
                $sec = 0;
                $dopingler_19541956 = $db->query("SELECT * FROM doping_ayarlar_19541956 ORDER BY id ASC");
                while ($row = $dopingler_19541956->fetch(PDO::FETCH_OBJ)) {
                    $isdoping = $db->prepare("SELECT * FROM dopingler_19541956 WHERE ilan_id=? AND did=? AND btarih > NOW()");
                    $isdoping->execute([$snc->id, $row->id]);
                    ?>
                    <tr>
                        <td><?=dil("DOPING" . $row->id);?></td>
                        <?php if ($isdoping->rowCount() > 0) {
                            $isdoping = $isdoping->fetch(PDO::FETCH_OBJ);
                            ?>
                            <td align="center" colspan="4">
                                <?php if ($isdoping->durum == 0) { ?>
                                    <h5 style="color:orange;"><i class="fa fa-check"></i> <?=dil("TX533");?></h5>
                                <?php } elseif ($isdoping->durum == 1) {
                                    $kgun = $fonk->gun_farki($isdoping->btarih, $bugun);
                                    ?>
                                    <?php if ($isdoping->sure == 100 && $isdoping->periyod == "yillik") { ?>
                                        <strong style="color:green">Süresiz</strong>
                                    <?php } elseif ($kgun < 0) { ?>
                                        <strong style="color:red"><i class="fa fa-clock-o"></i> <?=dil("TX562");?></strong>
                                    <?php } else { ?>
                                        <strong><i class="fa fa-clock-o"></i> <?=($kgun == 0) ? dil("TX563") : $kgun . " " . dil("TX564");?></strong>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        <?php } else {
                            $sec += 1;
                            ?>
                            <td align="center">
                                <label><input name="doping[<?= $row->id; ?>]" class="checkbox_one" type="checkbox" value="1"> Seç</label></td>
                            <td align="center"><label><input name="doping[<?= $row->id; ?>]" class="checkbox_one" type="checkbox" value="2"> Seç</td>
                            <td align="center"><label><input name="doping[<?= $row->id; ?>]" class="checkbox_one" type="checkbox" value="3"> Seç</td>
                            <td align="center"><label><input name="doping[<?= $row->id; ?>]" class="checkbox_one" type="checkbox" value="4"> Seç</td>
                        <?php } ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <div class="clear"></div>
            <?php if ($sec > 0) { ?>
                <hr style="border: 1px solid #eee;">
                <br>
                <div align="right">
                    <a style="margin-left: 15px;" class="btn btn-success" href="javascript:void(0);" onclick="AjaxFormS('DopingleForm','DopingleForm_output');" id="DopingleButon"><i class="fa fa-check" aria-hidden="true"></i> <?=dil("TX443");?></a>
                    <a class="btn btn-danger" href="javascript:atla();"><?=dil("TX443");?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
                <div id="DopingleForm_output" style="display:none" align="left"></div>
            <?php } else { ?>
                <hr style="border: 1px solid #eee;">
                <br>
                <div align="right">
                    <a class="btn btn-danger" href="javascript:atla();"><?=dil("TX443");?> <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            <?php } ?>
        </form>
    </div>
    <?php
} // aşama 2 end
?>




// Form işleme bölümü
if ($id == '' && $asama == '') {
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".ilanasamax:eq(0)").attr("id","asamaaktif");
        });
    </script>
    <?php
}

// Harita ve konum belirleme fonksiyonları
?>
<script type="text/javascript">
    function yazdir(){
        var ulke = $("#ulke_id").val();
        ulke = $("#ulke_id option[value='"+ulke+"']").text();
        var il = $("#il").val();
        il = $("#il option[value='"+il+"']").text();
        var ilce = $("#ilce").val();
        ilce = $("#ilce option[value='"+ilce+"']").text();
        var maha = $("#semt").val();
        maha = $("#semt option[value='"+maha+"']").text();
        var cadde = $("input[name='map_cadde']").val();
        var sokak = $("input[name='map_sokak']").val();
        var neler = "";

        if(il != undefined && il != '' && il != '<?=dil("TX264");?>'){
            if(ulke != undefined && ulke!='' && ulke != '<?=dil("TX264");?>'){
                neler += ", "+ulke;
            }
            neler += il;
            $("#map_il").val(il);
            if(ilce != undefined && ilce != '' && ilce != '<?=dil("TX264");?>'){
                neler += ", "+ilce;
                $("#map_ilce").val(ilce);
                if(maha != undefined && maha != '' && maha != '<?=dil("TX264");?>'){
                    neler += ", "+maha;
                    $("#map_mahalle").val(maha);
                } else {
                    $("#map_mahalle").val('');
                }

                if(cadde != undefined && cadde != '' && cadde != '<?=dil("TX264");?>'){
                    neler += ", "+cadde;
                }

                if(sokak != undefined && sokak != '' && sokak != '<?=dil("TX264");?>'){
                    neler += ", "+sokak;
                }
            } else {
                $("#map_ilce").val('');
            }
        } else {
            $("#map_il").val('');
        }
        $("input[name='map_adres']").val(neler);
        GetMap();
    }

    function GetMap(){
        $("#map_adres").trigger("change");
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gayarlar->google_api_key; ?>&callback=initMap"></script>

</div><!-- container -->
</div><!-- content -->
<?php


		

		
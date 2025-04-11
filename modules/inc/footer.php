<div class="clear"></div>
<div class="footinfo">
    <h1><?=str_replace("[telefon]",$dayarlar->telefon,dil("FOOTER_TEXT"));?></strong></h1>
</div>

<div class="footseolinks">
    <div id="wrapper">
        <?php
        $sql = $db->query("SELECT * FROM referanslar_501 WHERE dil='".$dil."' ORDER BY sira ASC");
        while($row = $sql->fetch(PDO::FETCH_OBJ)){
        ?>
        <a href="<?=$row->website;?>"><?=$row->adi;?></a>
        <? } ?>
    </div>
</div>

<div class="footer">
    <div id="wrapper">
        <div class="footblok">
            <img title="logo" alt="logo" src="uploads/thumb/<?=$gayarlar->footer_logo;?>" width="auto" height="80">
            <? if($dayarlar->slogan3 != ''){?><p><?=$dayarlar->slogan3;?></p><? } ?>
            <? if($dayarlar->telefon != ''){?><h4><span><?=dil("TX76");?> </span><strong><a style="color:white;" href="tel:<?=$dayarlar->telefon;?>"><?=$dayarlar->telefon;?></a></strong></h4><? } ?>
            <? if($dayarlar->faks != ''){?><h4><span><?=dil("TX77");?> </span><strong><?=$dayarlar->faks;?></strong></h4><? } ?>
            <? if($dayarlar->email != ''){?><h4><span><?=dil("TX78");?> </span><strong><?=$dayarlar->email;?></strong></h4><? } ?>
            <? if($dayarlar->adres != ''){?><h5><span><?=dil("TX79");?> </span><?=$dayarlar->adres;?></h5><? } ?>
        </div>

        <?php
        if($dayarlar->foot_sayfa1 != 0){$sayfa1 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa1)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa2 != 0){$sayfa2 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa2)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa3 != 0){$sayfa3 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa3)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa4 != 0){$sayfa4 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa4)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa5 != 0){$sayfa5 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa5)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa6 != 0){$sayfa6 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa6)->fetch(PDO::FETCH_OBJ);}
        if($dayarlar->foot_sayfa7 != 0){$sayfa7 = $db->query("SELECT id, url FROM sayfalar WHERE site_id_555=501 AND id=".$dayarlar->foot_sayfa7)->fetch(PDO::FETCH_OBJ);}

        $sayfa1_url = ($dayarlar->permalink == 'Evet') ? $sayfa1->url.'.html' : 'index.php?p=sayfa&id='.$sayfa1->id;
        $sayfa2_url = ($dayarlar->permalink == 'Evet') ? $sayfa2->url.'.html' : 'index.php?p=sayfa&id='.$sayfa2->id;
        $sayfa3_url = ($dayarlar->permalink == 'Evet') ? $sayfa3->url.'.html' : 'index.php?p=sayfa&id='.$sayfa3->id;
        $sayfa4_url = ($dayarlar->permalink == 'Evet') ? $sayfa4->url.'.html' : 'index.php?p=sayfa&id='.$sayfa4->id;
        $sayfa5_url = ($dayarlar->permalink == 'Evet') ? $sayfa5->url.'.html' : 'index.php?p=sayfa&id='.$sayfa5->id;
        $sayfa6_url = ($dayarlar->permalink == 'Evet') ? $sayfa6->url.'.html' : 'index.php?p=sayfa&id='.$sayfa6->id;
        $sayfa7_url = ($dayarlar->permalink == 'Evet') ? $sayfa7->url.'.html' : 'index.php?p=sayfa&id='.$sayfa7->id;
        ?>
        <div class="footblok" id="footlinks">
            <h3><?=dil("TX80");?></h3>
            <a href="<?=($dayarlar->foot_sayfa1 == 0) ? $dayarlar->foot_link1 : $sayfa1_url; ?>"><?=$dayarlar->foot_text1; ?></a>
            <a href="<?=($dayarlar->foot_sayfa2 == 0) ? $dayarlar->foot_link2 : $sayfa2_url; ?>"><?=$dayarlar->foot_text2; ?></a>
            <a href="<?=($dayarlar->foot_sayfa3 == 0) ? $dayarlar->foot_link3 : $sayfa3_url; ?>"><?=$dayarlar->foot_text3; ?></a>
            <a href="<?=($dayarlar->foot_sayfa4 == 0) ? $dayarlar->foot_link4 : $sayfa4_url; ?>"><?=$dayarlar->foot_text4; ?></a>
            <a href="<?=($dayarlar->foot_sayfa5 == 0) ? $dayarlar->foot_link5 : $sayfa5_url; ?>"><?=$dayarlar->foot_text5; ?></a>
            <a href="<?=($dayarlar->foot_sayfa6 == 0) ? $dayarlar->foot_link6 : $sayfa6_url; ?>"><?=$dayarlar->foot_text6; ?></a>
            <a href="<?=($dayarlar->foot_sayfa7 == 0) ? $dayarlar->foot_link7 : $sayfa7_url; ?>"><?=$dayarlar->foot_text7; ?></a>
        </div>

        <div class="footblok" id="footebulten">
            <h3><?=dil("TX81");?></h3>
            <form action="ajax.php?p=bulten" method="POST" id="bulten_form">
                <p><?=dil("TX82");?></p>
                <input name="gsm" type="text" placeholder="<?=dil("TX83");?>" id="gsm" data-mask="(0500) 000 00 00">
                <input name="email" type="text" placeholder="<?=dil("TX84");?>">
                <div class="clear"></div>
                <a class="btn" href="javascript:AjaxFormS('bulten_form','bsonuc');" style="margin-bottom:5px;"><?=dil("TX85");?></a>
                <div id="bsonuc"></div>
            </form>

            <div id="BultenTamam" style="display:none">
                <!-- TAMAM MESAJ -->
                <div style="margin-top:30px;margin-bottom:70px;text-align:center;" id="BasvrTamam">
                    <i style="font-size:80px;color:white;" class="fa fa-check"></i>
                    <h2 style="color:white;font-weight:bold;"><?=dil("TX86");?></h2>
                    <br>
                    <h4><?=dil("TX87");?></h4>
                </div>
                <!-- TAMAM MESAJ -->
            </div>
        </div>
    </div>
</div>

<div class="altfooter">
    <div id="wrapper">
        <h5><?=dil("TX88");?></h5>

        <? if($dayarlar->facebook != '' OR $dayarlar->instagram != '' OR $dayarlar->twitter != ''){ ?>
        <div class="headsosyal">
            <? if($dayarlar->facebook != ''){ ?><a target="_blank" href="<?=$dayarlar->facebook;?>"><i class="fa fa-facebook" aria-hidden="true"></i></a><? } ?>
            <? if($dayarlar->twitter != ''){ ?><a target="_blank" href="<?=$dayarlar->twitter;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a><? } ?>
            <? if($dayarlar->instagram != ''){ ?><a target="_blank" href="<?=$dayarlar->instagram;?>"><i class="fa fa-instagram" aria-hidden="true"></i></a><? } ?>
        </div>
        <? } ?>
    </div>
</div>

<div class="clear"></div>

<a href="#0" class="cd-top"></a>

<?php if($p == "uye_paneli" && ($_GET["rd"] == "aktif_ilanlar" || $_GET["rd"] == "pasif_ilanlar" || $_GET["rd"] == "favori_ilanlar")){ ?>

<link rel="stylesheet" href="<?=THEME_DIR;?>css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="<?=THEME_DIR;?>css/dataTables.responsive.min.css" />
<!--script src="<?=THEME_DIR;?>js/jquery-1.11.3.min.js"></script-->
<script src="<?=THEME_DIR;?>js/jquery.dataTables.min.js" type="text/javascript"></script>  
<script src="<?=THEME_DIR;?>js/dataTables.responsive.min.js" type="text/javascript"></script> 
<script>
    $(document).ready(function() {  
        $('#datatable').DataTable({
            responsive: true,
            "language":{
                "url":"<?=THEME_DIR;?>js/dtablelang.json"
            }
        });
    }); 
</script>
<style>
    #datatable {font-size:13px;}
    .dataTables_length {width:160px;margin-bottom:10px;font-size:13px;}
    .dttblegoster {float:left;margin-right:10px;}
    .datatbspan {line-height: 35px;}
    .dataTables_paginate, .dataTables_info {font-size:13px;}
</style>

<?php }else{ ?>
<!-- Js -->
<!--script src="<?=THEME_DIR;?>js/jquery-2.2.4.min.js"></script-->
<script src="<?=THEME_DIR;?>js/jquery.cookie.js" defer></script>
<script src="<?=THEME_DIR;?>rs-plugin/js/jquery.plugins.min.js" defer></script>
<script src="<?=THEME_DIR;?>rs-plugin/js/jquery.slider.min.js" defer></script>
<script src="<?=THEME_DIR;?>js/viewportchecker.js" defer></script>
<script src="<?=THEME_DIR;?>js/waypoints.min.js" defer></script> 
<script src="<?=THEME_DIR;?>js/jquery.counterup.min.js" defer></script> 
<script src="<?=THEME_DIR;?>js/modernizr.js" defer></script> 
<script src="<?=THEME_DIR;?>js/zjquery.mask.js" defer></script>
<script src="<?=THEME_DIR;?>js/zinputmask.js" defer></script>
<script src="<?=THEME_DIR;?>js/jquery.prettyPhoto.js" type="text/javascript" defer></script>
<script src="<?=THEME_DIR;?>js/setting.js" defer></script> 
<script src="<?=THEME_DIR;?>js/jquery.carouFredSel-6.2.1-packed.js" defer></script>
<script>
    $(function() {
        $('#foo2').carouFredSel({
            auto: true,
            prev: '#prev2',
            next: '#next2',
            pagination: "#pager2",
            mousewheel: true,
            scroll : {
                fx : "scroll",
                items: 1,
                easing : "quadratic",
                pauseOnHover : true,
                duration : 1000
            }
        });
        
        $('#foo3').carouFredSel({
            auto: true,
            pagination: "#pager3",
            prev: '#prev3',
            next: '#next3',
            mousewheel: true,
            scroll : {
                fx : "scroll",
                items: 1,
                easing : "quadratic",
                pauseOnHover : true,
                duration : 1000
            }
        });
        
        $('#foo4').carouFredSel({
            auto: true,
            pagination: "#pager4",
            prev: '#prev4',
            next: '#next4',
            mousewheel: false,
            scroll : {
                fx : "scroll",
                items: 1,
                easing : "quadratic",
                pauseOnHover : true,
                duration : 1000
            }
        });
        
        $('#foo5').carouFredSel({
            auto: true,
            pagination: "#pager5",
            prev: '#prev5',
            next: '#next5',
            mousewheel: true,
            scroll : {
                fx : "scroll",
                items: 1,
                easing : "quadratic",
                pauseOnHover : true,
                duration : 1000
            }
        });
    });
</script>
<!-- Js -->
<?php } ?>

<!-- Ekstra -->

<? $fonk->ekstra(false,false,true); ?>

<? if($p == 'uye_paneli' AND $rd == "danismanlar"){ ?>
<script src="<?=THEME_DIR;?>/remodal/dist/remodal.min.js"></script>
<script type="text/javascript">
var inst = $('[data-remodal-id=DanismanSil]').remodal();

function SilDanisman(id){
    $("#delete_id").val(id);
    inst.open();
}

function DanismanSil(ilan_sil){
    var DanismanID = $("#delete_id").val();
    if(DanismanID != 0){
        inst.close();
        ajaxHere('ajax.php?p=danisman_sil&id=' + DanismanID + '&ilan_sil=' + ilan_sil, 'hidden_result');
    }
}
</script>
<? } ?>

<? if(($p == 'sayfa' AND $sayfay->tipi == 4) || ($p == 'sayfa' AND $sayfay->tipi == 5)){ ?>
<script src="<?=THEME_DIR;?>lightslider/js/lightslider.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/picturefill.min.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lightgallery.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-fullscreen.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-thumbnail.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-video.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-autoplay.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-zoom.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-hash.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/lg-pager.js"></script>
<script src="<?=THEME_DIR;?>lightgallery/js/jquery.mousewheel.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var neDir = "#image-slider";
    var neDir2 = "#image-gallery";
    $(neDir).lightSlider({
        gallery: true,
        item: 1,
        thumbItem: 6,
        slideMargin: 0,
        speed: 900,
        auto: true,
        loop: true,
        enableTouch: true,
        onSliderLoad: function() {
            $(neDir).removeClass('cS-hidden');
        }
    });
    $(neDir2).lightGallery({
        hash: false,
        actualSize: false,
        exThumbImage: 'data-exthumbimage',
        enableDrag: true,
        enableTouch: true,
    });
});
</script>

<? if($sayfay->tipi == 4){ ?>
<script>
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();
</script>
<? } ?>
<? } elseif($p == 'uye_paneli' && $rd == 'mesajlar' && $gayarlar->anlik_sohbet == 1){ ?>
<script type="text/javascript">
var KisiListesi = $("#ContactList");
var MesjListesi = $("#MessagesList");
var KaydirSure = 1;

$(document).ready(function(){
    ArayuzYukle();

    $("#AramaKutusu").keyup(function(ne){
        ArayuzYukle();
    });
});

setInterval("ArayuzYukle()", 1500);

function objCount(obj) {
    var prop;
    var propCount = 0;
    for (prop in obj) {
        propCount++;
    }
    return propCount;
}

function ArayuzYukle(){
    var uid = $("#uid").val();
    var ak = $("#AramaKutusu").val();

    $.get("ajax.php?p=mesajlar_kisiler", {'uid': uid, 'arama': ak}, function(data){
        var kisiler = data.kisiler;

        if(kisiler == undefined){ // eğer kişiler gelmemişse listeyi silelim.
            KisiListesi.html('');
        } // eğer kişiler gelmemişse listeyi silelim.

        if(ak != '' && kisiler != undefined){ // Eğer arama yapılıyorsa kişiler varsa
            // Mevcut Kişileri Listeliyoruz. Kontrol ediyoruz
            var mevcut_kisiler = $("#ContactList a");
            if(mevcut_kisiler.length > 0){
                mevcut_kisiler.each(function(index) {
                    var indis = $(this).attr("id");
                    var kisi = kisiler[indis];
                    if(kisi == undefined){ // Eğer kişi yoksa
                        $(this).remove(); // Mevcut kişiyi kaldırıyoruz...
                    }else{ // Eğer kişi varsa
                        var icerik = kisi.icerik;
                        var len1 = $(this).prop('outerHTML').length;
                        var len2 = icerik.length;
                        if(len1 != len2){$(this).prop('outerHTML', icerik);}
                    } // Eğer kişi varsa...
                });
            } // Mevcut kişiler varsa

            // Kişileri Listeliyoruz...
            $.each(kisiler, function(i, item) {
                var isDiv = $("#"+i).has(".mesajkisi").length ? true : false;
                if(!isDiv){
                    KisiListesi.append(item.icerik);
                }
            });
        } // Eğer arama yapılıyorsa kişiler varsa

        var bildirim = data.bildirim;
        if(bildirim != undefined){ // Eğer bildirim değeri geliyor ise...
            var cebildirim = $.cookie("bildirim");
            if(cebildirim == undefined){ // Eğer cerez yoksa...
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    bildirim_play();
                    $.cookie("bildirim", bildirim, { expires: 7 });
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                } // eğer bildirim 0 büyükse
            }else{ // Eğer cerez varsa
                if(bildirim == 0){ // eğer bildirim yoksa çerezi silelim...
                    $.removeCookie("bildirim");
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer bildirim varsa fark var mı kontrol edelim...
                    if(cebildirim != bildirim){ // Eğer çerez eşit değilse gelen bildirime
                        bildirim_play();
                        $.cookie("bildirim", bildirim, { expires: 7 });
                        $(".mbildirim").fadeIn(300);
                        $(".mbildirim").html(bildirim);
                    } // Eğer çerez eşit değilse gelen bildirime
                } // Eğer bildirim varsa fark var mı kontrol edelim...
            } // Eğer cerez varsa

            var mbildirim = $(".mbildirim").val();
            if(mbildirim != bildirim){ // eğer mbildirim eşit değilse
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer 0 büyük değilse
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                } // Eğer 0 büyük değilse
            } // eğer mbildirim eşit değilse
        } // Eğer bildirim değeri geliyor ise...

        if(ak == '' && kisiler != undefined){ // Eğer arama yapılmıyorsa ve kişiler varsa
            // Mevcut Kişileri Listeliyoruz. Kontrol ediyoruz
            var mevcut_kisiler = $("#ContactList a");
            if(mevcut_kisiler.length > 0){
                mevcut_kisiler.each(function(index) {
                    var indis = $(this).attr("id");
                    var kisi = kisiler[indis];
                    if(kisi == undefined){ // Eğer kişi yoksa
                        $(this).remove(); // Mevcut kişiyi kaldırıyoruz...
                    }else{ // Eğer kişi varsa
                        var icerik = kisi.icerik;
                        var len1 = $(this).prop('outerHTML').length;
                        var len2 = icerik.length;
                        var yindex = kisi.sira;

                        if(index != yindex){$(this).remove();}
                        if(len1 != len2){$(this).prop('outerHTML', icerik);}
                    } // Eğer kişi varsa...
                });
            } // Mevcut kişiler varsa

            // Kişileri Listeliyoruz...
            $.each(kisiler, function(i, item) {
                var isDiv = $("#"+i).has(".mesajkisi").length ? true : false;
                if(isDiv){

                }else{
                    KisiListesi.prepend(item.icerik);
                }
            });
        } // arama boş ise ve kişiler geliyorsa...

        // Profil ve Iletileri Alıyoruz...
        if(uid != 0 && data.sohbet != undefined){ // eğer üye seçilmiş ise...
            var ae = $("#ae");

            if(ae.val() != uid){
                $("#MesajlasmaContent").fadeOut(100, function(){
                    $("#UyeAvatar").attr("src", data.sohbet.avatar);
                    $("#UyeAdiSoyadi").html(data.sohbet.adsoyad);
                    $("#UyeTuru").html(data.sohbet.uyeturu);
                    $("#UyeProLink").attr("href", data.sohbet.uyeprolink);
                    if(data.sohbet.engelbutonu == 1){$("#EngelButon").hide(10);}else{$("#EngelButon").show(10);}
                    if(data.sohbet.benEngel == 1){$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX402");?>');}else{$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX403");?>');}
                    if(data.sohbet.grsmesilbuton == 1){$("#GorusmeSilButon").hide(10);}else{$("#GorusmeSilButon").show(10);}
                    if(data.sohbet.engelbutonu == 1 || data.sohbet.benEngel == 1){
                        $("#MesajlasAlani").hide(1);
                        $("#MesajEngeli").show(1);
                    }else{
                        $("#MesajEngeli").hide(1);
                        $("#MesajlasAlani").show(1);
                    }
                });
            }else{
                $("#UyeAvatar").attr("src", data.sohbet.avatar);
                $("#UyeAdiSoyadi").html(data.sohbet.adsoyad);
                $("#UyeTuru").html(data.sohbet.uyeturu);
                $("#UyeProLink").attr("href", data.sohbet.uyeprolink);
                if(data.sohbet.engelbutonu == 1){$("#EngelButon").hide(10);}else{$("#EngelButon").show(10);}
                if(data.sohbet.benEngel == 1){$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX402");?>');}else{$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX403");?>');}
                if(data.sohbet.grsmesilbuton == 1){$("#GorusmeSilButon").hide(10);}else{$("#GorusmeSilButon").show(10);}
                if(data.sohbet.engelbutonu == 1 || data.sohbet.benEngel == 1){
                    $("#MesajlasAlani").hide(1);
                    $("#MesajEngeli").show(1);
                }else{
                    $("#MesajEngeli").hide(1);
                    $("#MesajlasAlani").show(1);
                }
            }

            // İletiler için işlemler...
            var iletiler = data.sohbet.iletiler;

            if(iletiler == undefined){ // Gelen bir ileti yoksa...
                MesjListesi.html('');
                $("#MesajlasmaContent").fadeIn(300);
                ae.val(uid);
            }else{ // Eğer gelen iletiler varsa...
                var mevcut_iletiler = $("#MessagesList .msjbaloncuk");
                var mticount = mevcut_iletiler.length;
                if(mticount > 0){ // Eğer mevcut kişiler varsa
                    // Mevcut Mesajları Listeliyoruz. Kontrol ediyoruz
                    mevcut_iletiler.each(function(index) {
                        var indis = $(this).attr("id");

                        if(iletiler[indis] == undefined){
                            $(this).remove();
                        }
                    });
                } // Eğer mevcut iletiler varsa

                // İletileri Listeliyoruz...
                var ticount1 = objCount(iletiler);
                var ticount2 = 0;

                if(ticount1 > 0){
                    $.each(iletiler, function(i, item) {
                        ticount2 += 1;
                        var isDiv = $("#"+i).has("h5").length ? true : false;
                        if(isDiv){
                            var len1 = $("#"+i).prop('outerHTML').length;
                            var len2 = item.length;

                            if(len1 != len2){
                                $("#"+i).prop('outerHTML', item);
                            }
                        }else{
                            MesjListesi.append(item);
                        }
                    });
                } // Eğer iletiler 0'dan büyükse...

                if(mticount != 0 && mticount < ticount1 && ticount1 == ticount2){
                    $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
                }

                if(ticount1 == ticount2 && ae.val() != uid){
                    ae.val(uid);
                    $("#MesajlasmaContent").fadeIn(300, function(){
                        $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
                    });
                }

                if(mticount == 0 && ticount1 == ticount2 && ae.val() == uid){
                    $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
                }
            } // Eğer gelen iletiler varsa...
        } // eğer üye seçilmiş ise...
    }); // Eğer json data var ise...
} // func end

function SohbetGoster(uid){
    var neuid = $("#uid");
    if(uid != neuid.val()){
        neuid.val(uid);
        $("#MesajGonderForm").attr("action", "ajax.php?p=mesaj_gonder&uid=" + uid);
        window.history.pushState("string", "", "mesajlar?uid=" + uid);
        $("#default_acilis").hide(1);
        ArayuzYukle();
    }
}

function GorusmeyiSil(){
    var uid = $("#uid");
    var neuid = uid.val();
    if(confirm("<?=dil("TX407");?>")){
        $.get("ajax.php?p=mesaj_sil", {'uid':neuid}, function(sonuc){
            ArayuzYukle();
            $("#MesajlasmaContent").hide(1, function(){
                $("#default_acilis").show(1);
                uid.val(0);
            });
        });
    }
}

function EngelDurum(){
    var uid = $("#uid");
    var neuid = uid.val();
    if(confirm("<?=dil("TX408");?>")){
        $.get("ajax.php?p=mesaj_engelle", {'uid':neuid}, function(sonuc){
            ArayuzYukle();
        });
    }
}
</script>
<input type="hidden" id="uid" value="<?=$uid;?>" />
<input type="hidden" id="ae" value="<?=$uid;?>" />
<? } ?>

<script type="text/javascript">
<? if($rd != 'mesajlar' && $hesap->id != '' && $gayarlar->anlik_sohbet == 1){ ?>
function bildirim_kontrol(){
    $.get("ajax.php?p=mesajlar_bildirim", function(data){
        var bildirim = data.bildirim;
        var cebildirim = $.cookie("bildirim");
        if(bildirim != undefined){ // Eğer bildirim değeri geliyor ise...
            if(cebildirim == undefined){ // Eğer cerez yoksa...
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    bildirim_play();
                    $.cookie("bildirim", bildirim, { expires: 7 });
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                } // eğer bildirim 0 büyükse
            }else{ // Eğer cerez varsa
                if(bildirim == 0){ // eğer bildirim yoksa çerezi silelim...
                    $.removeCookie("bildirim");
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer bildirim varsa fark var mı kontrol edelim...
                    if(cebildirim != bildirim){ // Eğer çerez eşit değilse gelen bildirime
                        bildirim_play();
                        $.cookie("bildirim", bildirim, { expires: 7 });
                        $(".mbildirim").fadeIn(300);
                        $(".mbildirim").html(bildirim);
                    } // Eğer çerez eşit değilse gelen bildirime
                } // Eğer bildirim varsa fark var mı kontrol edelim...
            } // Eğer cerez varsa

            var mbildirim = $(".mbildirim").val();
            if(mbildirim != bildirim){ // eğer mbildirim eşit değilse
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer 0 büyük değilse
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                } // Eğer 0 büyük değilse
            } // eğer mbildirim eşit değilse
        } // Eğer

} // Eğer bildirim değeri geliyor ise...


if(ak == '' && kisiler != undefined){ // Eğer arama yapılmıyorsa ve kişiler varsa
    // Mevcut Kişileri Listeliyoruz. Kontrol ediyoruz
    var mevcut_kisiler = $("#ContactList a");
    if(mevcut_kisiler.length > 0){
        mevcut_kisiler.each(function(index) {
            var indis = $(this).attr("id");
            var kisi = kisiler[indis];
            if(kisi == undefined){ // Eğer kişi yoksa
                $(this).remove(); // Mevcut kişiyi kaldırıyoruz...
            }else{ // Eğer kişi varsa
                var icerik = kisi.icerik;
                var len1 = $(this).prop('outerHTML').length;
                var len2 = icerik.length;
                var yindex = kisi.sira;

                if(index != yindex){$(this).remove();}
                if(len1 != len2){$(this).prop('outerHTML', icerik);}
            } // Eğer kişi varsa...
        });
    } // Mevcut kişiler varsa

    // Kişileri Listeliyoruz...
    $.each(kisiler, function(i, item) {
        var isDiv = $("#"+i).has(".mesajkisi").length ? true : false;
        if(isDiv){

        }else{
            KisiListesi.prepend(item.icerik);
        }
    });

} // arama boş ise ve kişiler geliyorsa...

// Profil ve Iletileri Alıyoruz...
if(uid != 0 && data.sohbet != undefined){ // eğer üye seçilmiş ise...
    var ae = $("#ae");

    if(ae.val() != uid){
        $("#MesajlasmaContent").fadeOut(100, function(){
            $("#UyeAvatar").attr("src", data.sohbet.avatar);
            $("#UyeAdiSoyadi").html(data.sohbet.adsoyad);
            $("#UyeTuru").html(data.sohbet.uyeturu);
            $("#UyeProLink").attr("href", data.sohbet.uyeprolink);
            if(data.sohbet.engelbutonu == 1){$("#EngelButon").hide(10);}else{$("#EngelButon").show(10);}
            if(data.sohbet.benEngel == 1){$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX402");?>');}else{$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX403");?>');}
            if(data.sohbet.grsmesilbuton == 1){$("#GorusmeSilButon").hide(10);}else{$("#GorusmeSilButon").show(10);}
            if(data.sohbet.engelbutonu == 1 || data.sohbet.benEngel == 1){
                $("#MesajlasAlani").hide(1);
                $("#MesajEngeli").show(1);
            }else{
                $("#MesajEngeli").hide(1);
                $("#MesajlasAlani").show(1);
            }
        });
    }else{
        $("#UyeAvatar").attr("src", data.sohbet.avatar);
        $("#UyeAdiSoyadi").html(data.sohbet.adsoyad);
        $("#UyeTuru").html(data.sohbet.uyeturu);
        $("#UyeProLink").attr("href", data.sohbet.uyeprolink);
        if(data.sohbet.engelbutonu == 1){$("#EngelButon").hide(10);}else{$("#EngelButon").show(10);}
        if(data.sohbet.benEngel == 1){$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX402");?>');}else{$("#EngelButon").html('<i class="fa fa-ban" aria-hidden="true"></i> <?=dil("TX403");?>');}
        if(data.sohbet.grsmesilbuton == 1){$("#GorusmeSilButon").hide(10);}else{$("#GorusmeSilButon").show(10);}
        if(data.sohbet.engelbutonu == 1 || data.sohbet.benEngel == 1){
            $("#MesajlasAlani").hide(1);
            $("#MesajEngeli").show(1);
        }else{
            $("#MesajEngeli").hide(1);
            $("#MesajlasAlani").show(1);
        }
    }

    // İletiler için işlemler...
    var iletiler = data.sohbet.iletiler;

    if(iletiler == undefined){ // Gelen bir ileti yoksa...
        MesjListesi.html('');
        $("#MesajlasmaContent").fadeIn(300);
        ae.val(uid);
    }else{ // Eğer gelen iletiler varsa...
        var mevcut_iletiler = $("#MessagesList .msjbaloncuk");
        var mticount = mevcut_iletiler.length;
        if(mticount > 0){ // Eğer mevcut kişiler varsa
            // Mevcut Mesajları Listeliyoruz. Kontrol ediyoruz
            mevcut_iletiler.each(function(index) {
                var indis = $(this).attr("id");

                if(iletiler[indis] == undefined){
                    $(this).remove();
                }
            });
        } // Eğer mevcut iletiler varsa

        // İletileri Listeliyoruz...
        var ticount1 = objCount(iletiler);
        var ticount2 = 0;

        if(ticount1 > 0){
            $.each(iletiler, function(i, item) {
                ticount2 += 1;
                var isDiv = $("#"+i).has("h5").length ? true : false;
                if(isDiv){
                    var len1 = $("#"+i).prop('outerHTML').length;
                    var len2 = item.length;

                    if(len1 != len2){
                        $("#"+i).prop('outerHTML', item);
                    }
                }else{
                    MesjListesi.append(item);
                }
            });
        } // Eğer iletiler 0'dan büyükse...

        if(mticount != 0 && mticount < ticount1 && ticount1 == ticount2){
            $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
        }

        if(ticount1 == ticount2 && ae.val() != uid){
            ae.val(uid);
            $("#MesajlasmaContent").fadeIn(300, function(){
                $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
            });
        }

        if(mticount == 0 && ticount1 == ticount2 && ae.val() == uid){
            $('#MessageBox').animate({scrollTop:$('#MessageBox')[0].scrollHeight}, KaydirSure);
        }
    } // Eğer gelen iletiler varsa...
} // eğer üye seçilmiş ise...

}); // Eğer json data var ise...
} // func end

function SohbetGoster(uid){
    var neuid = $("#uid");
    if(uid != neuid.val()){
        neuid.val(uid);
        $("#MesajGonderForm").attr("action", "ajax.php?p=mesaj_gonder&uid=" + uid);
        window.history.pushState("string", "", "mesajlar?uid=" + uid);
        $("#default_acilis").hide(1);
        ArayuzYukle();
    }
}

function GorusmeyiSil(){
    var uid = $("#uid");
    var neuid = uid.val();
    if(confirm("<?=dil("TX407");?>")){
        $.get("ajax.php?p=mesaj_sil", {'uid': neuid}, function(sonuc){
            ArayuzYukle();
            $("#MesajlasmaContent").hide(1, function(){
                $("#default_acilis").show(1);
                uid.val(0);
            });
        });
    }
}

function EngelDurum(){
    var uid = $("#uid");
    var neuid = uid.val();
    if(confirm("<?=dil("TX408");?>")){
        $.get("ajax.php?p=mesaj_engelle", {'uid': neuid}, function(sonuc){
            ArayuzYukle();
        });
    }
}
</script>
<input type="hidden" id="uid" value="<?=$uid;?>" />
<input type="hidden" id="ae" value="<?=$uid;?>" />
<? } ?>

<script type="text/javascript">
<? if($rd != 'mesajlar' && $hesap->id != '' && $gayarlar->anlik_sohbet == 1){ ?>
function bildirim_kontrol(){
    $.get("ajax.php?p=mesajlar_bildirim", function(data){
        var bildirim = data.bildirim;
        var cebildirim = $.cookie("bildirim");
        if(bildirim != undefined){ // Eğer bildirim değeri geliyor ise...
            if(cebildirim == undefined){ // Eğer cerez yoksa...
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    bildirim_play();
                    $.cookie("bildirim", bildirim, { expires: 7 });
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                } // eğer bildirim 0 büyükse
            }else{ // Eğer cerez varsa
                if(bildirim == 0){ // eğer bildirim yoksa çerezi silelim...
                    $.removeCookie("bildirim");
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer bildirim varsa fark var mı kontrol edelim...
                    if(cebildirim != bildirim){ // Eğer çerez eşit değilse gelen bildirime
                        bildirim_play();
                        $.cookie("bildirim", bildirim, { expires: 7 });
                        $(".mbildirim").fadeIn(300);
                        $(".mbildirim").html(bildirim);
                    } // Eğer çerez eşit değilse gelen bildirime
                } // Eğer bildirim varsa fark var mı kontrol edelim...
            } // Eğer cerez varsa

            var mbildirim = $(".mbildirim").val();
            if(mbildirim != bildirim){ // eğer mbildirim eşit değilse
                if(bildirim > 0){ // eğer bildirim 0 büyükse
                    $(".mbildirim").fadeIn(300);
                    $(".mbildirim").html(bildirim);
                }else{ // Eğer 0 büyük değilse
                    $(".mbildirim").fadeOut(300);
                    $(".mbildirim").html(bildirim);
                } // Eğer 0 büyük değilse
            } // eğer mbildirim eşit değilse
        } // Eğer bildirim değeri geliyor ise...
    }); // Eğer varsa data
}

$(document).ready(function(){
    bildirim_kontrol();
});

setInterval("bildirim_kontrol()", 3000);
<? } ?>

var bildirim_ses = document.createElement('audio');
bildirim_ses.setAttribute('src', '<?=THEME_DIR;?>sound/notify.mp3');
bildirim_ses.addEventListener("load", function() {
    bildirim_ses.play();
}, true);

function bildirim_play(){
    bildirim_ses.play();
}

function bildirim_pause(){
    bildirim_ses.pause();
}
</script>

<script>
$(document).ready(function() {
    $("#mobileMenuToggle").click(function() {
        $("#mobileMenu").toggleClass("active");
    });
});
</script>

<script src="<?=THEME_DIR;?>js/jquery-sticky.js"></script>
<script type="text/javascript">$(document).ready(function() {$('.menu').scrollToFixed();});</script>

<? if($p == "uye_paneli" && ($rd == "dopinglerim" || $rd == "paketlerim" || $rd == "")){ ?>
<link rel="stylesheet" href="<?=THEME_DIR;?>css/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
    $( "#accordion" ).accordion({ heightStyle: "content" });
});
</script>
<? } ?>

<? if($p == 'uye_paneli' && ($_GET["rd"] == 'ilan_duzenle' || $_GET["rd"] == 'ilan_olustur')){ ?>
<script src="<?=THEME_DIR;?>nestable/js/uikit.min.js"></script>
<script src="<?=THEME_DIR;?>nestable/js/components/nestable.min.js"></script>
<script>
$('.uk-nestable').on('change.uk.nestable', function(e) {
    var data = $("#list").data("nestable").serialize();
    $.post("ajax.php?p=galeri_foto_guncelle&ilan_id=<?=$snc->id;?>&from=nestable", {value : data}, function (a) {
        $("#ilanGaleriFotolar_output").html(a);
    });
});
</script>
<? } ?>

<? echo $dayarlar->analytics; ?>
<? echo $dayarlar->embed; ?>

</body>
</html>
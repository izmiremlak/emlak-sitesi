<?php $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$istatistik_sil	= $gvn->rakam($_GET["istatistik_sil"]);
if($hesap->tipi != 2 AND $hesap->tipi != 0 AND $istatistik_sil == 1){
$db->query("DELETE FROM sayfa_ge_19541956");
$db->query("DELETE FROM ziyaret_ip_19541956");
header("Location:index.php");
}

$buay		= date("Y-m");
$bugun		= date("Y-m-d");
$buyil		= date("Y");
$igun		= date("Y-m-d",strtotime("last monday"));
if(date("N") == 1){
$igun		= date("Y-m-d");
}


$son30gun_ziyaret	= $db->query("SELECT SUM(toplam) as toplam, SUM(tekil) as toplam2 FROM sayfa_ge_19541956 WHERE tarih > DATE_SUB(CURDATE(), INTERVAL 30 DAY)")->fetch(PDO::FETCH_OBJ)->toplam2;
$bugun_ziyaret		= $db->query("SELECT toplam,tekil FROM sayfa_ge_19541956 WHERE tarih='".$bugun."' ")->fetch(PDO::FETCH_OBJ);
$bugun_ziyaret		= $bugun_ziyaret->tekil;

// Doping Satışları (Bu Ay)
$st1_ay				= $db->query("SELECT SUM(tutar) AS toplam FROM dopingler_group_19541956 WHERE durum=1 AND tarih LIKE '%".$buay."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// Üyelik Paketleri Satışları (Bu Ay)
$st2_ay				= $db->query("SELECT SUM(tutar) AS toplam FROM upaketler_19541956 WHERE durum=1 AND tarih LIKE '%".$buay."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// Öne Çıkan Danışman Satışları (Bu Ay)
$st3_ay				= $db->query("SELECT SUM(tutar) AS toplam FROM onecikan_danismanlar_19541956 WHERE durum=1 AND tarih LIKE '%".$buay."%' ")->fetch(PDO::FETCH_OBJ)->toplam;


// Doping Satışları (Bu Yıl)
$st1_yil				= $db->query("SELECT SUM(tutar) AS toplam FROM dopingler_group_19541956 WHERE durum=1 AND tarih LIKE '%".$buyil."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// Üyelik Paketleri Satışları (Bu Yıl)
$st2_yil				= $db->query("SELECT SUM(tutar) AS toplam FROM upaketler_19541956 WHERE durum=1 AND tarih LIKE '%".$buyil."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// Öne Çıkan Danışman Satışları (Bu Yıl)
$st3_yil				= $db->query("SELECT SUM(tutar) AS toplam FROM onecikan_danismanlar_19541956 WHERE durum=1 AND tarih LIKE '%".$buyil."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

$satis_aylik	= ($st1_ay + $st2_ay + $st3_ay);
$satis_yillik	= ($st1_yil + $st2_yil + $st3_yil);
$satis_aylik	= explode(",",$gvn->para_str($satis_aylik))[0];
$satis_yillik	= explode(",",$gvn->para_str($satis_yillik))[0];

/// Üyeler (Bu Ay)
$uyeler_ay		= $db->query("SELECT COUNT(id) AS toplam FROM hesaplar WHERE site_id_555=999 AND tipi=0 AND olusturma_tarih LIKE '%".$buay."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// Üyeler ( Toplam Üye)
$uyeler_toplam	= $db->query("SELECT COUNT(id) AS toplam FROM hesaplar WHERE site_id_555=999 AND tipi=0")->fetch(PDO::FETCH_OBJ)->toplam;

// İlanlar (Bugün)
$ilanlar_bugun	= $db->query("SELECT COUNT(id) AS toplam FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND (durum=1 OR durum=2) AND tarih LIKE '%".$bugun."%' ")->fetch(PDO::FETCH_OBJ)->toplam;

// İlanlar (Toplam)
$ilanlar_toplam	= $db->query("SELECT COUNT(id) AS toplam FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND (durum=1 OR durum=2)")->fetch(PDO::FETCH_OBJ)->toplam;

// Son siparişler (array)
$siparisler	= array('a','b');

$query		= $db->query("SELECT id,acid,adi,tutar,durum,tarih FROM upaketler_19541956 ORDER BY id DESC LIMIT 0,7");
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$mictime	= strtotime($row->tarih);
$tarih		= date("d.m.Y H:i",$mictime);
$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
$uye->execute(array($row->acid));
if($uye->rowCount()>0){
$uye		= $uye->fetch(PDO::FETCH_OBJ);
$uye_adi	= ($uye->unvan != '') ? $uye->unvan : $uye->adsoyad;
}else{$uye_adi	= "Yok";}
$urun		= $row->adi." Paket Üyeliği";
$tutar		= $gvn->para_str($row->tutar)." ".dil("UYELIKP_PBIRIMI");
$durum		= ($row->durum == 0) ? '<span style="color:red;"><strong>Onay Bekliyor</strong></span>' : '';
$durum		= ($row->durum == 1) ? '<span style="color:green;"><strong>Tamamlandı</strong></span>' : $durum;
$durum		= ($row->durum == 2) ? '<span style="color:black;"><strong>İptal Edildi</strong></span>' : $durum;
$link		= "index.php?p=upaket_duzenle&id=".$row->id;
$durumu		= ($row->durum == 0) ? 'a' : 'b';
$siparisler[$durumu][] = array(
'time' => $mictime,
'tarih' => $tarih,
'link' => $link,
'uye_adi' => $uye_adi,
'urun' => $urun,
'tutar' => $tutar,
'durum' => $durum,
);
}

$query		= $db->query("SELECT id,acid,tutar,durum,tarih FROM dopingler_group_19541956 ORDER BY id DESC LIMIT 0,7");
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$mictime	= strtotime($row->tarih);
$tarih		= date("d.m.Y H:i",$mictime);
$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
$uye->execute(array($row->acid));
if($uye->rowCount()>0){
$uye		= $uye->fetch(PDO::FETCH_OBJ);
$uye_adi	= ($uye->unvan != '') ? $uye->unvan : $uye->adsoyad;
}else{$uye_adi	= "Yok";}
$urun		= "İlan Doping";
$tutar		= $gvn->para_str($row->tutar)." ".dil("DOPING_PBIRIMI");
$durum		= ($row->durum == 0) ? '<span style="color:red;"><strong>Onay Bekliyor</strong></span>' : '';
$durum		= ($row->durum == 1) ? '<span style="color:green;"><strong>Tamamlandı</strong></span>' : $durum;
$durum		= ($row->durum == 2) ? '<span style="color:black;"><strong>İptal Edildi</strong></span>' : $durum;
$link		= "index.php?p=dopingler";
$durumu		= ($row->durum == 0) ? 0 : 1;
$durumu		= ($row->durum == 0) ? 'a' : 'b';
$siparisler[$durumu][] = array(
'time' => $mictime,
'tarih' => $tarih,
'link' => $link,
'uye_adi' => $uye_adi,
'urun' => $urun,
'tutar' => $tutar,
'durum' => $durum,
);
}

$query		= $db->query("SELECT id,acid,tutar,durum,tarih FROM onecikan_danismanlar_19541956 ORDER BY id DESC LIMIT 0,7");
while($row	= $query->fetch(PDO::FETCH_OBJ)){
$mictime	= strtotime($row->tarih);
$tarih		= date("d.m.Y H:i",$mictime);
$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
$uye->execute(array($row->acid));
if($uye->rowCount()>0){
$uye		= $uye->fetch(PDO::FETCH_OBJ);
$uye_adi	= ($uye->unvan != '') ? $uye->unvan : $uye->adsoyad;
}else{$uye_adi	= "Yok";}
$urun		= "Danışman Doping";
$tutar		= $gvn->para_str($row->tutar)." ".dil("DONECIKAR_PBIRIMI");
$durum		= ($row->durum == 0) ? '<span style="color:red;"><strong>Onay Bekliyor</strong></span>' : '';
$durum		= ($row->durum == 1) ? '<span style="color:green;"><strong>Tamamlandı</strong></span>' : $durum;
$durum		= ($row->durum == 2) ? '<span style="color:black;"><strong>İptal Edildi</strong></span>' : $durum;
$link		= "index.php?p=dopingler";
$durumu		= ($row->durum == 0) ? 'a' : 'b';
$siparisler[$durumu][] = array(
'time' => $mictime,
'tarih' => $tarih,
'link' => $link,
'uye_adi' => $uye_adi,
'urun' => $urun,
'tutar' => $tutar,
'durum' => $durum,
);
}
$siparisler1	= $siparisler["a"];
$siparisler2	= $siparisler["b"];

if(count($siparisler1)>0){
ksort($siparisler1);
}else{
$siparisler1	= array();
}
if(count($siparisler2)>0){
array_multisort($siparisler2, SORT_DESC, $siparisler2);
}else{
$siparisler2	= array();
}
$turler		= explode(",",dil("UYELIK_TURLERI"));

try{
$trashimg	= $db->query("SELECT galeri_foto.id,galeri_foto.resim FROM galeri_foto LEFT JOIN sayfalar ON galeri_foto.sayfa_id=sayfalar.id WHERE sayfa_id!=0 AND sayfalar.id IS NULL");
}catch(PDOException $e){echo $e->getMessage();}
while($row	= $trashimg->fetch(PDO::FETCH_OBJ)){
@unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/thumb/".$row->resim);
@unlink("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$row->resim);
$db->query("DELETE FROM galeri_foto WHERE site_id_555=999 AND id=".$row->id);
}


$trashadv	= $db->query("SELECT id,video,baslik,tarih FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=0 AND tarih<=DATE_SUB(NOW(), INTERVAL 180 MINUTE) ");
while($snc	= $trashadv->fetch(PDO::FETCH_OBJ)){
$db->query("DELETE FROM sayfalar WHERE site_id_555=999 AND id=".$snc->id." ");
if($snc->video != ''){
$nirde	= "/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/videos/".$snc->video;
if(file_exists($nirde)){
unlink($nirde);
}
}
$quu		= $db->query("SELECT id,resim FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$snc->id);
while($row  = $quu->fetch(PDO::FETCH_OBJ)){

    $pinfo      = pathinfo("/var/www/vhosts/turkiyeemlaksitesi.com.tr/turkiyeemlaksitesi.com.tr/uploads/".$row->resim);
    $folder     = $pinfo["dirname"]."/";
    $ext        = $pinfo["extension"];
    $fname      = $pinfo["filename"];
    $bname      = $pinfo["basename"];
    
    @unlink($folder."thumb/".$bname);
    @unlink($folder.$bname);
    @unlink($folder.$fname."_original.".$ext);

}
$db->query("DELETE FROM galeri_foto WHERE site_id_555=999 AND sayfa_id=".$snc->id." ");
}





?>            <div class="content">
                <div class="container">
                   
                    <div class="row">
                        
                       
                        <div class="col-sm-6 col-lg-3">
                                <div class="mini-stat clearfix bx-shadow" style="background-color:#ff9800;">
                                <a class="tooltip-bottom" data-tooltip="İlan Dopingleri, Üyelik Satışları ve Danışman Öne Çıkarma satışlarınızın tutarlarıdır." href="#" style="position:absolute;right:20px;top:5px;font-size:16px;color:white;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
                                    <span class="mini-stat-icon"><i class="fa fa-try"></i></span> 
                                    <div class="mini-stat-info text-right" style="color:white;">
                                        <span style="font-size:30px;" class=""><?=$satis_aylik;?> TL</span>
                                   Bu Ay Net Satış
                                    </div>
                                    <div class="tiles-progress">
                                        <div class="m-t-20">
                                            <h5 class="text-uppercase text-white m-0">Bu Yıl <span class="pull-right"><strong><?=$satis_yillik;?></strong> TL</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    
                    <div class="col-sm-6 col-lg-3">
                                <div class="mini-stat clearfix bg-info bx-shadow">
                                <a class="tooltip-bottom" data-tooltip="Bireysel, Kurumsal ve Danışmanlar olarak toplam kullanıcı(üye) sayısıdır." href="#" style="position:absolute;right:20px;top:5px;font-size:16px;color:white;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
                                    <span class="mini-stat-icon"><i class="fa fa-group" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right">
                                        <span style="font-size:30px;" class=""><?=$uyeler_ay;?></span>
                                   Bu Ay Üye Sayısı
                                    </div>
                                    <div class="tiles-progress">
                                        <div class="m-t-20">
                                            <h5 class="text-uppercase text-white m-0">Toplam Üye <span class="pull-right"><strong><?=$uyeler_toplam;?></strong></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-6 col-lg-3">
                                <div class="mini-stat clearfix bg-purple bx-shadow">
                                <a class="tooltip-bottom" data-tooltip="Sitenizi ziyaret eden tekil kullanıcı sayısıdır." href="#" style="position:absolute;right:40px;top:5px;font-size:16px;color:white;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
								<a class="tooltip-bottom" data-tooltip="Sayacı Sıfırla." title="Sıfırla" onclick="if(confirm('İstatistiği gerçekten silmek istiyor musunuz ?')){ window.location.href='index.php?istatistik_sil=1'; }" style="color:white;position:absolute;right:20px;top:5px;font-size:14px;" href="javascript:;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    <span class="mini-stat-icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right">
                                        <span style="font-size:30px;" class=""><?=$bugun_ziyaret;?></span>
                                   Bugün Tekil Ziyaret
                                    </div>
                                    <div class="tiles-progress">
                                        <div class="m-t-20">
                                            <h5 class="text-uppercase text-white m-0">Son 30 Günde <span class="pull-right"><strong><?=$son30gun_ziyaret;?></strong></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-6 col-lg-3">
                                <div class="mini-stat clearfix bg-success bx-shadow">
                                <a class="tooltip-left" data-tooltip="Aktif/Pasif sitenize eklenen ilan miktarlarıdır." href="#" style="position:absolute;right:20px;top:5px;font-size:16px;color:white;"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a>
                                    <span class="mini-stat-icon"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                    <div class="mini-stat-info text-right">
                                        <span style="font-size:30px;" class=""><?=$ilanlar_bugun;?></span>
                                      Bugün Eklenen İlan
                                    </div>
                                    <div class="tiles-progress">
                                        <div class="m-t-20">
                                            <h5 class="text-uppercase text-white m-0">Toplam İlan Sayısı <span class="pull-right"><strong><?=$ilanlar_toplam;?></strong></span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
<style>
.inbox-widget .inbox-item .inbox-item-text {font-size:14px;color: #777;}
</style>
					<div class="clearfix"></div>
					
<div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="ion-ios7-cart"></i> Son Siparişler</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none;" tabindex="5000">

										
										<?php
										foreach($siparisler1 AS $siparis){
										?>
										<a href="<?=$siparis["link"];?>">
                                                <div class="inbox-item">
                                                    <p class="inbox-item-author"><strong><?=$siparis["uye_adi"];?></strong></p>
                                                    <p class="inbox-item-text"><strong>Ürün:</strong> <?=$siparis["urun"];?>  - <strong>Tutar:</strong> <?=$siparis["tutar"];?>                                                    <br>
<?=$siparis["durum"];?>                                                    </p>
                                                    <p class="inbox-item-date"><?=$siparis["tarih"];?></p>
                                                </div>
                                            </a>
										<?
										}
										
										foreach($siparisler2 AS $siparis){
										?>
										<a href="<?=$siparis["link"];?>">
                                                <div class="inbox-item">
                                                    <p class="inbox-item-author"><strong><?=$siparis["uye_adi"];?></strong></p>
                                                    <p class="inbox-item-text"><strong>Ürün:</strong> <?=$siparis["urun"];?>  - <strong>Tutar:</strong> <?=$siparis["tutar"];?>                                                    <br>
<?=$siparis["durum"];?>                                                    </p>
                                                    <p class="inbox-item-date"><?=$siparis["tarih"];?></p>
                                                </div>
                                            </a>
										<?
										}
										?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
					


<div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="fa fa-globe" aria-hidden="true"></i> Onay Bekleyen İlanlar</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none;" tabindex="5000">
                                        <?php
										$query	= $db->query("SELECT id,acid,baslik,tarih,durum FROM sayfalar WHERE site_id_555=999 AND ekleme=1 AND tipi=4 AND durum=0 ORDER BY id DESC LIMIT 0,21");
										if($query->rowCount()>0){
										while($row	= $query->fetch(PDO::FETCH_OBJ)){
										$mictime	= strtotime($row->tarih);
										$tarih		= date("d.m.Y H:i",$mictime);
										$uye		= $db->prepare("SELECT id,unvan,concat_ws(' ',adi,soyadi) AS adsoyad FROM hesaplar WHERE site_id_555=999 AND id=?");
										$uye->execute(array($row->acid));
										if($uye->rowCount()>0){
										$uye		= $uye->fetch(PDO::FETCH_OBJ);
										$uye_adi	= ($uye->unvan != '') ? $uye->unvan : $uye->adsoyad;
										}else{$uye_adi	= "Yok";}
										$durum		= ($row->durum == 0) ? '<span style="color:red;"><strong>Onay Bekliyor</strong></span>' : '';
										$durum		= ($row->durum == 1) ? '<span style="color:green;"><strong>Tamamlandı</strong></span>' : $durum;
										$durum		= ($row->durum == 2) ? '<span style="color:black;"><strong>Reddedildi</strong></span>' : $durum;
										$link		= "index.php?p=ilan_duzenle&id=".$row->id;
										
										?>
										<!-- İLAN VARSA -->
										<a href="<?=$link;?>">
                                                <div class="inbox-item">
                                                    <p class="inbox-item-author"><strong><?=$uye_adi;?></strong></p>
                                                    <p class="inbox-item-text"><?=$row->baslik;?><br>
<?=$durum;?>                                                    </p>
                                                    <p class="inbox-item-date"><?=$tarih;?></p>
                                                </div>
                                            </a>
											<?}?>
											<!-- İLAN VARSA -->
											<?}else{?>
											<!-- İLAN YOKSA -->
                                            <CENTER><br><br><h1 style="font-size:55px;"><i class="fa fa-check" aria-hidden="true"></i>
</h1><h4><strong>Tüm ilanlar onaylı durumdadır.</strong><br>Onay bekleyen ilan olması durumunda, ayrıca burada görüntülenir.</h4></CENTER>
                                            <!-- İLAN YOKSA -->
											<?}?>
                                        </div>
                                    </div>
                                </div>
                            </div>




<div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="fa fa-group" aria-hidden="true"></i> Son Üyeler</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="inbox-widget nicescroll mx-box" style="overflow: hidden; outline: none;" tabindex="5000">
											
											<?php
											$query	= $db->query("SELECT id,concat_ws(' ',adi,soyadi) AS adsoyad,unvan,turu,olusturma_tarih FROM hesaplar WHERE site_id_555=000 AND tipi=0 AND durum=0 ORDER BY id DESC LIMIT 0,21");
											while($row	= $query->fetch(PDO::FETCH_OBJ)){
											$uye_adi	= ($row->unvan != '') ? $row->unvan : $row->adsoyad;
											?>
											<a href="index.php?p=uye_duzenle&id=<?=$row->id;?>">
                                                <div class="inbox-item">
                                                    <p class="inbox-item-author"><strong><?=$uye_adi;?></strong></p>
                                                     <p class="inbox-item-text">(<?=$turler[$row->turu];?> Üye) - Üyelik Tarihi: <?=date("d.m.Y H:i",strtotime($row->olusturma_tarih));?></p>
                                                </div>
                                            </a>
											<?
											}
											?>

                                        </div>
                                    </div>
                                </div>
                            </div>


					
					
                </div>
            </div>




		<!-- Content Bitiş -->
		
        </div>
       
		



	</div>
    
    <style>
        [data-tooltip],.tooltip{position:relative;cursor:pointer}
.tooltip-bottom{color:#999}
.tooltip-bottom:hover{color:#000}
[data-tooltip]:before,[data-tooltip]:after,.tooltip:before,.tooltip:after{position:absolute;visibility:hidden;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0);opacity:0;-webkit-transition:opacity .2s ease-in-out,visibility .2s ease-in-out,-webkit-transform .2s cubic-bezier(0.71,1.7,0.77,1.24);-moz-transition:opacity .2s ease-in-out,visibility .2s ease-in-out,-moz-transform .2s cubic-bezier(0.71,1.7,0.77,1.24);transition:opacity .2s ease-in-out,visibility .2s ease-in-out,transform .2s cubic-bezier(0.71,1.7,0.77,1.24);-webkit-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);transform:translate3d(0,0,0);pointer-events:none}
[data-tooltip]:hover:before,[data-tooltip]:hover:after,[data-tooltip]:focus:before,[data-tooltip]:focus:after,.tooltip:hover:before,.tooltip:hover:after,.tooltip:focus:before,.tooltip:focus:after{visibility:visible;-ms-filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);opacity:1}
.tooltip:before,[data-tooltip]:before{z-index:1001;border:6px solid transparent;background:transparent;content:""}
.tooltip:after,[data-tooltip]:after{z-index:1000;padding:8px;width:160px;background-color:#000;background-color:hsla(0,0%,20%,0.9);color:#fff;content:attr(data-tooltip);font-size:12px;line-height:1.2}
[data-tooltip]:before,[data-tooltip]:after,.tooltip:before,.tooltip:after,.tooltip-top:before,.tooltip-top:after{bottom:100%;left:50%}
[data-tooltip]:before,.tooltip:before,.tooltip-top:before{margin-left:-6px;margin-bottom:-12px;border-top-color:#000;border-top-color:hsla(0,0%,20%,0.9)}
[data-tooltip]:after,.tooltip:after,.tooltip-top:after{margin-left:-80px}
[data-tooltip]:hover:before,[data-tooltip]:hover:after,[data-tooltip]:focus:before,[data-tooltip]:focus:after,.tooltip:hover:before,.tooltip:hover:after,.tooltip:focus:before,.tooltip:focus:after,.tooltip-top:hover:before,.tooltip-top:hover:after,.tooltip-top:focus:before,.tooltip-top:focus:after{-webkit-transform:translateY(-12px);-moz-transform:translateY(-12px);transform:translateY(-12px)}
.tooltip-left:before,.tooltip-left:after{right:100%;bottom:50%;left:auto}
.tooltip-left:before{margin-left:0;margin-right:-12px;margin-bottom:0;border-top-color:transparent;border-left-color:#000;border-left-color:hsla(0,0%,20%,0.9)}
.tooltip-left:hover:before,.tooltip-left:hover:after,.tooltip-left:focus:before,.tooltip-left:focus:after{-webkit-transform:translateX(-12px);-moz-transform:translateX(-12px);transform:translateX(-12px)}
.tooltip-bottom:before,.tooltip-bottom:after{top:100%;bottom:auto;left:50%}
.tooltip-bottom:before{margin-top:-12px;margin-bottom:0;border-top-color:transparent;border-bottom-color:#000;border-bottom-color:hsla(0,0%,20%,0.9)}
.tooltip-bottom:hover:before,.tooltip-bottom:hover:after,.tooltip-bottom:focus:before,.tooltip-bottom:focus:after{-webkit-transform:translateY(12px);-moz-transform:translateY(12px);transform:translateY(12px)}
.tooltip-right:before,.tooltip-right:after{bottom:50%;left:100%}
.tooltip-right:before{margin-bottom:0;margin-left:-12px;border-top-color:transparent;border-right-color:#000;border-right-color:hsla(0,0%,20%,0.9)}
.tooltip-right:hover:before,.tooltip-right:hover:after,.tooltip-right:focus:before,.tooltip-right:focus:after{-webkit-transform:translateX(12px);-moz-transform:translateX(12px);transform:translateX(12px)}
.tooltip-left:before,.tooltip-right:before{top:3px}
.tooltip-left:after,.tooltip-right:after{margin-left:0;margin-bottom:-16px}
    </style>
    
    
    
    <script>
        var resizefunc = [];
    </script>
    <script src="assets/js/admin.min.js"></script>
    <script src="assets/vendor/moment/moment.js"></script>
    <script src="assets/vendor/waypoints/lib/jquery.waypoints.js"></script>
    <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>
    <script src="assets/vendor/sweetalert/dist/sweetalert.min.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.time.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.resize.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.pie.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.selection.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.stack.js"></script>
    <script src="assets/plugins/flot-chart/jquery.flot.crosshair.js"></script>
    <script src="assets/pages/jquery.todo.js"></script>
    <script src="assets/pages/jquery.chat.js"></script>
    <script src="assets/pages/jquery.dashboard.js"></script>
    <script type="text/javascript">
        /* ==============================================
                    Counter Up
                    =============================================== */
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 100,
                time: 1200
            });
        });
    </script>	


<?php
// Hata yönetimi için ayarları yapılandır
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error_log.txt'); // Hata log dosyasının yolu
error_reporting(E_ALL); // Tüm hataları raporla

// Hataları sitede göster
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<div style='color: red;'><b>Hata:</b> [$errno] $errstr - $errfile:$errline</div>";
    return true;
}
set_error_handler("customErrorHandler");

// Veritabanından slider bilgilerini çekiyoruz
$sql = $db->query("SELECT * FROM slider_501 WHERE dil='" . htmlspecialchars($dil, ENT_QUOTES, 'UTF-8') . "' ORDER BY sira ASC"); 
if ($sql->rowCount() > 0) { 
?>
<div id="slider">
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>    
                <?php
                $i = 0;
                while ($fe = $sql->fetch(PDO::FETCH_OBJ)) {
                    $i++;
                ?>
                <!-- SLIDE  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="500" data-thumb="uploads/thumb/<?= htmlspecialchars($fe->resim, ENT_QUOTES, 'UTF-8'); ?>" data-saveperformance="on">
                    <!-- MAIN IMAGE -->
                    <img src="<?= THEME_DIR; ?>images/dummy.png" width="auto" height="auto" alt="slidebg<?= $i; ?>" data-lazyload="uploads/<?= htmlspecialchars($fe->resim, ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- LAYERS -->
                    
                    <?php if ($fe->baslik != '') { ?>
                    <!-- LAYER NR. 4 -->
                    <div class="tp-caption grey_heavy_72 skewfromrightshort tp-resizeme rs-parallaxlevel-0"
                        data-y="246" 
                        data-speed="500"
                        data-start="500"
                        data-easing="Power3.easeInOut"
                        data-splitin="chars"
                        data-splitout="none"
                        data-elementdelay="0.1"
                        data-endelementdelay="0.1"
                        style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap; text-align: center; width: 100%; float: left;">
                        <span><?= htmlspecialchars($fe->baslik, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <?php } ?>
                    
                    <?php if ($fe->aciklama != '') { ?>
                    <!-- LAYER NR. 8 -->
                    <div class="tp-caption grey_regular_18 sfb tp-resizeme rs-parallaxlevel-0"
                        data-y="315" 
                        data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                        data-speed="500"
                        data-start="2600"
                        data-easing="Power3.easeInOut"
                        data-splitin="none"
                        data-splitout="none"
                        data-elementdelay="0.05"
                        data-endelementdelay="0.1"
                        style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap; text-align: center; width: 100%; float: left;">
                        <?= htmlspecialchars($fonk->kisalt($fe->aciklama, 0, 93), ENT_QUOTES, 'UTF-8'); echo (strlen($fe->aciklama) > 93) ? '...' : ''; ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($fe->link != '') { ?> 
                    <!-- LAYER NR. 11 -->
                    <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0"
                        data-x="470"
                        data-y="400" 
                        data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                        data-speed="500"
                        data-start="2900"
                        data-easing="Power3.easeInOut"
                        data-splitin="none"
                        data-splitout="none"
                        data-elementdelay="0.1"
                        data-endelementdelay="0.1"
                        data-linktoslide="next"
                        style="z-index: 12; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div class="rs-slideloop" data-easing="Power3.easeInOut"
                            data-speed="0.5"
                            data-xs="-5"
                            data-xe="5"
                            data-ys="0"
                            data-ye="0" 
                            style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap; text-align: center; width: 100%;">
                            <a href='<?= htmlspecialchars($fe->link, ENT_QUOTES, 'UTF-8'); ?>' id='largeredbtn'><i class="fa fa-angle-double-right" aria-hidden="true" id="slidearrow"></i> Detaylar</a>
                        </div>
                    </div>
                    <?php } ?>
                    
                </li>
                <!-- SLIDE END  -->
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php } ?>
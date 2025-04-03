<?php
// Hata raporlama ayarları
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Hata loglama
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// Session'dan custom verisini al
$customs = $_SESSION["custom"];

// Custom verisinin boşluk kontrolü
if ($fonk->bosluk_kontrol($customs) == false) {
    $custom = base64_decode($customs);
    $custom = json_decode($custom, true);
}

?>
<div class="headerbg" <?= ($gayarlar->belgeler_resim != '') ? 'style="background-image: url(uploads/' . htmlspecialchars($gayarlar->belgeler_resim, ENT_QUOTES, 'UTF-8') . ');"' : ''; ?>>
    <div id="wrapper">
        <div class="headtitle">
            <h1><?= htmlspecialchars(dil("TX549"), ENT_QUOTES, 'UTF-8'); ?></h1>
            <div class="sayfayolu">
                <!--span>...</span-->
            </div>
        </div>
    </div>
    <div class="headerwhite"></div>
</div>

<div id="wrapper">
    <div class="uyepanel">
        <div class="content">
            <div class="uyedetay">
                <div class="uyeolgirisyap">
                    <h4 class="uyepaneltitle"><?= htmlspecialchars(dil("TX549"), ENT_QUOTES, 'UTF-8'); ?></h4>

                    <?php
                    $fonk->iyzico_cek();

                    class CheckoutFormSample
                    {
                        public function should_retrieve_checkout_form_auth()
                        {
                            # create request class
                            $request = new \Iyzipay\Request\RetrieveCheckoutFormAuthRequest();
                            $request->setLocale(\Iyzipay\Model\Locale::TR);
                            $request->setConversationId("123456789");
                            $request->setToken($GLOBALS['gvn']->harf_rakam($_POST["token"]));

                            # make request
                            $checkoutFormAuth = \Iyzipay\Model\CheckoutFormAuth::retrieve($request, Sample::options());

                            # print result
                            return array(
                                'pay_status' => $checkoutFormAuth->getPaymentStatus(),
                                'status' => $checkoutFormAuth->getstatus(),
                                'errorCode' => $checkoutFormAuth->geterrorCode(),
                                'errorMessage' => $checkoutFormAuth->geterrorMessage(),
                            );
                        }
                    }

                    $odeme = 0;
                    $customx = $customs;

                    if ($fonk->bosluk_kontrol($customx) == false) {
                        $sample = new CheckoutFormSample();
                        $sonuc = $sample->should_retrieve_checkout_form_auth();
                        $satis = $custom['satis'];

                        // Kullanıcı bilgilerini veritabanından çek
                        if ($custom['acid'] != '') {
                            $hesapp = $db->prepare("SELECT * FROM hesaplar WHERE site_id_555=999 AND id=? ");
                            $hesapp->execute([(int)$custom['acid']]);
                            $hesapp = $hesapp->fetch(PDO::FETCH_OBJ);
                        }

                        // Ödeme başarılı mı kontrol et
                        if ($sonuc['status'] == 'success' AND $sonuc['pay_status'] == 'SUCCESS') {
                            $odeme = 1;

                            if ($satis == "doping_ekle") {
                                $kontrol = $db->prepare("SELECT * FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND id=?");
                                $kontrol->execute([(int)$custom["ilan_id"]]);
                                if ($kontrol->rowCount() < 1) {
                                    die();
                                }
                                $snc = $kontrol->fetch(PDO::FETCH_OBJ);

                                $odeme_yontemi = "Kredi Kartı";
                                $tarih = $fonk->datetime();
                                $durum = 1;
                                $hesap_id = $hesapp->id;

                                $adsoyad = $hesapp->adi;
                                $adsoyad .= ($hesapp->soyadi != '') ? ' ' . $hesapp->soyadi : '';
                                $adsoyad = ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
                                $baslik = $snc->baslik . " " . htmlspecialchars(dil("PAY_NAME"), ENT_QUOTES, 'UTF-8');

                                $fiyat = $gvn->para_str($custom["toplam_tutar"]) . " " . htmlspecialchars(dil("DOPING_PBIRIMI"), ENT_QUOTES, 'UTF-8');
                                $neresi = "dopinglerim";

                                $fonk->bildirim_gonder([$adsoyad, $hesapp->email, $hesapp->parola, $baslik, $fiyat, date("d.m.Y H:i", strtotime($fonk->datetime())), SITE_URL . $neresi], "siparis_onaylandi", $hesapp->email, $hesapp->telefon);

                                try {
                                    $group = $db->prepare("INSERT INTO dopingler_group_19541956 SET acid=?, ilan_id=?, tutar=?, tarih=?, odeme_yontemi=?, durum=?");
                                    $group->execute([$hesap_id, (int)$custom["ilan_id"], $custom["toplam_tutar"], $tarih, $odeme_yontemi, $durum]);
                                    $gid = $db->lastInsertId();
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                $dopingler_19541956 = $custom["dopingler_19541956"];
                                foreach ($dopingler_19541956 as $dop) {
                                    $expiry = "+" . $dop["sure"];
                                    $expiry .= ($dop["periyod"] == "gunluk") ? ' day' : '';
                                    $expiry .= ($dop["periyod"] == "aylik") ? ' month' : '';
                                    $expiry .= ($dop["periyod"] == "yillik") ? ' year' : '';
                                    $btarih = date("Y-m-d", strtotime($expiry)) . " 23:59:59";
                                    try {
                                        $olustur = $db->prepare("INSERT INTO dopingler_19541956 SET acid=?, ilan_id=?, did=?, tutar=?, adi=?, sure=?, periyod=?, tarih=?, btarih=?, durum=?, gid=?");
                                        $olustur->execute([$hesap_id, (int)$custom["ilan_id"], $dop["did"], $dop["tutar"], $dop["adi"], $dop["sure"], $dop["periyod"], $tarih, $btarih, $durum, $gid]);
                                    } catch (PDOException $e) {
                                        die($e->getMessage());
                                    }
                                }
                            } elseif ($satis == "uyelik_paketi") {
                                $id = (int)$custom["paket"];
                                $periyodu = $custom["periyod"];

                                if ($id == 0 || strlen($periyodu) > 3 || strlen($periyodu) < 1 || !is_numeric($periyodu)) {
                                    die("Çok fazla bekleme yaptınız.");
                                }

                                $sorgula = $db->prepare("SELECT * FROM uyelik_paketleri_19541956 WHERE id=?");
                                $sorgula->execute([$id]);
                                if ($sorgula->rowCount() < 1) {
                                    die();
                                }

                                $paket = $sorgula->fetch(PDO::FETCH_OBJ);
                                $ucretler = json_decode($paket->ucretler, true);
                                $secilen = $ucretler[$periyodu];

                                if ($secilen["periyod"] == '') {
                                    die();
                                }

                                $odeme_yontemi = "Kredi Kartı";
                                $tarih = $fonk->datetime();
                                $durum = 1;
                                $hesap_id = $hesapp->id;

                                $adsoyad = $hesapp->adi;
                                $adsoyad .= ($hesapp->soyadi != '') ? ' ' . $hesapp->soyadi : '';
                                $adsoyad = ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
                                $baslik = $paket->baslik . " " . htmlspecialchars(dil("PAY_NAME2"), ENT_QUOTES, 'UTF-8');

                                $fiyat = $gvn->para_str($secilen["tutar"]) . " " . htmlspecialchars(dil("UYELIKP_PBIRIMI"), ENT_QUOTES, 'UTF-8');
                                $neresi = "paketlerim";

                                $fonk->bildirim_gonder([$adsoyad, $hesapp->email, $hesapp->parola, $baslik, $fiyat, date("d.m.Y H:i", strtotime($fonk->datetime())), SITE_URL . $neresi], "siparis_onaylandi", $hesapp->email, $hesapp->telefon);

                                $expiry = "+" . $secilen["sure"];
                                $expiry .= ($secilen["periyod"] == "gunluk") ? ' day' : '';
                                $expiry .= ($secilen["periyod"] == "aylik") ? ' month' : '';
                                $expiry .= ($secilen["periyod"] == "yillik") ? ' year' : '';
                                $btarih = date("Y-m-d", strtotime($expiry)) . " 23:59:59";

                                try {
                                    $query = $db->prepare("INSERT INTO upaketler_19541956 SET acid=?, pid=?, adi=?, tutar=?, durum=?, odeme_yontemi=?, tarih=?, btarih=?, sure=?, periyod=?, aylik_ilan_limit=?, ilan_resim_limit=?, ilan_yayin_sure_limit=?, ilan_video_limit=?");
                                    $query->execute([$hesap_id, $paket->id, $paket->baslik, $secilen["tutar"], $durum, $odeme_yontemi, $tarih, $btarih, $secilen["sure"], $secilen["periyod"], $paket->aylik_ilan_limit, $paket->ilan_resim_limit, $paket->ilan_yayin_sure_limit, $paket->ilan_video_limit]);
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }
                            } elseif ($satis == "danisman_onecikar") {
                                $id = (int)$custom["danisman"];
                                $periyodu = $custom["periyod"];

                                if ($id == 0 || strlen($periyodu) > 3 || strlen($periyodu) < 1 || !is_numeric($periyodu)) {
                                    die("Çok fazla bekleme yaptınız.");
                                }

                                $kontrol = $db->prepare("SELECT id, adi, soyadi, avatar, onecikar, onecikar_btarih FROM hesaplar WHERE site_id_555=999 AND id=?");
                                $kontrol->execute([$id]);

                                if ($kontrol->rowCount() == 0) {
                                    die();
                                }

                                $danisman = $kontrol->fetch(PDO::FETCH_OBJ);

                                $ua = $fonk->UyelikAyarlar();
                                $secilen = $ua["danisman_onecikar_ucretler"][$periyodu];

                                if ($secilen["periyod"] == '') {
                                    die();
                                }

                                $odeme_yontemi = "Kredi Kartı";
                                $tarih = $fonk->datetime();
                                $durum = 1;
                                $hesap_id = $hesapp->id;

                                $adsoyad = $hesapp->adi;
                                $adsoyad .= ($hesapp->soyadi != '') ? ' ' . $hesapp->soyadi : '';
                                $adsoyad = ($hesapp->unvan != '') ? $hesapp->unvan : $adsoyad;
                                $baslik = $danisman->adsoyad . " " . htmlspecialchars(dil("PAY_NAME3"), ENT_QUOTES, 'UTF-8');

                                $fiyat = $gvn->para_str($secilen["tutar"]) . " " . htmlspecialchars(dil("DONECIKAR_PBIRIMI"), ENT_QUOTES, 'UTF-8');
                                $neresi = "eklenen-danismanlar";

                                $fonk->bildirim_gonder([$adsoyad, $hesapp->email, $hesapp->parola, $baslik, $fiyat, date("d.m.Y H:i", strtotime($fonk->datetime())), SITE_URL . $neresi], "siparis_onaylandi", $hesapp->email, $hesapp->telefon);

                                $expiry = "+" . $secilen["sure"];
                                $expiry .= ($secilen["periyod"] == "gunluk") ? ' day' : '';
                                $expiry .= ($secilen["periyod"] == "aylik") ? ' month' : '';
                                $expiry .= ($secilen["periyod"] == "yillik") ? ' year' : '';
                                $btarih = date("Y-m-d", strtotime($expiry)) . " 23:59:59";

                                try {
                                    $query = $db->prepare("INSERT INTO onecikan_danismanlar_19541956 SET acid=?, did=?, durum=?, sure=?, periyod=?, tarih=?, btarih=?, odeme_yontemi=?, tutar=?");
                                    $query->execute([$hesap_id, $danisman->id, $durum, $secilen["sure"], $secilen["periyod"], $fonk->datetime(), $btarih, $odeme_yontemi, $secilen["tutar"]]);
                                } catch (PDOException $e) {
                                    die($e->getMessage());
                                }

                                $daUpdate = $db->query("UPDATE hesaplar SET onecikar=1, onecikar_btarih='" . $btarih . "' WHERE site_id_555=999 AND id=" . $danisman->id);
                            } else {
                                $odeme = 0;
                                $hata = "Geçersiz bir sipariş";
                            }
                        } else {
                            $hata = "Status not success : " . htmlspecialchars($sonuc['errorMessage'], ENT_QUOTES, 'UTF-8');
                        }
                    } else {
                        $hata = "Geçersiz bir custom girildi.";
                    }

                    if ($odeme == 1) {
                    ?>
                        <div style="margin-top:60px;margin-bottom:60px;text-align:center;">
                            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                            <h2 style="color:green;font-weight:bold;"><?= htmlspecialchars(dil("TX550"), ENT_QUOTES, 'UTF-8'); ?></h2>
                            <br/>
                            <h4><?= htmlspecialchars(dil("TX551"), ENT_QUOTES, 'UTF-8'); ?><br></h4><br><br>
                            <?php
                            if ($customs != '') {
                                if ($custom["satis"] == "doping_ekle") {
                                    if ($_SESSION["advfrom"] == "insert") {
                                        header("Refresh:3; url=ilan-olustur?id=" . (int)$custom["ilan_id"] . "&asama=3");
                                        echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
                                    } elseif ($_SESSION["advfrom"] == "adv") {
                                        header("Refresh:3; url=uye-paneli?rd=ilan_duzenle&id=" . (int)$custom["ilan_id"] . "&goto=doping");
                                        echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
                                    }
                                } elseif ($custom["satis"] == "uyelik_paketi") {
                                    header("Refresh:2; url=paketlerim");
                                    echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
                                } elseif ($custom["satis"] == "danisman_onecikar") {
                                    header("Refresh:2; url=eklenen-danismanlar");
                                    echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
                                }
                                unset($_SESSION["custom"]);
                                unset($_SESSION["advfrom"]);
                            }
                            ?>
                        </div>

<?php } else { ?>

<div style="margin-top:60px;margin-bottom:60px;text-align:center;">
    <i style="font-size:80px;color:red;" class="fa fa-close"></i>
    <h2 style="color:red;font-weight:bold;"><?= htmlspecialchars(dil("TX553"), ENT_QUOTES, 'UTF-8'); ?></h2>
    <br/>
    <h4><?= htmlspecialchars($hata, ENT_QUOTES, 'UTF-8'); ?><br></h4><br><br>
    <?php
    if ($customs != '') {
        if ($custom["satis"] == "doping_ekle") {
            if ($_SESSION["advfrom"] == "insert") {
                header("Refresh:3; url=ilan-olustur?id=" . (int)$custom["ilan_id"] . "&asama=3");
                echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
            } elseif ($_SESSION["advfrom"] == "adv") {
                header("Refresh:3; url=uye-paneli?rd=ilan_duzenle&id=" . (int)$custom["ilan_id"] . "&goto=doping&odeme=true");
                echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
            }
        } elseif ($custom["satis"] == "uyelik_paketi") {
            header("Refresh:2; url=paketlerim");
            echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
        } elseif ($custom["satis"] == "danisman_onecikar") {
            header("Refresh:2; url=eklenen-danismanlar");
            echo htmlspecialchars(dil("TX552"), ENT_QUOTES, 'UTF-8');
        }
        unset($_SESSION["custom"]);
        unset($_SESSION["advfrom"]);
    }
    ?>
</div>
<?php } ?>


</div>

</div>
</div>
<div class="sidebar">
    <?php include THEME_DIR . "inc/uyepanel_sidebar.php"; ?>
</div>
</div>
<div class="clear"></div>

</div>
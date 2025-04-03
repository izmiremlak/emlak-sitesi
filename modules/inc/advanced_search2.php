<div class="altbaslik">
    <h4>
        <i class="fa fa-search" aria-hidden="true"></i> <strong><?= htmlspecialchars(dil("TX620"), ENT_QUOTES, 'UTF-8'); ?></strong>
    </h4>
</div>

<div class="gelismisara">
    <form action="ajax.php?p=ilanlar2" method="POST" id="IlanlarAramaForm">
        <input name="how" type="hidden" value="<?= htmlspecialchars($how, ENT_QUOTES, 'UTF-8'); ?>">
        <input name="q" type="text" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8'); ?>" placeholder="<?= htmlspecialchars(dil("TX52"), ENT_QUOTES, 'UTF-8'); ?>">

        <?php
        $emlkdrm = htmlspecialchars(dil("EMLK_DRM"), ENT_QUOTES, 'UTF-8');
        if ($emlkdrm != '') {
        ?>
            <select name="emlak_durum">
                <option value=""><?= htmlspecialchars(dil("TX53"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $emlkdrm);
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $emlak_durum) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <?php
        $emlktp = htmlspecialchars(dil("EMLK_TIPI"), ENT_QUOTES, 'UTF-8');
        if ($emlktp != '') {
        ?>
            <select name="emlak_tipi" onchange="konut_getir(this.options[this.selectedIndex].value);">
                <option value=""><?= htmlspecialchars(dil("TX54"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $emlktp);
                $isyeri = $parc[1];
                $arsa = $parc[2];
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $emlak_tipi) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("select[name=emlak_tipi]").change(function() {
                        if ($(this).val() == "<?= htmlspecialchars($isyeri, ENT_QUOTES, 'UTF-8'); ?>") {
                            $("select[name=konut_tipi] option:eq(0)").text("<?= htmlspecialchars($isyeri . " " . dil("TX666"), ENT_QUOTES, 'UTF-8'); ?>");
                            $("select[name=konut_sekli] option:eq(0)").text("<?= htmlspecialchars($isyeri . " " . dil("TX667"), ENT_QUOTES, 'UTF-8'); ?>");
                        } else {
                            $("select[name=konut_tipi] option:eq(0)").text("<?= htmlspecialchars(dil("TX57"), ENT_QUOTES, 'UTF-8'); ?>");
                            $("select[name=konut_sekli] option:eq(0)").text("<?= htmlspecialchars(dil("TX58"), ENT_QUOTES, 'UTF-8'); ?>");
                        }
                    });
                });
            </script>
        <?php } ?>

        <?php
        if ($emlak_tipi == $isyeri) {
            $knttipi = htmlspecialchars(dil("KNT_TIPI2"), ENT_QUOTES, 'UTF-8');
        } else {
            $knttipi = htmlspecialchars(dil("KNT_TIPI"), ENT_QUOTES, 'UTF-8');
        }
        if ($knttipi != '') {
        ?>
            <select name="konut_tipi">
                <option value=""><?= htmlspecialchars(dil("TX57"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $knttipi);
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $konut_tipi) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <?php
        $kntsekli = htmlspecialchars(dil("KNT_SEKLI"), ENT_QUOTES, 'UTF-8');
        if ($kntsekli != '') {
        ?>
            <select name="konut_sekli">
                <option value=""><?= htmlspecialchars(dil("TX58"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $kntsekli);
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $konut_sekli) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <?php
        $ulkeler = $db->query("SELECT * FROM ulkeler_19541956 ORDER BY id ASC");
        $ulkelerc = $ulkeler->rowCount();
        if ($ulkelerc > 1) {
            if ($il != '' && $il != 0) {
                $yakalail = $db->prepare("SELECT ulke_id FROM il WHERE id=?");
                $yakalail->execute([$il]);
                if ($yakalail->rowCount() > 0) {
                    $yakalail = $yakalail->fetch(PDO::FETCH_OBJ);
                }
            }
        ?>
            <select name="ulke_id" onchange="ajaxHere('ajax.php?p=il_getir&ulke_id=' + this.options[this.selectedIndex].value, 'il');">
                <option value=""><?= htmlspecialchars(dil("TX348"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                while ($row = $ulkeler->fetch(PDO::FETCH_OBJ)) {
                ?>
                    <option value="<?= (int)$row->id; ?>" <?= ($yakalail->ulke_id == $row->id) ? 'selected' : ''; ?>><?= htmlspecialchars($row->ulke_adi, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <select name="il" id="il" onchange="ajaxHere('ajax.php?p=ilce_getir&varsa=1&il_id=' + this.options[this.selectedIndex].value, 'ilce');">
            <option value=""><?= htmlspecialchars(dil("TX55"), ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
            if ($ulkelerc < 2) {
                $ulke = $ulkeler->fetch(PDO::FETCH_OBJ);
                $sql = $db->query("SELECT id,il_adi FROM il WHERE ulke_id=" . (int)$ulke->id . " ORDER BY id ASC");
            } elseif ($yakalail != false) {
                $sql = $db->query("SELECT id,il_adi FROM il WHERE ulke_id=" . (int)$yakalail->ulke_id . " ORDER BY id ASC");
            } else {
                $sql = NULL;
            }
            if ($sql != NULL) {
                while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
                    if ($row->id == $il) {
                        $il_adi = $row->il_adi;
                    }
            ?>
                    <option value="<?= (int)$row->id; ?>" <?= ($row->id == $il) ? 'selected' : ''; ?>><?= htmlspecialchars($row->il_adi, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
                }
            }
            ?>
        </select>

        <select name="ilce" id="ilce" onchange="ajaxHere('ajax.php?p=mahalle_getir&ilce_id=' + this.options[this.selectedIndex].value, 'mahalle');">
            <option value=""><?= htmlspecialchars(dil("TX56"), ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
            if ($il != '') {
                $sql = $db->prepare("SELECT id,ilce_adi FROM ilce WHERE il_id=? ORDER BY id ASC");
                $sql->execute([$il]);
            } else {
                $sql = '';
            }
            if ($sql != '') {
                while ($row = $sql->fetch(PDO::FETCH_OBJ)) {
            ?>
                    <option value="<?= (int)$row->id; ?>" <?= ($row->id == $ilce) ? 'selected' : ''; ?>><?= htmlspecialchars($row->ilce_adi, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
                }
            }
            ?>
        </select>

        <select name="mahalle" id="mahalle">
            <option value=""><?= htmlspecialchars(dil("TX266"), ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
            if ($ilce != '') {
                $semtler = $db->query("SELECT * FROM semt WHERE ilce_id=" . (int)$ilce);
                if ($semtler->rowCount() > 0) {
                    while ($srow = $semtler->fetch(PDO::FETCH_OBJ)) {
                        $mahalleler = $db->query("SELECT * FROM mahalle_koy WHERE semt_id=" . (int)$srow->id . " AND ilce_id=" . (int)$ilce . " ORDER BY mahalle_adi ASC");
                        if ($mahalleler->rowCount() > 0) {
            ?>
                            <optgroup label="<?= htmlspecialchars($srow->semt_adi, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php
                                while ($row = $mahalleler->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                    <option value="<?= (int)$row->id; ?>" <?= ($mahalle == $row->id) ? 'selected' : ''; ?>><?= htmlspecialchars($row->mahalle_adi, ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php
                                }
                                ?>
                            </optgroup>
                        <?php
                        }
                    }
                } else {
                    $mahalleler = $db->query("SELECT * FROM mahalle_koy WHERE ilce_id=" . (int)$ilce . " ORDER BY mahalle_adi ASC");
                    while ($row = $mahalleler->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <option value="<?= (int)$row->id; ?>" <?= ($mahalle == $row->id) ? 'selected' : ''; ?>><?= htmlspecialchars($row->mahalle_adi, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php
                    }
                }
            }
            ?>
        </select>

        <?php
        $bulundkat = htmlspecialchars(dil("BULND_KAT"), ENT_QUOTES, 'UTF-8');
        if ($bulundkat != '') {
        ?>
            <select name="bulundugu_kat">
                <option value=""><?= htmlspecialchars(dil("TX59"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $bulundkat);
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $bulundugu_kat) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <input name="min_fiyat" type="text" value="<?= ($min_fiyat != 0) ? htmlspecialchars($min_fiyat, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX60"), ENT_QUOTES, 'UTF-8'); ?>">
        <input name="max_fiyat" type="text" value="<?= ($max_fiyat != 0) ? htmlspecialchars($max_fiyat, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX61"), ENT_QUOTES, 'UTF-8'); ?>">

        <input name="min_metrekare" type="text" value="<?= ($min_metrekare != 0) ? htmlspecialchars($min_metrekare, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX62"), ENT_QUOTES, 'UTF-8'); ?>">
        <input name="max_metrekare" type="text" value="<?= ($max_metrekare != 0) ? htmlspecialchars($max_metrekare, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX63"), ENT_QUOTES, 'UTF-8'); ?>">

        <input name="min_bina_kat_sayisi" type="text" value="<?= ($min_bina_kat_sayisi != 0) ? htmlspecialchars($min_bina_kat_sayisi, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX64"), ENT_QUOTES, 'UTF-8'); ?>">
        <input name="max_bina_kat_sayisi" type="text" value="<?= ($max_bina_kat_sayisi != 0) ? htmlspecialchars($max_bina_kat_sayisi, ENT_QUOTES, 'UTF-8') : ''; ?>" id="yariminpt" placeholder="<?= htmlspecialchars(dil("TX65"), ENT_QUOTES, 'UTF-8'); ?>">

        <?php
        $yapidrm = htmlspecialchars(dil("YAPI_DRM"), ENT_QUOTES, 'UTF-8');
        if ($yapidrm != '') {
        ?>
            <select name="yapi_durum">
                <option value=""><?= htmlspecialchars(dil("TX66"), ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                $parc = explode("<+>", $yapidrm);
                foreach ($parc as $val) {
                ?>
                    <option <?= ($val == $yapi_durum) ? 'selected' : ''; ?>><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php
                }
                ?>
            </select>
        <?php } ?>

        <select name="ilan_tarih">
            <option value=""><?= htmlspecialchars(dil("TX67"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="bugun" <?= ($ilan_tarih == "bugun") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX68"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son3" <?= ($ilan_tarih == "son3") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX69"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son7" <?= ($ilan_tarih == "son7") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX70"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son14" <?= ($ilan_tarih == "son14") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX71"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son21" <?= ($ilan_tarih == "son21") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX72"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son1ay" <?= ($ilan_tarih == "son1ay") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX73"), ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="son2ay" <?= ($ilan_tarih == "son2ay") ? 'selected' : ''; ?>><?= htmlspecialchars(dil("TX74"), ENT_QUOTES, 'UTF-8'); ?></option>
        </select>

        <div class="clear"></div>
        <br />

        <input id="resimli" class="checkbox-custom" name="resimli" value="true" type="checkbox" <?= ($resimli == "true") ? 'checked' : ''; ?> style="width:100px;">
        <label for="resimli" class="checkbox-custom-label" style="margin-bottom:5px;"><span class="checktext"><?= htmlspecialchars(dil("TX613"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        <div class="clear"></div>

        <input id="videolu" class="checkbox-custom" name="videolu" value="true" type="checkbox" <?= ($videolu == "true") ? 'checked' : ''; ?> style="width:100px;">
        <label for="videolu" class="checkbox-custom-label"><span class="checktext"><?= htmlspecialchars(dil("TX614"), ENT_QUOTES, 'UTF-8'); ?></span></label>
        <div class="clear"></div>
        <br />

        <a href="javascript:;" onclick="AjaxFormS('IlanlarAramaForm','IlanlarAramaForm_sonuc');" class="gonderbtn"><i class="fa fa-search" aria-hidden="true"></i> <?= htmlspecialchars(dil("TX75"), ENT_QUOTES, 'UTF-8'); ?></a>

        <input type="hidden" name="order" value="<?= htmlspecialchars($orderg, ENT_QUOTES, 'UTF-8'); ?>" />
        <?php if ($sicak == "true") { ?>
            <input type="hidden" name="sicak" value="true" />
        <?php } ?>
        <?php if ($vitrin == "true") { ?>
            <input type="hidden" name="vitrin" value="true" />
        <?php } ?>
        <?php if ($onecikan == "true") { ?>
            <input type="hidden" name="onecikan" value="true


</form>

<script type="text/javascript">

function konut_getir(tipi){

    if(tipi == "<?=$isyeri;?>"){

        $("select[name=konut_tipi]").html("<?php
            $knttipi = htmlspecialchars(dil("KNT_TIPI2"), ENT_QUOTES, 'UTF-8');
            ?><option value=''><?= htmlspecialchars(dil("TX57"), ENT_QUOTES, 'UTF-8'); ?></option><?php
            $parc = explode("<+>", $knttipi);
            foreach($parc as $val){
                ?><option><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option><?php
            }
        ?>");

    } else {

        $("select[name=konut_tipi]").html("<?php
            $knttipi = htmlspecialchars(dil("KNT_TIPI"), ENT_QUOTES, 'UTF-8');
            ?><option value=''><?= htmlspecialchars(dil("TX57"), ENT_QUOTES, 'UTF-8'); ?></option><?php
            $parc = explode("<+>", $knttipi);
            foreach($parc as $val){
                ?><option><?= htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></option><?php
            }
        ?>");

    }

}

</script>

<div id="IlanlarAramaForm_sonuc" style="display:none"></div>

</div>
<? if(!defined("THEME_DIR")){die(); } ?>
<div class="uyepanellinks">
<h5><?=dil("TX107");?><br>
<strong>Sn. <?=$hesap->adi.' '.$hesap->soyadi;?></strong>
</h5>

<!-- id="uyeaktifbtn" -->
<a id="uyepanelyeniilan" class="btn" href="ilan-olustur"><i class="fa fa-plus" aria-hidden="true"></i> <?=dil("TX108");?></a>
<? if($hesap->turu ==1 || $hesap->turu == 0){?>
<?php
$upaketleri	= $db->query("SELECT id FROM upaketler_19541956 WHERE acid=".$hesap->id);
$upaketleri	= $upaketleri->rowCount();
?>
<a <?=($upaketleri<1) ? 'id="uyepaketlink" ' : '';?>class="btn<?=($rd == "paketlerim" || $rd == "uyelik_paketi_satinal") ? ' uyeaktifbtn2' : '';?>" href="<?=($upaketleri>0) ? 'paketlerim' : 'uyelik-paketleri';?>"><i class="fa fa-trophy" aria-hidden="true"></i> <?=($upaketleri>0) ? dil("TX657") : dil("TX476");?></a>
<? } ?>
<a class="btn" href="dopinglerim" <?=($rd == "dopinglerim") ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-rocket" aria-hidden="true"></i> <?=dil("TX534");?></a>
<a class="btn" href="aktif-ilanlar" <?=($rd == "aktif_ilanlar") ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-thumbs-up" aria-hidden="true"></i> <?=dil("TX110");?></a>
<a class="btn" href="pasif-ilanlar" <?=($rd == "pasif_ilanlar") ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-power-off" aria-hidden="true"></i> <?=dil("TX111");?></a>
<? if($hesap->turu == 1){?> 
<a class="btn" href="eklenen-danismanlar" <?=($rd == "danismanlar" || $rd == "danisman_ekle" || $rd == "danisman_duzenle") ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-briefcase" aria-hidden="true"></i> <?=dil("TX485");?></a>
<? } ?>
<a class="btn" href="favori-ilanlar" <?=($rd == "favori_ilanlar") ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-heart" aria-hidden="true"></i> <?=dil("TX436");?></a>
<?if($gayarlar->anlik_sohbet==1){?>
<a class="btn" href="mesajlar" <?=($rd == "mesajlar") ? 'id="uyeaktifbtn"' : '';?>><span style="    margin-left: -29px;    position: absolute;    margin-top: -15px;display:none" class="msjvar mbildirim">0</span><i class="fa fa-envelope" aria-hidden="true"></i> <?=dil("TX394");?></a>
<?}?>
<a class="btn" href="uye-paneli" <?=($rd == '') ? 'id="uyeaktifbtn"' : '';?>><i class="fa fa-user" aria-hidden="true"></i> <?=dil("TX109");?></a>
</div>
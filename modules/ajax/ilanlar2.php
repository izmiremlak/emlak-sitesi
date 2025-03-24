<?php
if(!$_POST){
die();
}
$filtre					= '';
$search_linkx			= SITE_URL;
$search_link			= SITE_URL;
$filtre_count			= 0;
$bgrsyok				= 0;
$how					= $gvn->harf_rakam($_POST["how"]);
$sicak					= $gvn->harf_rakam($_POST["sicak"]);
$vitrin					= $gvn->harf_rakam($_POST["vitrin"]);
$onecikan				= $gvn->harf_rakam($_POST["onecikan"]);
$resimli				= $gvn->harf_rakam($_POST["resimli"]);
$videolu				= $gvn->harf_rakam($_POST["videolu"]);
$order					= $gvn->harf_rakam($_POST["order"]);
$q						= $gvn->html_temizle($_POST["q"]);
$emlak_durum			= $gvn->html_temizle($_POST["emlak_durum"]);
$emlak_tipi				= $gvn->html_temizle($_POST["emlak_tipi"]);
$il						= $gvn->rakam($_POST["il"]);
$ilce					= $gvn->rakam($_POST["ilce"]);
$mahalle				= $gvn->rakam($_POST["mahalle"]);
$konut_tipi				= $gvn->html_temizle($_POST["konut_tipi"]);
$konut_sekli			= $gvn->html_temizle($_POST["konut_sekli"]);
$bulundugu_kat			= $gvn->html_temizle($_POST["bulundugu_kat"]);
$min_fiyat				= $gvn->prakam($_POST["min_fiyat"]);
$max_fiyat				= $gvn->prakam($_POST["max_fiyat"]);
$min_metrekare			= $gvn->rakam($_POST["min_metrekare"]);
$max_metrekare			= $gvn->rakam($_POST["max_metrekare"]);
$min_bina_kat_sayisi	= $gvn->rakam($_POST["min_bina_kat_sayisi"]);
$max_bina_kat_sayisi	= $gvn->rakam($_POST["max_bina_kat_sayisi"]);
$yapi_durum				= $gvn->html_temizle($_POST["yapi_durum"]);
$ilan_tarih				= $gvn->html_temizle($_POST["ilan_tarih"]);

// Gelen filtreleme isteklerinin hepsi boşsa indexe yönlendiriyoruz...
if(
$fonk->bosluk_kontrol($q) == true AND
$fonk->bosluk_kontrol($emlak_durum) == true AND
$fonk->bosluk_kontrol($emlak_tipi) == true AND
$fonk->bosluk_kontrol($il) == true AND
$fonk->bosluk_kontrol($ilce) == true AND
$fonk->bosluk_kontrol($mahalle) == true AND
$fonk->bosluk_kontrol($konut_tipi) == true AND
$fonk->bosluk_kontrol($konut_sekli) == true AND
$fonk->bosluk_kontrol($bulundugu_kat) == true AND
$fonk->bosluk_kontrol($min_fiyat) == true AND
$fonk->bosluk_kontrol($max_fiyat) == true AND
$fonk->bosluk_kontrol($min_metrekare) == true AND
$fonk->bosluk_kontrol($max_metrekare) == true AND
$fonk->bosluk_kontrol($min_bina_kat_sayisi) == true AND
$fonk->bosluk_kontrol($max_bina_kat_sayisi) == true AND
$fonk->bosluk_kontrol($yapi_durum) == true AND
$fonk->bosluk_kontrol($ilan_tarih) == true AND
$fonk->bosluk_kontrol($sicak) == true AND
$fonk->bosluk_kontrol($vitrin) == true AND
$fonk->bosluk_kontrol($onecikan) == true AND
$fonk->bosluk_kontrol($resimli) == true AND
$fonk->bosluk_kontrol($videolu) == true AND
$fonk->bosluk_kontrol($how) == true
){
#$fonk->yonlendir("index.html",1);
die();
}

$search_link	.= "profil/".$how."/";

// Emlak Durumu için filtre...
if($emlak_durum != ''){
$bgrsyok		+=1;
$getemlkdrm		= $gvn->permaLink($emlak_durum);
$search_link	.= $getemlkdrm."/";
}

// Emlak Tipi için filtre...
if($emlak_tipi != ''){
$bgrsyok		+=1;
$getemlktipi	= $gvn->PermaLink($emlak_tipi);
$search_link	.= $getemlktipi."/";
}

// Konut Şekli için filtre...
if($konut_sekli != ''){
$bgrsyok		+=1;
$getkonutskli	= $gvn->PermaLink($konut_sekli);
$search_link	.= $getkonutskli."/";
}

// Konut Tipi için filtre...
if($konut_tipi != ''){
$bgrsyok		+=1;
$getkonuttpi	= $gvn->PermaLink($konut_tipi);
$search_link	.= $getkonuttpi."/";
}


// İl için filtre...
if($il != ''){
$ilkontrol		= $db->prepare("SELECT id,il_adi,slug FROM il WHERE id=? ORDER BY id ASC");
$ilkontrol->execute(array($il));
if($ilkontrol->rowCount() > 0){
$ilim			= $ilkontrol->fetch(PDO::FETCH_OBJ);
$bgrsyok		+=1;
$search_link	.= $ilim->slug."-";
}
}

// İlçe için filtre...
if($ilce != '' AND $ilim->id != ''){
$ilcekontrol	= $db->prepare("SELECT id,ilce_adi,slug FROM ilce WHERE id=? ORDER BY id ASC");
$ilcekontrol->execute(array($ilce));
if($ilcekontrol->rowCount() > 0){
$ilcem			= $ilcekontrol->fetch(PDO::FETCH_OBJ);
$bgrsyok		+=1;
$search_link	.= $ilcem->slug."-";
}
}

// Mahalle için filtre...
if($mahalle != '' AND $ilcem->id != '' AND $ilim->id != ''){
$mahkontrol		= $db->prepare("SELECT id,slug FROM mahalle_koy WHERE id=? ORDER BY id ASC");
$mahkontrol->execute(array($mahalle));
if($mahkontrol->rowCount() > 0){
$mahallem		= $mahkontrol->fetch(PDO::FETCH_OBJ);
$bgrsyok		+=1;
$search_link	.= $mahallem->slug."-";
}
}


$search_link	= ($bgrsyok>0) ? rtrim($search_link,"-") : $search_link;
$search_link	= ($bgrsyok>0) ? rtrim($search_link,"/") : $search_link;
$search_link	= ($bgrsyok>0) ? $search_link : $search_linkx."profil/".$how."/portfoy";



// resimli ilanları için filtre
if($resimli == "true"){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$search_link	.= $bgrs."resimli=true";
}

// videolu ilanları için filtre
if($videolu == "true"){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$search_link	.= $bgrs."videolu=true";
}


// Kelime veya İlan No ile arama için filtre
if($q != ''){

$varmikontrol	= $db->prepare("SELECT id,url FROM sayfalar XXXXXXXXXXXXXXXXXXXXXX ilan_no=? AND tipi=4 AND durum=1");
$varmikontrol->execute(array($q));
if($varmikontrol->rowCount()>0){
$ilani			= $varmikontrol->fetch(PDO::FETCH_OBJ);
$linki			= ($dayarlar->permalink == 'Evet') ? $ilani->url.'.html' : 'index.php?p=sayfa&id='.$ilani->id;
$fonk->yonlendir($linki,1);
die();
}

$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND (baslik LIKE '%".$q."%' OR ilan_no LIKE '%".$q."%') ";
$search_link	.= $bgrs."q=".$q;
}



// Bulunduğu Kat için filtre...
if($bulundugu_kat != ''){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND bulundugu_kat='".$bulundugu_kat."' ";
$search_link	.= $bgrs."bulundugu_kat=".$bulundugu_kat;
}


// Min Fiyat için filtre...
if($min_fiyat != '' AND strlen($min_fiyat) < 24){
$min_fiyat_int	= $gvn->para_int($min_fiyat);
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND fiyat >= ".$min_fiyat_int." ";
$search_link	.= $bgrs."min_fiyat=".$min_fiyat; 
}

// Max Fiyat için filtre...
if($max_fiyat != '' AND strlen($max_fiyat) < 24){
$max_fiyat_int	= $gvn->para_int($max_fiyat);
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND fiyat <= ".$max_fiyat_int." ";
$search_link	.= $bgrs."max_fiyat=".$max_fiyat; 
}


// Min Metrekare için filtre...
if($min_metrekare != '' AND strlen($min_metrekare) < 24 AND !stristr($min_metrekare,'.')){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND metrekare >= ".$min_metrekare." ";
$search_link	.= $bgrs."min_metrekare=".$min_metrekare; 
}

// Max Metrekare için filtre...
if($max_metrekare != '' AND strlen($max_metrekare) < 24 AND !stristr($max_metrekare,'.')){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND metrekare <= ".$max_metrekare." ";
$search_link	.= $bgrs."max_metrekare=".$max_metrekare;
}


// Min Bina Kat Sayısı için filtre...
if($min_bina_kat_sayisi != '' AND strlen($min_bina_kat_sayisi) < 24 AND !stristr($min_bina_kat_sayisi,'.')){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND bina_kat_sayisi >= ".$min_bina_kat_sayisi." ";
$search_link	.= $bgrs."min_bina_kat_sayisi=".$min_bina_kat_sayisi; 
}

// Max Bina Kat Sayısı için filtre...
if($max_bina_kat_sayisi != '' AND strlen($max_bina_kat_sayisi) < 24 AND !stristr($max_bina_kat_sayisi,'.')){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query 	.= "AND bina_kat_sayisi <= ".$max_bina_kat_sayisi." ";
$search_link	.= $bgrs."max_bina_kat_sayisi=".$max_bina_kat_sayisi;
}


// İlan Tarihi için filtre...
if($ilan_tarih != ''){
$islem		= '';
if($ilan_tarih == "bugun"){
$islem 		= "tarih LIKE '%".date("Y-m-d")."%'";
}elseif($ilan_tarih == "son3"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
}elseif($ilan_tarih == "son7"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
}elseif($ilan_tarih == "son14"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 2 WEEK)";
}elseif($ilan_tarih == "son21"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 3 WEEK)";
}elseif($ilan_tarih == "son1ay"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
}elseif($ilan_tarih == "son2ay"){
$islem		= "tarih > DATE_SUB(CURDATE(), INTERVAL 2 MONTH)";
}
if($islem != ''){
$filtre_count	+=1;
$bgrs			= ($filtre_count < 2) ? '?' : '&';
$dahili_query	.= "AND ".$islem." ";
$search_link	.= $bgrs."ilan_tarih=".$ilan_tarih;
}
}





// Order için
if($order != ''){
$search_link	.= "&order=".$order;
}


$search_link		= str_replace("/?","?",$search_link);

$fonk->yonlendir($search_link,1);

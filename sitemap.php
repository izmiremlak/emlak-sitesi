<?php include "functions.php"; header("Content-Type:xml; Charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
					  
	';
					  
					  
    $cek=$db->query("SELECT * FROM sayfalar WHERE site_id_555=999 AND tipi=4 AND ekleme=1 AND durum=1 AND dil='".$dil."' ORDER BY id DESC LIMIT 50000");
	
        while($veri=$cek->fetch(PDO::FETCH_OBJ)){
		$link = ($dayarlar->permalink == 'Evet') ? $veri->url.'.html' : 'index.php?p=sayfa&id='.$veri->id;
     ?>
	 <url>
	 <loc><? echo SITE_URL.$link; ?></loc>
	 <changefreq>always</changefreq>
	 </url>
	 <?
	 
	 echo "\n";
}

	$cek=$db->query("SELECT * FROM sayfalar WHERE site_id_555=999 AND tipi!=4 AND dil='".$dil."' ORDER BY id DESC LIMIT 50000");
	
        while($veri=$cek->fetch(PDO::FETCH_OBJ)){
		$link = ($dayarlar->permalink == 'Evet') ? $veri->url.'.html' : 'index.php?p=sayfa&id='.$veri->id;
     ?>
	 <url>
	 <loc><? echo SITE_URL.$link; ?></loc>
	 <changefreq>always</changefreq>
	 </url>
	 <?
	 
	 echo "\n";
}


    $cek=$db->query("SELECT * FROM referanslar_19541956 WHERE dil='".$dil."' ORDER BY sira ASC");
	
        while($veri=$cek->fetch(PDO::FETCH_OBJ)){
		$link = (stristr($veri->website,"http")) ? $veri->link : SITE_URL.$veri->website;
     ?>
	 <url>
	 <loc><?=str_replace(array("&"),array("&amp;"),$link);?></loc>
	 <changefreq>always</changefreq>
	 </url>
	 <?
	 
	 echo "\n";
}


?>
</urlset>
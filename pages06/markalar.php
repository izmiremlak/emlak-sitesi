            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="pull-left page-title">Markalar</h4>

                        </div>
                    </div>
					
<?=$fonk->bilgi("Yükleme işlemi tamamlandığında lütfen sayfayı yenileyiniz."); ?>	
<?php
if($hesap->tipi != 2){
$sil			= $gvn->rakam($_GET["sil"]);
if($sil != ""){
$db->query("DELETE FROM markalar WHERE id=".$sil." ");
header("Location:index.php?p=markalar");
}
}
?>


<?=$fonk->bilgi("Yükleyeceğiniz görsellerin boyutu ".$gorsel_boyutlari['markalar']['thumb_x'].' x '.$gorsel_boyutlari['markalar']['thumb_y'].' px olmalıdır.'); ?>

<div class="row">
                        <div class="col-md-12 portlets">						
						
                            <div class="m-b-30">
                                <form action="#" class="dropzone" id="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple="multiple">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					
						
                        


<div class="row port">
<div class="portfolioContainer">

<?php
$sql		= $db->query("SELECT * FROM markalar where dil='".$dil."' ORDER BY id DESC");
while($row	= $sql->fetch(PDO::FETCH_OBJ)){
?>
<div class="col-sm-6 col-lg-3 col-md-4 webdesign illustrator">
<div class="gal-detail thumb">
<a href="../uploads/<?=$row->resim;?>" class="image-popup" ><img src="../uploads/thumb/<?=$row->resim;?>" class="thumb-img" alt="work-thumbnail"></a>
<h4 align="center"> 
<a href="index.php?p=markalar&sil=<?=$row->id;?>"><button class="btn btn-icon waves-effect waves-light btn-danger m-b-5"><i class="fa fa-remove"></i></button></a> </div>
</div>
<? } ?>


</div>
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
    <link rel="stylesheet" href="assets/vendor/magnific-popup/dist/magnific-popup.css">
	<link href="assets/vendor/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
    <script src="assets/vendor/notifyjs/dist/notify.min.js"></script>
    <script src="assets/plugins/notifications/notify-metro.js"></script>
    <script src="assets/plugins/notifications/notifications.js"></script>    <script type="text/javascript" src="assets/vendor/isotope/dist/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="assets/vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            var $container = $('.portfolioContainer');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });

            $('.portfolioFilter a').click(function() {
                $('.portfolioFilter .current').removeClass('current');
                $(this).addClass('current');

                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        });
        $(document).ready(function() {
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                }
            });
        });
    </script>
	<script src="assets/vendor/dropzone/dist/dropzone_referanslar.js"></script>
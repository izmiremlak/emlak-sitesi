<?php include "../functions.php";
if($hesap->id != ""){
header("Location:index.php");
die("Access Denied User"); exit;
}

if(strstr($_SERVER["HTTP_HOST"],"izmirtr.com")){
$demo = 1;
}

?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/images/favicon_1.ico">
    <title>Yönetim Paneli</title>
    <link href="assets/css/admin.min.css" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]-->
		

	<script type="text/javascript" src="assets/istmark/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="assets/istmark/jquery.form.min.js"></script>
	<script type="text/javascript" src="assets/istmark/login_main.js"></script>
</head>

<body <?=($demo == 1) ? 'onload="AjaxFormS(\'LoginForm\',\'login_status\');"' : '';?>>
    <div class="wrapper-page">
        <div class="panel panel-color panel-primary panel-pages">
            <div class="panel-heading bg-img" style="background-color:#333;">
                <div class="bg-overlay"></div>
                <h3 class="text-center m-t-10 text-white">YÖNETİM PANELİ</h3></div>
            <div class="panel-body">
			
			<div style="" id="login_status"></div>
			
                <form class="form-horizontal m-t-20" action="ajax.php?p=login" id="LoginForm" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" type="text" name="email" placeholder="E-Posta" value="<?=($demo == 1) ? 'demo@example.com' : '';?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control input-lg" type="password" name="parola"  placeholder="Parola" value="<?=($demo == 1) ? 'demo' : '';?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" name="otut" value="1" type="checkbox" checked>
                                <label for="checkbox-signup">Beni Hatırla</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12">
                            <button class="btn btn-default btn-rounded waves-effect m-b-5" type="submit" onclick="AjaxFormS('LoginForm','login_status');">Oturum Aç</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-7"><a href="forget_password.php"><i class="fa fa-lock m-r-5"></i> Parolamı Hatırlat</a></div>
                        <div class="col-sm-5 text-right"><a href="../"><i class="fa fa-home"></i> Anasayfaya Dön</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

	<script>
    var resizefunc = [];
    </script>
    <script src="assets/js/admin.min.js"></script>
	<script>
</html>
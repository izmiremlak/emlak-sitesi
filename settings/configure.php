<?php

require_once __DIR__."/DB.php";


$php_ver			= substr(phpversion(),0,3);

if($php_ver < '5.4' ){
die("Yazılım en düşük  PHP 5.4 kadar desteklemektedir. Lütfen php versiyonunuzu yükseltin.");
}


$stadrs		= str_replace("www.","",strtolower($_SERVER["SERVER_NAME"]));
// site domain adını buraya yazınız
if(strstr($stadrs,"izmiremlakbirligi.com.tr")){
$domain2		= "izmiremlakbirligi.com.tr";
}else{
if(!is_file(__DIR__."/domain.txt")){
touch(__DIR__."/domain.txt");
file_put_contents(__DIR__."/domain.txt",$stadrs);
$domain2			= $stadrs;
}else{
$domain2			= file_get_contents(__DIR__."/domain.txt");
if($domain2 == ''){
file_put_contents(__DIR__."/domain.txt",$stadrs);
$domain2			= $stadrs; 
}
}
} 


require __DIR__."/dbconnect.php";
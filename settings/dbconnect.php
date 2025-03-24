<?php if(!defined("SERVER_HOST")){die();}

try {
$db = new PDO("mysql:host=".SERVER_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USERNAME, DB_PASSWORD);
#$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch ( PDOException $e ){
   die("Bir hata oluştu : ".$e->getMessage());
}
# Charset
@$db->query("SET NAMES utf8");
@$db->query("SET NAMES 'UTF8'");
@$db->query("SET character_set_connection = 'UTF8'");
@$db->query("SET character_set_client = 'UTF8'");
@$db->query("SET character_set_results = 'UTF8'");
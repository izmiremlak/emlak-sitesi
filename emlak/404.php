<?php if(!defined("THEME_DIR")){ die("Problem 404"); } 
$dirs = dirname($_SERVER["SCRIPT_NAME"]);
if(substr($dirs,-1) != '/'){
$dirs	= $dirs.'/';
}
include "modules/404.php";
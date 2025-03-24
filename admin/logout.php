<?php include "../functions.php";
if($hesap->id != ""){
AccountLogOut();
}
header("Location:login.php");
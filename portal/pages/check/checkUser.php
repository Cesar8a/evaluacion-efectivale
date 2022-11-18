<?php
include_once("../../../lib/CheckIn.Class.php");
$checkIn = new CheckIn();

$user = $_POST["user"];
$checkEmail = $checkIn->checkUser($user);
if($checkEmail){
	echo 0;
}else{
	echo 1;
}//Fin de else
?>
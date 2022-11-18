<?php
include_once("../../../lib/CheckIn.Class.php");
$checkIn = new CheckIn();

$email = $_POST["email"];
$checkEmail = $checkIn->checkEmail($email);
if($checkEmail){
	echo 0;
}else{
	echo 1;
}//Fin de else
?>
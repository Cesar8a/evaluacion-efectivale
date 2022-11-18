<?php
include_once("../../lib/Session.Class.php");
Session::init();
require_once("../../lib/Login.Class.php");
$login = new Login();

sleep(2);

$user = $_POST["user"];
$password = $_POST["password"];

$seek = $login->sessionUser($user, $password);
if($seek == false){
	echo "error";
}else{
	echo $seek->ID_profiles;
}
?>
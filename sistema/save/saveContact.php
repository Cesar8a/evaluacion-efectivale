<?php

include_once("../../lib/Contact.Class.php");
$contact = new Contact();

sleep(2);

$name = empty($_POST["name"]) ? "" : $_POST["name"];
$lastname = empty($_POST["lastname"]) ? "" : $_POST["lastname"];
$email = empty($_POST["email"]) ? "" : $_POST["email"];
$phone = empty($_POST["phone"]) ? "" : $_POST["phone"];

$error = false;
$errorMsg = "";

$insert = $contact->createContact($name, $lastname, $email, $phone);
if($insert < 0){
	$error = true;
	$errorMsg = $contact->getErrorMsg();
	echo "<h1>ErrorMsg: $errorMsg</h1>";
}else{
	echo "<h1>Su registro fue exitoso.</h1>";
}//Fin de else
?>
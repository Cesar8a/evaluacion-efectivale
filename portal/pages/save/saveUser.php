<?php
include_once("../../../lib/php-mailer/class.phpmailer.php");
include_once("../../../lib/CheckIn.Class.php");
$checkIn = new CheckIn();

sleep(2);

$name = utf8_decode($_POST["name"]);
$firstLastname = utf8_decode($_POST["first_lastname"]);
$secondLastname = utf8_decode($_POST["second_lastname"]);
$email = $_POST["email"];
$area = utf8_decode($_POST["area"]);
$gender = $_POST["gender"];
$phone = $_POST["phone"];
$extension = $_POST["extension"];
$user = $_POST["user"];
$password = $_POST["password"];

if($gender == 1){
	$gender = "Hombre";
}else if($gender == 2){
	$gender = "Mujer";
}

$error = false;
$errorMsg = "";

$insert = $checkIn->addCheckIn($name, $firstLastname, $secondLastname, $email, $area, $gender, $phone, $extension, $user, $password);
if($insert < 0){
	$error = true;
	$errorMsg = $checkIn->getErrorMsg();
	echo "<h1>ErrorMsg: $errorMsg</h1>";
}else{

	$subject = "Registro de usuario";
	$message = "<!DOCTYPE html>
				<html>
				<head>
					<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
				</head>
				<body>
					<div style='background-color:#CCC;'>
						<h3 style='background-color:#DFDFDF; color:#333; font-size: 24px; padding:10px; text-align:center;'>Registro de usuario</h3>
						<table style='border:3px solid #333; margin:auto; padding:10px; width:75%;'>
							<tr>
								<td style='color:#333; font-weight:bold; width:25%;'>Nombre:</td>
								<td style='color:#333; width:75%;'>".$name." ".$firstLastname." ".$secondLastname."</td>
							</tr>
							<tr>
								<td style='color:#333; font-weight:bold; width:25%;'>Usuario:</td>
								<td style='color:#333; width:75%;'>$user</td>
							</tr>
							<tr>
								<td style='color:#333; font-weight:bold; width:25%;'>Password:</td>
								<td style='color:#333; width:75%;'>$password</td>
							</tr>
						</table>
						<p style='background-color:#DFDFDF; color:#333; font-weight:bold; padding:10px; text-align:center;'>
							Para accesar visite <a style='color:#333;' href='http://www.difusion.com.mx/checklist'>www.difusion.com.mx/checklist</a>
						</p>
					</div>
				</body>
				</html>";

	/* Parametros de envio */
	$mail = new PHPMailer(); //Defaults to using php "mail()"
	$mail->IsSMTP(); //Telling the class to use SMTP
	$mail->SMTPAuth = true; //Enable SMTP authentication
	$mail->SetLanguage("es", 'language/'); //V1 **********************
	$mail->SMTPSecure = "tls"; //V1 **********************
	$mail->Host = "smtp.gmail.com"; //SMTP server
	$mail->Port = 587; //Set the SMTP port for the GMAIL server
	$mail->Username = "prueba.portalesdifusion@gmail.com"; //SMTP account username
	$mail->Password = "gdch572!"; //SMTP account password
	$mail->SetFrom("prueba.portalesdifusion@gmail.com", utf8_decode("Grupo Difusión Científica - Checklist")); //Mail and sender name
	$mail->Subject = $subject; //Message subject
	$mail->CharSet = "ISO-8859-1";
	$mail->msgHTML($message);
	$mail->addAddress($email);
	$mail->IsHTML(true); //V1 **********************

	if($mail->send()){
		echo "<h1>Se envió un correo para la confirmación de su registro.</h1>";
	}else{
		echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
		echo "<h1>Error: $mail->ErrorInfo</h1>";
	}

	$mail->clearAddresses(); //Clear all addresses for next loop

	echo "<h1>Su registro fue exitoso.</h1>";

}//Fin de else
?>
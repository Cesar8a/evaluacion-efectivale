<?php
include_once("dbConnection.Class.php");
include_once("php-mailer/class.phpmailer.php");

class SendMail {

	private $error = false;
	private $errorMsg = "";

	const host = "smtp.gmail.com";
	const port = "587";
	const username = "Cuenta de correo";
	const password = "Contraseña de la cuenta";
	const charSet = "ISO-8859-1";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	private function searchEmailUser($_idUser){
		$dbConnection = new dbConnection();
		$email = "";

		$query = "SELECT `email` 
					FROM `users` 
					WHERE `id` = '$_idUser' 
					AND `status` = '1'";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			($row = $dbConnection->fetchRows($result)) != false;
			$email = $row->email;
			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $email;
	}

	private function searchEmailEmployee($_idEmployee){
		$dbConnection = new dbConnection();
		$email = "";

		$query = "SELECT `email`
					FROM `employees`
					WHERE `id` = '$_idEmployee'
					AND `status` = '1'";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			($row = $dbConnection->fetchRows($result)) != false;
			$email = $row->email;
			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $email;
	}

	private function searchEmailList($_kindMail){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT `email` 
					FROM `email_list` 
					WHERE `$_kindMail` = '1' 
					AND `status` = '1'";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			while(($row = $dbConnection->fetchRows($result)) != false){
				array_push($_data, $row->email);
			}
			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

	public function sendMailBook($_titleBook, $_editorialCivilAssociationName, $_projectName, $_book, $_observations, $_deliveryDateCustomer, $_idUser){

		$setFrom = utf8_decode("Maquetación de libro");
		$subject = utf8_decode("Solicitud para la maquetación de libro impreso y/o digital");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del Libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Editorial o Asociaci&oacute;n Civil</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_editorialCivilAssociationName</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Nombre del proyecto</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_projectName</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_book</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Observaciones</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_observations</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Fecha de entrega al cliente</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_deliveryDateCustomer</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		$addAddress = self::searchEmailUser($_idUser);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;
		$mail->msgHTML($msgHTML);
		$mail->addAddress($addAddress);

		if(!$mail->send()){
			echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
			echo "<h1>Error: $mail->ErrorInfo</h1>";
		}

		$mail->clearAddresses(); //Clear all addresses for next loop

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em;'>Correo electr&oacute;nico enviado a: $addAddress</p>";
		$searchEmailList = self::searchEmailList("add_book");
		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		}//Fin de foreach

	}

	public function sendMailBookChangeControl($_idBook, $_priority, $_descriptionChange, $_idUser){

		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);

		$setFrom = utf8_decode("Maquetación de libro");
		$subject = utf8_decode("Solicitud para agregar control de cambios para libro");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Prioridad</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_priority</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Descripci&oacute;n del cambio</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$_descriptionChange</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		$addAddress = self::searchEmailUser($_idUser);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;
		$mail->msgHTML($msgHTML);
		$mail->addAddress($addAddress);

		if(!$mail->send()){
			echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
			echo "<h1>Error: $mail->ErrorInfo</h1>";
		}

		$mail->clearAddresses(); //Clear all addresses for next loop

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em;'>Correo electr&oacute;nico enviado a: $addAddress</p>";
		$searchEmailList = self::searchEmailList("add_book_change_control");
		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		}//Fin de foreach

	}

	public function sendMailBookAssignment($_idBook, $_responsibleLayout){

		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);

		$dataRecoveryEmployees = Books::dataRecoveryEmployees($_responsibleLayout);
		$name = utf8_decode($dataRecoveryEmployees[0]);
		$addAddress = $dataRecoveryEmployees[1];

		$setFrom = utf8_decode("Asignación de libro");
		$subject = utf8_decode("Asignación de libro");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Responsable de la maquetaci&oacute;n</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$name</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;
		$mail->msgHTML($msgHTML);
		$mail->addAddress($addAddress);

		if(!$mail->send()){
			echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
			echo "<h1>Error: $mail->ErrorInfo</h1>";
		}

		$mail->clearAddresses(); //Clear all addresses for next loop

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em;'>Correo electr&oacute;nico enviado a: $addAddress</p>";
		$searchEmailList = self::searchEmailList("add_book_assignment");
		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		}//Fin de foreach

	}

	public function sendMailBookRequestFile($_idBook, $_idStage, $_idUser){

		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);
		$idOwner = utf8_decode($dataRecovery[26]);

		$dataRecoveryStage = Books::dataRecoveryStage($_idStage);
		$nameStage = $dataRecoveryStage[0];

		$setFrom = utf8_decode($nameStage);
		$subject = utf8_decode("Solicitud de archivo de contenido para la maquetación de libro");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Etapa</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$nameStage</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Mensaje</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>Enviar a la brevedad para empezar maquetaci&oacute;n</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		$emailSentTo = "";
		$userEmailList = array();
		$emailUser = self::searchEmailUser($_idUser);
		$emailOwner = self::searchEmailUser($idOwner);
		array_push($userEmailList, $emailUser, $emailOwner);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;

		foreach($userEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}else{
				$emailSentTo .= "<p style='font-size: 1em; margin: 0'>$addAddress</p>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em; font-weight: bold; margin: 0'>Correo electr&oacute;nico enviado a: </p>$emailSentTo";
		$searchEmailList = self::searchEmailList("add_book_request_file");
		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

	}

	public function sendMailBookLoadFile($_idBook, $_idStage, $_idUser){

		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);
		$idEmployee = utf8_decode($dataRecovery[27]);

		$dataRecoveryStage = Books::dataRecoveryStage($_idStage);
		$nameStage = $dataRecoveryStage[0];

		$setFrom = utf8_decode($nameStage);
		$subject = utf8_decode("Archivo de contenido para la maquetación de libro");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Etapa</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$nameStage</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		$emailSentTo = "";
		$userEmailList = array();
		$emailUser = self::searchEmailUser($_idUser);
		$emailEmployee = self::searchEmailEmployee($idEmployee);
		array_push($userEmailList, $emailUser, $emailEmployee);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;

		foreach($userEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}else{
				$emailSentTo .= "<p style='font-size: 1em; margin: 0'>$addAddress</p>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em; font-weight: bold; margin: 0'>Correo electr&oacute;nico enviado a: </p>$emailSentTo";
		$searchEmailList = self::searchEmailList("add_book_load_file");
		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

	}

	/* Stage Dummy */
	public function sendMailBookDummy($_idBook, $_idUser){
		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);
		$idEmployee = utf8_decode($dataRecovery[27]);

		$setFrom = utf8_decode("Actualización de Etapa");
		$subject = utf8_decode("Revisión de libro terminada");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
								<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
								</tr>
								<tr>
									<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Etapa</td>
									<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>Dummy</td>
								</tr>
							</table>
						</div>
					</body>
					</html>";

		$emailSentTo = "";
		$userEmailList = array();
		$emailUser = self::searchEmailUser($_idUser);
		$emailEmployee = self::searchEmailEmployee($idEmployee);
		array_push($userEmailList, $emailUser, $emailEmployee);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;

		foreach($userEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}else{
				$emailSentTo .= "<p style='font-size: 1em; margin: 0'>$addAddress</p>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em; font-weight: bold; margin: 0'>Correo electr&oacute;nico enviado a: </p>$emailSentTo";
		$searchEmailList = self::searchEmailList("add_book_dummy");

		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

	}

	/* Stage Pay Waiting */
	public function sendMailBookPayWaiting($_idBook, $_idUser){
		$dataRecovery = Books::dataRecovery($_idBook);
		$titleBook = utf8_decode($dataRecovery[5]);
		$idEmployee = utf8_decode($dataRecovery[27]);

		$setFrom = utf8_decode("Actualización de Etapa");
		$subject = utf8_decode("Revisión de libro terminada");
		$msgHTML = "<!DOCTYPE html>
					<html>
					<head>
						<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
					</head>
					<body>
						<div style='background-color: #8FB3D2; margin: auto; padding: 5%; width: 75%;'>
							<table style='border: 2px solid #064C70; padding: 1%; width: 100%;'>
							<caption style='color: #064C70; font-size: 1.5em; font-weight: bold; padding-bottom: 10px;'>$subject</caption>
							<tr>
								<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>T&iacute;tulo del libro</td>
								<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>$titleBook</td>
							</tr>
							<tr>
								<td style='background-color: #E1EEF4; color: #064C70; font-size: 1.125em; font-weight: bold; padding: 10px; width: 30%;'>Etapa</td>
								<td style='background-color: #E1EEF4; font-size: 1.125em; padding: 10px; width: 70%;'>En Espera de Pago</td>
							</tr>
							</table>
						</div>
					</body>
					</html>";

		$emailSentTo = "";
		$userEmailList = array();
		$emailUser = self::searchEmailUser($_idUser);
		$emailEmployee = self::searchEmailEmployee($idEmployee);
		array_push($userEmailList, $emailUser, $emailEmployee);

		/* Parametros de envio */
		$mail = new PHPMailer(); //Defaults to using php "mail()"
		$mail->IsSMTP(); //Telling the class to use SMTP
		$mail->SMTPAuth = true; //Enable SMTP authentication
		$mail->SMTPSecure = "tls"; //V1 **********************
		$mail->Host = SendMail::host; //SMTP server
		$mail->Port = SendMail::port; //Set the SMTP port for the GMAIL server
		$mail->Username = SendMail::username; //SMTP account username
		$mail->Password = SendMail::password; //SMTP account password
		$mail->SetFrom(SendMail::username, $setFrom); //Mail and sender name
		$mail->Subject = $subject; //Message subject
		$mail->CharSet = SendMail::charSet;

		foreach($userEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje a: $addAddress</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}else{
				$emailSentTo .= "<p style='font-size: 1em; margin: 0'>$addAddress</p>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

		/* Notificacion para administradores */
		$msgHTML .= "<hr><p style='font-size: 1.125em; font-weight: bold; margin: 0'>Correo electr&oacute;nico enviado a: </p>$emailSentTo";
		$searchEmailList = self::searchEmailList("add_book_pay_waiting");

		foreach($searchEmailList as $addAddress){
			$mail->msgHTML($msgHTML);
			$mail->addAddress($addAddress);

			if(!$mail->send()){
				echo "<h1>Ocurrió un problema al enviar el mensaje.</h1>";
				echo "<h1>Error: $mail->ErrorInfo</h1>";
			}

			$mail->clearAddresses(); //Clear all addresses for next loop

		} //Fin de foreach

	}

}
?>
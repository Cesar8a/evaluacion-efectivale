<?php
require_once("class.phpmailer.php");
include_once("../../../lib/db.php");
$db = new DB;

$typeAlert = "SummaryCommission";
$id = 2;

$query = "SELECT id, email_subject, chamber, commission, date, summary, twitter FROM summary_commission WHERE id = '$id'";
$result = $db->exeQuery($query);
$row = $db->fetchRows($result);

$emailSubject = $row->email_subject;
echo $emailSubject."<br />";
$chamber = $row->chamber;
echo $chamber."<br />";
$commission = $row->commission;
echo $commission."<br />";
$date = $row->date;
$summary = $row->summary;
$twitter = $row->twitter;

if($chamber == 1){
	$title = "REPORTE DE COMISI&Oacute;N C&Aacute;MARA DE DIPUTADOS";
	$chamber = "Diputados";
}else if($chamber == 2){
	$title = "REPORTE DE COMISI&Oacute;N C&Aacute;MARA DE SENADORES";
	$chamber = "Senadores";
}

$message = "
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv='content-type' content='text/html; charset=ISO-8859-1'>
		<style>
		.tableAlert a{ color: #333; font-weight: bold; }
		</style>	
	</head>
	<body>

		<table class='tableAlert' style='font-family: trebuchet ms, verdana, arial; border-collapse: collapse; width: 850px;'>
			<caption style='color: #45916B; font-size: 18px; font-weight: bold; padding: 5px; text-align: center;'>$title</caption>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td style='background: #FFF; color: #45916B; font-size: 16px; font-weight: bold; padding: 5px; text-align: left; width: 20%;'>C&aacute;mara</td>
				<td style='background: #FFF; color: #333; font-size: 12px; font-weight: bold; padding: 5px; text-align: justify; width: 80%;'>$chamber</td>
			</tr>
			<tr>
				<td colspan='2'><hr style='	border: 1px solid #45916B; margin: 5px 0;' /></td>
			</tr>
			<tr>
				<td style='background: #FFF; color: #45916B; font-size: 16px; font-weight: bold; padding: 5px; text-align: left; width: 20%;'>Comisi&oacute;n</td>
				<td style='background: #FFF; color: #333; font-size: 12px; font-weight: bold; padding: 5px; text-align: justify; width: 80%;'>$commission</td>
			</tr>
			<tr>
				<td colspan='2'><hr style='	border: 1px solid #45916B; margin: 5px 0;' /></td>
			</tr>
			<tr>
				<td style='background: #FFF; color: #45916B; font-size: 16px; font-weight: bold; padding: 5px; text-align: left; width: 20%;'>Fecha</td>
				<td style='background: #FFF; color: #333; font-size: 12px; font-weight: bold; padding: 5px; text-align: justify; width: 80%;'>$date</td>
			</tr>
			<tr>
				<td colspan='2'><hr style='	border: 1px solid #45916B; margin: 5px 0;' /></td>
			</tr>
			<tr>
				<td style='background: #FFF; color: #45916B; font-size: 16px; font-weight: bold; padding: 5px; text-align: left; width: 20%;'>Resumen</td>
				<td style='background: #FFF; color: #333; font-size: 12px; font-weight: bold; padding: 5px; text-align: justify; width: 80%;'>$summary</td>
			</tr>
			<tr>
				<td colspan='2'><hr style='	border: 1px solid #45916B; margin: 5px 0;' /></td>
			</tr>
			<tr>
				<td style='background: #FFF; color: #45916B; font-size: 16px; font-weight: bold; padding: 5px; text-align: left; width: 20%;'>Twitter</td>
				<td style='background: #FFF; color: #333; font-size: 12px; font-weight: bold; padding: 5px; text-align: justify; width: 80%;'>$twitter</td>
			</tr>
			<tr>
				<td colspan='2'>
					<img src='http://lgxdesarrollo.com/desarrollo/SadTools/admin/images/Plecas_color.png' width='100%' />
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<img src='http://lgxdesarrollo.com/desarrollo/SadTools/admin/images/LOGO-LEGIX.png' align='right' />
				</td>
			</tr>
			<tr>
				<td colspan='2' style='	background: #FFF; color: #999; font-size: 10px; font-weight: normal; padding: 5px; text-align: left;'>
					Si requiere mayor informaci&oacute;n de este asunto contactar a Marcela Carrillo marcela@legix.com.mx
				</td>
			</tr>
		</table>
	
	</body>
	</html>";

$mail = new PHPMailer(); //Defaults to using php "mail()".
$mail->IsSMTP(); //Telling the class to use SMTP
$mail->Host = "smtp.uservers.net"; //SMTP server
//$mail->SMTPDebug  = 2; //Enables SMTP debug information (for testing) 1 = errors and messages 2 = messages only
$mail->SMTPAuth = true; //Enable SMTP authentication
$mail->Port = 587; //Set the SMTP port for the GMAIL server
$mail->Username = "cesar@legix.com.mx"; //SMTP account username
$mail->Password = "go2work1"; //SMTP account password
$mail->SetFrom("alerta@legix.com.mx", "Alertas Name"); // Correo y Nombre del Remitente
$mail->AddAddress("cesar8a.upiicsa@gmail.com","Cesar Ochoa Aguirre"); // Agrega correo destinatario
$mail->Subject = $emailSubject; // Asunto del mensaje
$mail->CharSet = "ISO-8859-1";
$mail->MsgHTML($message);

if(!$mail->Send()){
	//Si fallo el envio.
	//$query = "INSERT INTO $tblestadisticas (id_tarjeta, horario, status) VALUES ('$idtarjeta[$i]', '$fecha', 'No Enviado')";
	//$result = mysql_query($query);
	echo "Si fallo el envio";
}else{
	//Enviado correctamente.
	//$query = "INSERT INTO $tblestadisticas (id_tarjeta, horario, status) VALUES ('$idtarjeta[$i]', '$fecha', 'Enviado')";
	//$result = mysql_query($query);
	echo "Enviado correctamente";
}
					
?>
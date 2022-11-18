<?php
include_once("../lib/Sniffer.Class.php");
$sniffer = new Sniffer();
$user = utf8_decode("ANÓNIMO");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Registro</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/jquery-numeric.min.js"></script>
	<script src="js/jquery-checkIn.js"></script>
</head>
<body>

	<header>
		<div class="row">
			<div class="cell">
				<h1>Registro</h1>
			</div>
		</div>
	</header>

	<!-- Registro -->
	<div class="checkIn">
		<form id="frmCheckIn" name="frmCheckIn">
			<img src="img/checkin.png" />
			<div>
				<input type="text" id="name" name="name" placeholder="Nombre(s)" required />
				<input type="text" id="firts_lastname" name="first_lastname" placeholder="Apellido Paterno" required />
				<input type="text" id="second_lastname" name="second_lastname" placeholder="Apellido Materno" required />
			</div>
			<div>
				<input type="email" id="email" name="email" placeholder="Correo Electrónico" required />
				<input type="text" id="area" name="area" placeholder="Área" required />
			</div>
			<div>
				<select id="gender" name="gender" required>
					<option value="">Género</option>
					<option value="1">Hombre</option>
					<option value="2">Mujer</option>
				</select>
			</div>
			<div>
				<input type="text" id="phone" name="phone" placeholder="Teléfono" required />
				<input type="text" id="extension" name="extension" placeholder="Extensión" required />
			</div>
			<div>
				<input type="text" id="user" name="user" placeholder="Nombre de Usuario" required />
				<input type="password" id="password" name="password" placeholder="Password" required />
			</div>
			<div>
				<input type="hidden" id="checkEmail" name="checkEmail" value="0" />
				<input type="hidden" id="checkUser" name="checkUser" value="0" />
				<input type="submit" id="btnCheckIn" name="btnCheckIn" value="Registrarme" />
			</div>
			<div>
				<a href="index.php">Inicio de Sesión</a>
			</div>
			<div class="loading">
				<img src="img/loading.gif" />
			</div>
			<div class="message"><h1>Usuario y/o Password Incorrecto.</h1></div>
		</form>
	</div>

	<footer>
		<h3>Todos los derechos reservados.</h3>
	</footer>

</body>
</html>
<?php
$insert = $sniffer->addSniffer("registro.php", "REGISTRO", $user);
$sniffer = null;
?>
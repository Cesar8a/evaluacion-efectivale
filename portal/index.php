<?php
include_once("../lib/Session.Class.php");
Session::init();
Session::destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Inicio</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/jquery-login.js"></script>
</head>
<body>

	<header>
		<div class="row">
			<div class="cell">
				<h1>Inicio de Sesión</h1>
			</div>
		</div>
	</header>

	<!-- Iniciar sesión -->
	<div class="login">
		<form id="frmLogin" name="frmLogin">
			<img src="img/login.png" />
			<input type="text" id="user" name="user" placeholder="Usuario" required />
			<input type="password" id="password" name="password" placeholder="Password" required />
			<input type="submit" id="btnLogin" name="btnLogin" value="Acceder" />
			<a href="registro.php">Registro</a>
			<div class="loading">
				<img src="img/loading.gif" />
			</div>
			<div class="message"></div>
		</form>
	</div>

	<footer>
		<h3>Todos los derechos reservados.</h3>
	</footer>

</body>
</html>

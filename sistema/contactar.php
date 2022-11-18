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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/jquery-functionsContactar.js"></script>
</head>
<body>

	<div class="container p-3 my-3 bg-dark text-white">
		<header class="text-center">
			<h1>Contactar</h1>
		</header>

		<!-- Contactar -->
		<form id="frmContactar" name="frmContactar">
			<div class="form-group">
				<label for="name">Nombre:</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
			</div>
			<div class="form-group">
				<label for="lastname">Apellido:</label>
				<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellido" required>
			</div>
			<div class="form-group">
				<label for="email">Correo electrónico:</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
			</div>
			<div class="form-group">
				<label for="email">Teléfono:</label>
    			<input type="tel" class="form-control" id="phone" name="phone" placeholder="Teléfono">
			</div>
			<div class="form-group text-center">
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
			<div class="loading text-center">
				<img src="img/loading.gif" />
			</div>
			<div class="message h1 text-center bg-info p-3"></div>
		</form>
		
		<footer class="text-center">
			<h3>Todos los derechos reservados.</h3>
		</footer>

	</div>

</body>
</html>
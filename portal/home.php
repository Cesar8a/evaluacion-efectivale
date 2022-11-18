<?php
include_once("../lib/Session.Class.php");
Session::init();

if(!Session::sessionUser()){
	header("Location: index.php");
}else{

	include_once("../lib/Access.Class.php");
	$access = new Access();
	include_once("../lib/Menus.Class.php");
	$menus = new Menus();

	$idUser = $_SESSION["sessionUser"]->ID_users;
	$fullName = utf8_encode($_SESSION["sessionUser"]->full_name);
	$idProfile = $_SESSION["sessionUser"]->ID_profiles;

	$searchAccess = $access->searchAccess($idProfile);
	$readMenus = $menus->readMenus();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Home</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/home.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.11.4/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-dataTables-1.10.13/jquery-dataTables.css" />
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script src="js/jquery-dataTables-1.10.13/jquery-dataTables.min.js"></script>
	<script src="js/jquery-functionsMenus.js"></script>
	<script src="js/jquery-functionsPopup.js"></script>
	<script src="js/jquery-functionsDataTables.js"></script>
</head>
<body>

	<header>
		<div class="row">
			<div class="cell">
				<h1>Evaluación de efectivale</h1>
			</div>
		</div>
	</header>

	<div class="user">
		<div class="row">
			<div class="left">
				<label>Bienvenido(a): <a class="add" href="javascript:void(0);" onClick="popupShow('pages/add/addUsers.php');"><?=$fullName;?></a></label>
			</div>
			<div class="right">
				<label><a href="pages/logout.php">Cerrar Sesión</a></label>
			</div>
		</div>
	</div>

	<div class="menu"></div>

	<div class="content">
		<div class="entry">
			<?php
			if(in_array(2, $searchAccess)){
			?>
				<a class="add" href="javascript:void(0);" onClick="popupShow('pages/add/addMenus.php');">Agregar Menús</a>
			<?php
			}
			?>
		</div>

		<?php
		if(in_array(1, $searchAccess)){
		?>
			<table id="dataGrid" class="dataGrid">
				<caption>Proyectos</caption>
				<thead>
					<tr>
						<th>#</th>
						<th>ID menú</th>
						<th>Nombre del menú</th>
						<th>Menu padre</th>
						<th>Estado</th>
						<th>Fecha de creación</th>
						<th>Hora de creación</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($readMenus as $key){
					?>
					<tr>
						<td></td>
						<td><?=$key[0];?></td>
						<td><?=$key[1];?></td>
						<td><?=$key[2];?></td>
						<td><?=$key[4];?></td>
						<td><?=$key[5];?></td>
						<td><?=$key[6];?></td>
						<td>
							<?php
							if(in_array(3, $searchAccess)){
							?>
								<a href="javascript:void(0);" onClick="popupShow('pages/add/addMenus.php?ID_Menus=<?=$key[0];?>');">
									<img alt="Editar" src="img/icon_edit.png" title="Editar" />
								</a>
							<?php
							}
							if(in_array(4, $searchAccess)){
							?>
								<a href="javascript:void(0);" onclick="deleteMenus('<?=$key[0];?>');">
									<img alt="Eliminar" src="img/icon_remove.png" title="Eliminar" />
								</a>
							<?php
							}
							?>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th>#</th>
						<th>ID menú</th>
						<th>Nombre del menú</th>
						<th>Menu padre</th>
						<th>Estado</th>
						<th>Fecha de creación</th>
						<th>Hora de creación</th>
						<th>Acciones</th>
					</tr>
				</tfoot>
			</table>
		<?php
		}
		?>
	</div>

	<footer>
		<h3>Todos los derechos reservados.</h3>
	</footer>

</body>
</html>
<?php
$access = null;
$menus = null;
} //Fin de else
?>
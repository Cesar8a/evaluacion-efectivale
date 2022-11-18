<?php
include_once("../../../lib/Session.Class.php");
Session::init();

if(!Session::sessionUser()){
	header("Location: ../../index.php");
}else{

include_once("../../../lib/CheckIn.Class.php");
$checkIn = new CheckIn();

$idUser = $_SESSION["sessionUser"]->ID_users;

if(!empty($idUser)){
	$mode = "update";
	$readUsersById = $checkIn->readUsersById($idUser);

	$name = $readUsersById[0];
	$lastname1 = $readUsersById[1];
	$lastname2 = $readUsersById[2];
	$email = $readUsersById[3];
	$area = $readUsersById[4];
	$gender = $readUsersById[5];
	$phone = $readUsersById[6];
	$extension = $readUsersById[7];
	$user = $readUsersById[8];
	$password = $readUsersById[9];
	$ID_profiles = $readUsersById[10];
}
?>

<script src="js/jquery-numeric.min.js"></script>
<script src="js/jquery-checkIn.js"></script>

<!-- Actualizar usuarios -->
<div class="divForm">
	<div class="close">
		<a href="javascript:void(0);" onClick="popupHide();">Cerrar</a>
	</div>
	<h1>Actualizar usuarios</h1>
	<form id="frmCheckIn" name="frmCheckIn">
		<img src="img/checkin.png" />
		<div>
			<input type="text" id="name" name="name" placeholder="Nombre(s)" value="<?=$name;?>" required />
			<input type="text" id="lastname1" name="lastname1" placeholder="Apellido Paterno" value="<?=$lastname1;?>" required />
			<input type="text" id="lastname2" name="lastname2" placeholder="Apellido Materno" value="<?=$lastname2;?>" required />
		</div>
		<div>
			<input type="email" id="email" name="email" placeholder="Correo Electrónico" value="<?=$email;?>" required />
			<input type="text" id="area" name="area" placeholder="Área" value="<?=$area;?>" required />
		</div>
		<div>
			<select id="gender" name="gender" required>
				<option value="">Género</option>
				<option value="1" <?=$selected = ($gender == "Hombre") ? "selected" : "";?>>Hombre</option>
				<option value="2" <?=$selected = ($gender == "Mujer") ? "selected" : "";?>>Mujer</option>
			</select>
		</div>
		<div>
			<input type="text" id="phone" name="phone" placeholder="Teléfono" value="<?=$phone;?>" required />
			<input type="text" id="extension" name="extension" placeholder="Extensión" value="<?=$extension;?>" required />
		</div>
		<div>
			<input type="text" id="user" name="user" placeholder="Nombre de Usuario" value="<?=$user;?>" required disabled />
			<input type="password" id="password" name="password" placeholder="Password" required />
		</div>
		<div>
			<select id="profile" name="profile" required disabled>
				<option value="">Perfil</option>
				<option value="1" <?=$selected = ($ID_profiles == 1) ? "selected" : "";?>>Administrador</option>
				<option value="2" <?=$selected = ($ID_profiles == 2) ? "selected" : "";?>>Usuario</option>
			</select>
		</div>
		<div>
			<input type="hidden" id="checkEmail" name="checkEmail" value="0" />
			<input type="hidden" id="checkUser" name="checkUser" value="0" />
			<input type="hidden" id="idUser" name="idUser" value="<?php echo $idUser; ?>" />
			<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
			<input type="submit" id="btnCheckIn" name="btnCheckIn" value="Actualizar datos" />
		</div>
		<div>
			<a href="index.php">Inicio de Sesión</a>
		</div>
		<div class="loading">
			<img src="img/loading.gif" />
		</div>
		<div class="message"></div>
	</form>
</div>

<?php
$menus = null;
} //Fin de else
?>
<?php
include_once("../../../lib/Session.Class.php");
Session::init();

if(!Session::sessionUser()){
	header("Location: ../../index.php");
}else{

include_once("../../../lib/Menus.Class.php");
$menus = new Menus();

$title = "Agregar Menús";
$mode = "insert";
$idUser = $_SESSION["sessionUser"]->ID_users;
$menuName = '';
$menuDescription = '';
$menuStatus = 'active';

$ID_Menus = empty($_GET["ID_Menus"]) ? "" : $_GET["ID_Menus"];
if(!empty($ID_Menus)){
	$title = "Actualizar Menús";
	$mode = "update";
	$readMenusById = $menus->readMenusById($ID_Menus);	
	$menuName = $readMenusById[0];
	$menuNameParent = $readMenusById[1];
	$menuDescription = $readMenusById[2];
	$menuStatus = $readMenusById[3];
}
?>

<script src="js/jquery-functionsMenus.js"></script>

<!-- Agregar menús -->
<div class="divForm">
	<div class="close">
		<a href="javascript:void(0);" onClick="popupHide();">Cerrar</a>
	</div>
	<h1><?=$title;?></h1>
	<form id="frmMenus" name="frmMenus">
		<fieldset>
			<legend>Datos solicitados</legend>

			<label for="menuName">Nombre del menú:</label>
			<input type="text" id="menuName" name="menuName" placeholder="Nombre del menú" value="<?=$menuName; ?>" required />

			<label for="menuNameParent">Nombre del menú padre:</label>
			<select id="menuNameParent" name="menuNameParent">
				<option value="">Seleccione una opción</option>
				<?php
				foreach ($menus->readMenusParent() as $data) {
					$selected = ($data[1] == $menuNameParent) ? "selected" : "";
				?>
					<option value="<?=$data[1];?>"<?=$selected;?>><?=$data[1];?></option>
				<?php
				}
				?>
			</select>

			<label for="menuDescription">Descripción del menú:</label>
			<input type="text" id="menuDescription" name="menuDescription" placeholder="Descripción del menú" value="<?=$menuDescription; ?>" required />

			<label for="menuStatus">Estado del menú</label>
			<input id="menuStatus" type='radio' name='menuStatus' value='active' required <?php if($menuStatus == "active"){ echo "checked"; } ?> />Activo /  
			<input id="menuStatus" type='radio' name='menuStatus' value='inactive' required <?php if($menuStatus == "inactive"){ echo "checked"; } ?> />Inactivo
		</fieldset>
		<div>
			<input type="hidden" id="idUser" name="idUser" value="<?php echo $idUser; ?>" />
			<input type="hidden" id="idMenus" name="idMenus" value="<?php echo $ID_Menus; ?>" />
			<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
			<input type="submit" id="btnMenus" name="btnMenus" value="<?=$title;?>" />
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
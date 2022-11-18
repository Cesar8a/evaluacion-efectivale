<?php
include_once("../../../lib/Session.Class.php");
Session::init();

if(!Session::sessionUser()){
	echo "error";
}else{

	include_once("../../../lib/Menus.Class.php");
	$menus = new Menus();

	$menuName = empty($_POST["menuName"]) ? "" : $_POST["menuName"];
	$menuNameParent = empty($_POST["menuNameParent"]) ? "" : $_POST["menuNameParent"];
	$menuDescription = empty($_POST["menuDescription"]) ? "" : $_POST["menuDescription"];
	$menuStatus = empty($_POST["menuStatus"]) ? "" : $_POST["menuStatus"];
	$idUser = empty($_POST["idUser"]) ? "" : $_POST["idUser"];
	$idMenus = empty($_POST["idMenus"]) ? "" : $_POST["idMenus"];
	$mode = empty($_POST["mode"]) ? "" : $_POST["mode"];

	$error = false;
	$errorMsg = "";

	if($mode == "insert"){

		$createMenus = $menus->createMenus($menuName, $menuNameParent, $menuDescription, $menuStatus, $idUser);
		if($createMenus < 0){
			$error = true;
			$errorMsg = $menus->getErrorMsg();
			echo "<h1>ErrorMsg: $errorMsg</h1>";
		}else{
			echo "<h1>Menú almacenado con éxito</h1>";
		}//Fin de else

	}elseif($mode == "update"){

		$updateMenus = $menus->updateMenus($menuName, $menuNameParent, $menuDescription, $menuStatus, $idUser, $idMenus);
		if(!$updateMenus){
			$error = true;
			$errorMsg = $menus->getErrorMsg();
			echo "<h1>ErrorMsg: $errorMsg</h1>";
		}else{
			echo "<h1>Menú actualizado con éxito</h1>";
		}//Fin de else

	}elseif($mode == "delete"){

		$deleteMenus = $menus->deleteMenus($idMenus);
		if(!$deleteMenus){
			$error = true;
			$errorMsg = $menus->getErrorMsg();
			echo "<h1>ErrorMsg: $errorMsg</h1>";
		}else{
			echo "Menú eliminado con éxito";
		}//Fin de else

	}

	$menus = null;

} //Fin de else
?>
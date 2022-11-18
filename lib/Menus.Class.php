<?php
include_once("dbConnection.Class.php");

class Menus {

	private $error = false;
	private $errorMsg = "";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	public function readMenus(){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT * FROM `menus` ORDER BY `menus`.`ID_menus` DESC";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			$i = 0;
			while(($row = $dbConnection->fetchRows($result)) != false){
				$_data[$i] = array(
					$row->ID_menus,
					$row->Name,
					$row->Name_parent,
					$row->Description,
					$row->Status,
					$row->Date,
					$row->Time
				);
				$i++;
			}

			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

	public function createMenus($_name, $_nameParent, $_description, $_status, $_idUser){

		$dbConnection = new dbConnection();
		$insert = false;

		$query = "INSERT INTO `menus`(
					`Name`, 
					`Name_parent`, 
					`Description`,
					`Status`,
					`ID_users`
				) VALUES(
					'$_name',
					'$_nameParent',
					'$_description',
					'$_status',
					'$_idUser'
				)";

		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$insert = true;
		}

		$dbConnection = null;
		return $insert;
	}

	public function updateMenus($_name, $_nameParent, $_description, $_status, $_idUsers, $_idMenus){
		$dbConnection = new dbConnection();
		$update = false;

		$query = "UPDATE `menus`
					SET 
						`Name` = '$_name', 
						`Name_parent` = '$_nameParent', 
						`Description` = '$_description', 
						`Status` = '$_status',
						`ID_users` = '$_idUsers'
					WHERE `ID_menus` = '$_idMenus'
					LIMIT 1";

		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$update = true;
		}

		$dbConnection = null;
		return $update;
	}

	public function deleteMenus($_idMenus){
		$dbConnection = new dbConnection();
		$delete = false;

		$query = "DELETE FROM `menus` WHERE `menus`.`ID_menus` = $_idMenus";

		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$delete = true;
		}

		$dbConnection = null;
		return $delete;
	}

	public function readMenusParent(){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT * FROM `menus` 
					WHERE `menus`.`Name_parent` = '' 
					AND `menus`.`Status` = 'active'";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			$i = 0;
			while(($row = $dbConnection->fetchRows($result)) != false){
				$_data[$i] = array(
					$row->ID_menus,
					$row->Name
				);
				$i++;
			}

			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

	public function readMenusById($_ID_menus){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT * FROM `menus` WHERE `menus`.`ID_menus` = $_ID_menus";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			while(($row = $dbConnection->fetchRows($result)) != false){
				array_push(
					$_data,
					$row->Name,
					$row->Name_parent,
					$row->Description,
					$row->Status,
				);
			}

			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

}
?>
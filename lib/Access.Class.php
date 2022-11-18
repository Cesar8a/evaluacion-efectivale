<?php
include_once("dbConnection.Class.php");

class Access {

	private $error = false;
	private $errorMsg = "";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	public function searchAccess($_idProfile){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT `ID_access` FROM `profiles_access` 
					WHERE `profiles_access`.`ID_profiles` = $_idProfile 
					AND `profiles_access`.`Status` = 'Active'";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			while(($row = $dbConnection->fetchRows($result)) != false){
				array_push($_data, $row->ID_access);
			}

			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

}
?>
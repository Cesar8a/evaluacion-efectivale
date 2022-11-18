<?php
include_once("dbConnection.Class.php");

class Login {

	private $error = false;
	private $errorMsg = "";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	public function sessionUser($_user, $_password){
		$dbConnection = new dbConnection();
		$sessionUser = false;

		$query = "SELECT 
					`ID_users`, 
					CONCAT(`name`, ' ', `lastname1`, ' ', `lastname2`) AS `full_name`, 
					`email`, 
					`extension`, 
					`user`, 
					`ID_profiles` 
				FROM `users` 
				WHERE `users`.`user` = '$_user' 
				AND `users`.`password` = '$_password' 
				AND `users`.`status` = 'active';";

		$result = $dbConnection->exeQuery($query);
		$row = $dbConnection->fetchRows($result);

		if($row){
			$_SESSION["sessionUser"] = $row;
			$sessionUser = $_SESSION["sessionUser"];
		}

		$dbConnection = null;
		return $sessionUser;
	}
}
?>
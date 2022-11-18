<?php
include_once("dbConnection.Class.php");

class CheckIn {

	private $error = false;
	private $errorMsg = "";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	public function addCheckIn($_name, $_lastname1, $_lastname2, $_email, $_area, $_gender, $_phone, $_extension, $_user, $_password, $_profile, $_status = "1"){
		$dbConnection = new dbConnection();
		$lastID = -1;

		$query = "INSERT INTO users (
						`name`, 
						`lastname1`, 
						`lastname2`, 
						`email`, 
						`area`, 
						`gender`, 
						`phone`, 
						`extension`, 
						`user`, 
						`password`, 
						`ID_profiles`, 
						`status`
					) VALUES(
						'$_name',
						'$_lastname1',
						'$_lastname2',
						'$_email',
						'$_area',
						'$_gender',
						'$_phone',
						'$_extension',
						'$_user',
						'$_password',
						'$_profile',
						'$_status'
					)";
	
		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$query = "SELECT LAST_INSERT_ID() lastid";
			$result = $dbConnection->exeQuery($query);
			$row = $dbConnection->fetchRows($result);
				
			if($row){
				$lastID = $row->lastid;
			}else{
				$dbConnection->closeResult($result);
				$this->setError("No se devolvió un lastID");
			}
			$dbConnection->closeResult($result);
		}
		$dbConnection = null;
		return $lastID;
	}

	function checkEmail($_email){
		$dbConnection = new dbConnection();
		$available = true;

		$query = "SELECT email FROM users WHERE email = '$_email'";
		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			$available = false;
		}
		$dbConnection->closeResult($result);
		return $available;
	}

	function checkUser($_user){
		$dbConnection = new dbConnection();
		$available = true;
	
		$query = "SELECT user FROM users WHERE user = '$_user'";
		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);
	
		if($numRows > 0){
			$available = false;
		}
		$dbConnection->closeResult($result);
		return $available;
	}

	public function readUsersById($_ID_users){
		$dbConnection = new dbConnection();
		$_data = array();

		$query = "SELECT * FROM `users` WHERE `users`.`ID_users` = $_ID_users";

		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);

		if($numRows > 0){
			while(($row = $dbConnection->fetchRows($result)) != false){
				array_push(
					$_data,
					$row->name,
					$row->lastname1,
					$row->lastname2,
					$row->email,
					$row->area,
					$row->gender,
					$row->phone,
					$row->extension,
					$row->user,
					$row->password,
					$row->ID_profiles,
				);
			}

			$dbConnection->closeResult($result);
		}

		$dbConnection = null;
		return $_data;
	}

	public function updateCheckIn($_name, $_lastname1, $_lastname2, $_email, $_area, $_gender, $_phone, $_extension, $_password, $_idUser){
		$dbConnection = new dbConnection();
		$update = false;

		$query = "UPDATE `users`
					SET 
						`name` = '$_name', 
						`lastname1` = '$_lastname1', 
						`lastname2` = '$_lastname2', 
						`email` = '$_email', 
						`area` = '$_area',
						`gender` = '$_gender',
						`phone` = '$_phone',
						`extension` = '$_extension',
						`password` = '$_password'
					WHERE `ID_users` = '$_idUser'
					LIMIT 1";

		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$update = true;
		}

		$dbConnection = null;
		return $update;
	}

}
?>
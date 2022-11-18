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

	public function addCheckIn($_name, $_firstLastname, $_secondLastname, $_email, $_area, $_gender, $_phone, $_extension, $_user, $_password, $_idProfile = "4", $_status = "1"){
		$dbConnection = new dbConnection();
		$lastID = -1;

		$query = "INSERT INTO users (
						`name`, 
						`first_lastname`, 
						`second_lastname`, 
						`email`, 
						`area`, 
						`gender`, 
						`phone`, 
						`extension`, 
						`user`, 
						`password`, 
						`id_profile`, 
						`status`
					) VALUES(
						'$_name',
						'$_firstLastname',
						'$_secondLastname',
						'$_email',
						'$_area',
						'$_gender',
						'$_phone',
						'$_extension',
						'$_user',
						'$_password',
						'$_idProfile',
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

	/*
	function dataRecovery($_email){
		$dbConnection = new dbConnection();
		$recoverData = array();
	
		$query = "SELECT user, password FROM users WHERE email = '$_email'";
		$result = $dbConnection->exeQuery($query);
		$numRows = $dbConnection->getNumRows($result);
	
		if($numRows > 0){
			$row = $dbConnection->fetchRows($result);
			$recoverData = array(utf8_encode($row->usuario), $row->password);
		}
		$dbConnection->closeResult($result);
		return $recoverData;
	}
	*/
}
?>
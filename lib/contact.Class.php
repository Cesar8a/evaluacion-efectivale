<?php
include_once("dbConnection.Class.php");

class Contact {

	private $error = false;
	private $errorMsg = "";

	public function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	public function getErrorMsg(){
		return $this->errorMsg;
	}

	public function createContact($_name, $_lastname, $_email, $_phone){

		$dbConnection = new dbConnection();
		$insert = false;

		$query = "INSERT INTO `contact`(
					`Name`, 
					`Lastname`, 
					`Email`,
					`Phone`
				) VALUES(
					'$_name',
					'$_lastname',
					'$_email',
					'$_phone'
				)";

		if(!$dbConnection->exeQuery($query)){
			$this->setError($dbConnection->getLastError());
		}else{
			$insert = true;
		}

		$dbConnection = null;
		return $insert;
	}

}
?>
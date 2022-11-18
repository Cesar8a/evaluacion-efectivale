<?php
include_once("dbConnection.Class.php");

class Sniffer {

	private $error = false;
	private $errorMsg = "";

	function setError($_msg){
		$this->error = false;
		$this->errorMsg = $_msg;
	}

	function getErrorMsg(){
		return $this->errorMsg;
	}

	function addSniffer($_nameUser, $_user, $_section, $_idResource = 0){
		$dbConnection = new dbConnection();
		$lastID = -1;
	
		$query = "INSERT INTO sniffer(name, user, section, id_resource) VALUES(
					'$_nameUser',
					'$_user',
					'$_section',
					'$_idResource')";
	
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

}
?>
<?php

class dbConnection {

	private $connection = null;

	function dbConn(){

		$servidor = "localhost";
		$usuario = "root";
		$password = "";
		$db = "evaluacion-efectivale";

		//Create connection
		$this->connection = mysqli_connect($servidor, $usuario, $password, $db);
		//Check connection
		if(mysqli_connect_errno($this->connection)){
			echo "<h2>Error en la conexi&oacute;n MySQL.</h2><br />".mysqli_connect_error();
		}
	}

	function __construct(){
		$this->dbConn();
	}

	function __destruct(){
		if(isset($this->connection)){
			//mysqli_close($this->connect);
			$this->connection->close();
		}
		//Destruye una variable especificada.
		unset($this->connection);
	}

	function exeQuery($query){
		return $this->connection->query($query);
	}

	function getLastError(){
		return $this->connection->error;
	}

	function fetchRows($result){
		return $result->fetch_object();
	}

	function closeResult($result){
		//Liberar el conjunto de resultados
		$result->close();
	}

	function getNumRows($result){
		return $result->num_rows;
	}

}//Fin de la class DB
?>
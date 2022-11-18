<?php

class Session {

	static function init(){
		session_start();
	}

	static function sessionUser(){
		if(is_object($_SESSION["sessionUser"]) > 0){
			return true;
		}else{
			return false;
		}
	}

	static function destroy(){
		session_destroy();
	}

}
?>
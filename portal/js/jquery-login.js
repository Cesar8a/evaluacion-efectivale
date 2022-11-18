$(document).ready(function(){

	$(".loading, .message").hide();
	$("#frmLogin").submit(function(event){
		$(".loading").show();
		event.preventDefault(); //No se envia el formulario.

		//Enviamos el formulario por Metodo POST
		$.post("pages/login.php", $(this).serialize(), function(data){
			if(data == "error"){
				$(".loading").hide();
				$(".message").show().html("<h1>Usuario y/o Password Incorrecto.</h1>");
			}else{
				$(".loading").hide();
				window.location = "home.php";
			}
		}); //Fin de $.post
		$(".message").hide();
	}); //Fin de .submit

});
$(document).ready(function(){

	function hasHtml5Validation(){
		return typeof document.createElement("input").checkValidity === "function";
	}

	/**************************************************************************************************/
	$("#phone, #extension").numeric();
    $("#phone").attr("maxlength", 10);
    $("#extension").attr("maxlength", 3);
	$(".loading, .message").hide();
	$("#btnCheckIn").click(function(){
		error = "<h1>Se han encontrado los siguientes errores:</h1>";
		ban = 0;

		if($("#checkEmail").val() == 1){
			error += "<h1>- Correo electrónico registrado.</h1>";
			ban++;
		}

		if($("#checkUser").val() == 1){
			error += "<h1>- Usuario registrado.</h1>";
			ban++;
		}

		if(ban > 0){
			$(".message").show().html(error);
			return false;
		}else{
			$(".message").hide().html("");
		}
	});

	/**************************************************************************************************/
	$("#email").change(function(){
		email = $(this).val();

		$.post("pages/check/checkEmail.php",{email:email}).done(function(data){
			$("#checkEmail").val(data);
		}); //Fin de $.post
	});

	/**************************************************************************************************/
	$("#user").change(function(){
		user = $(this).val();

		$.post("pages/check/checkUser.php",{user:user}).done(function(data){
			$("#checkUser").val(data);
		}); //Fin de $.post
	});

	/**************************************************************************************************/
	if(hasHtml5Validation()){
		$("#frmCheckIn").submit(function(event){
			if(!this.checkValidity()){
				$(this).addClass("invalid");
				return false;
			}else{
				$(this).removeClass("invalid");
				$(".loading").show();
				event.preventDefault(); //No se envia el formulario.

				//Enviamos el formulario por Metodo POST
				$.post("pages/save/saveUser.php", $(this).serialize(), function(data){
					$(".loading").hide();
					$(".message").show().html(data);
					setTimeout(function(){
						$(".message").fadeOut("slow", function(){
							$("#frmCheckIn")[0].reset();
						});
					}, 4000);
				}); //Fin de $.post
			}
		}); //Fin de .submit
	}
});
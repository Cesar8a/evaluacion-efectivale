$(document).ready(function(){

	$(".loading, .message").hide();
	$("#frmContactar").submit(function(event){
		$(".loading").show();
		event.preventDefault(); //No se envia el formulario.

		$.ajax({
		  url: "save/saveContact.php",
		  type: "POST",
		  data: $(this).serialize(),
		}).done(function(data){
			$(".loading").hide();
			$(".message").show().html(data);
		}).fail(function() {
			alert("Hubo algun error en la solicitud");
		});
	}); //Fin de .submit

});
function deleteMenus(idMenus){ 
	if(confirm('¿Esta seguro de eliminar este registro?')){

		$.post("pages/save/saveMenus.php",{"idMenus":idMenus,"mode":"delete"}).done(function(data){
			alert(data);
		}); //Fin de $.post

		setTimeout(function(){
			$(".content").load(location.href+" .content > *", function(){
				$.getScript("js/jquery-functionsDataTables.js");
			});
		}, 2000);
	}
}

$(document).ready(function(){

	/*
	$(".box").children(".title").click(function(){
		$(this).next("ul").slideToggle();
	});
	*/

	$(".menu").load("pages/menu.php");

	$(".loading, .message").hide();
	$("#frmMenus").submit(function(event){
		$(".loading").show();
		event.preventDefault(); //No se envia el formulario.

		//Enviamos el formulario por Metodo POST
		$.post("pages/save/saveMenus.php", $(this).serialize(), function(data){
			if(data == "error"){
				window.location = "index.php";
			}else{
				$(".close a").removeAttr("onclick");
				$(".loading").hide();
				$(".message").show().html(data);
			}
		}); //Fin de $.post

		setTimeout(function(){
			$(".content").load(location.href+" .content > *", function(){
				$.getScript("js/jquery-functionsDataTables.js");
				popupHide();
			});
		}, 2000);

	}); //Fin de .submit

});
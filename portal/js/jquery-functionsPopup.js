scrollCachePosition = 0;
function popupShow(URL, width, height){

	if(typeof document.body.style.maxHeight === "undefined"){
		$("body","html").css({height:"100%", width:"100%"});
	}

	if(!$("#cssBackground").length > 0){
		$("body").append("<div id='cssBackground'></div><div id='cssPopupContainer'><div id='cssPopup'></div></div>");
	}

	if(width != undefined){
		$("#cssPopup").css("width", width);
	}
	
	if(height != undefined){
		$("#cssPopup").css("height", height);
		$("#cssPopup").css("overflow", "auto");
	}
	
	$("#cssBackground").slideToggle("slow");

	scrollCachePosition = $(window).scrollTop();
	window.top.scroll(0,0);

	$("#cssPopup").load(URL,function(){
		$("#cssPopupContainer").css("top",0);
		$("#cssPopupContainer").delay(500).fadeIn("slow");
	});

}

function popupHide(){
	
	$("#cssPopupContainer").fadeOut("slow", function(){
		$("#cssBackground").slideToggle("fast");		
	});

	if(scrollCachePosition > 0){
		window.top.scroll(0,scrollCachePosition);
		scrollCachePosition = 0;
	}

}

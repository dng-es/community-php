jQuery(document).ready(function(){	
	$(".tema-foro").mouseenter(function() {
		$("div:empty", this).css("background-color","#dcdcdc");
		$(this).addClass("tema-foro-on").removeClass("tema-foro-off");
	});	
	$(".tema-foro").mouseleave(function() {
		$("div:empty", this).css("background-color","#f0f0f0");
		$(this).addClass("tema-foro-off").removeClass("tema-foro-on");
	});		
	$(".tema-foro").click(function() {
		var destino = "foro-comentarios?id="+$(this).val();
		location.href=destino;
	});			
});
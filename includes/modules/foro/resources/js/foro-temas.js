// JavaScript Document
jQuery(document).ready(function(){	
		   $(".tema-foro").mouseenter(function() {
			   	$("div:empty", this).css("background-color","#dcdcdc");
				$(this).addClass("tema-foro-on");
				$(this).removeClass("tema-foro-off");
		   });	
		   $(".tema-foro").mouseleave(function() {
			   	$("div:empty", this).css("background-color","#f0f0f0");
				$(this).addClass("tema-foro-off");
				$(this).removeClass("tema-foro-on");
		   });		
		   $(".tema-foro").click(function() {
			    var destino = "?page=foro-comentarios&id="+$(this).val();
				location.href=destino;
		   });			
});


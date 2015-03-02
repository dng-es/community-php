// JavaScript Document
jQuery(document).ready(function(){	
	BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
	$('#nombre-video').bootstrapFileInput();
	$(".tooltip-bottom").tooltip({placement:"bottom"});

	$("#video-form").submit(function(evento){
	   $("#alertas-participa").css("display","none");
	   
	   var resultado_ok=true; 
	   var texto_alerta="";  
		if (jQuery.trim($("#titulo-video").val())=="") {
			 resultado_ok=false;
		}
		
		if (jQuery.trim($("#nombre-video").val())=="") {
			 resultado_ok=false;
		}
				
		if (resultado_ok!==true) {			
			 $("#alertas-participa").fadeIn().css("display","block");
			 return false;
		}	
	});

	$("#form-video-comment").submit(function(){
		$(".alert-message").css("display","none");
	   	var resultado_ok=true; 
		
		if (jQuery.trim($("#video-comentario").val())=="") {
			 resultado_ok=false;
		}
				
		if (resultado_ok!==true) {			
			 $("#video-comentario-alert").fadeIn().css("display","block");
			 return false;
		}	
	});
});
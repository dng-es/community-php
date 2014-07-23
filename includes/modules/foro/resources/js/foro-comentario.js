// JavaScript Document
jQuery(document).ready(function(){
	$(".comment-info .label").tooltip({placement:"bottom"});
	
	$("#coment-form").submit(function(evento){
	   $("#alertas-foro").html("").css("display","none");
	   
	   var resultado_ok=true;   
	   var texto_alerta="";    
		if ($('#texto-comentario').val()=="")
		{
			 texto_alerta += "Inserta el comentario. ";
			 resultado_ok=false;
		}
		if (document.getElementById('texto-comentario').value.length>600)
		{
			 texto_alerta += "Máximo 600 caracteres.";
			 resultado_ok=false;
		}		
		if (resultado_ok==false) 
		{		
			 $("#alertas-foro").html(texto_alerta).fadeIn().css("display","block");
			 return false;
		}			
	});

	$(".comment-reply-trigger").click(function(e){
		e.preventDefault();
		$(this).closest(".comment-info").next(".comment-reply").slideToggle();
	});

	$(".comment-reply-form").submit(function(evento){
	   $(".alert-message").css("display","none");
	   
	   var resultado_ok=true,
	   elem = $(this).find('textarea');   
		if (jQuery.trim(elem.val())=="") {
			 elem.next(".alert-message").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		return resultado_ok;
	});
});


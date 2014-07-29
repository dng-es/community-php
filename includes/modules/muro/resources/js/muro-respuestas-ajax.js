// JavaScript Document
jQuery(document).ready(function(){

	$(".tooltip-top").tooltip({placement:"top"});

	$(".responder-triger").tooltip({placement:"top"}).click(function(e){
		$("#muro-responder").css("display","block");
		var id_comentario=$(this).attr("value");
		var tipo_muro=$(this).attr("tipom");
		var comentario =$("#texto-comentario-" + id_comentario).html();
		$("#muro-respuesta-comentario").html(comentario);
		$('#muro-responder-result').html('');
		$("#id_comentario_responder").val(id_comentario);
		$("#tipo_muro").val(tipo_muro);
	});	
	
	
	$(".murogusta").tooltip({placement:"top"}).click(function(e){
		e.preventDefault();

		var id_comentario=$(this).attr("value");	
		var campo = '#'+id_comentario;	
		var campo_votaciones = '.'+id_comentario;	
		var campo_resultado = '#muro-result-megusta'+id_comentario;
		var campo_users = '#user_'+id_comentario;
		var valor = $(campo).attr("value");
		var valor_votaciones = parseInt($(campo_votaciones).html());		
		var valor_user = parseInt($(campo_users).attr("value"));
		
				$(campo_resultado).fadeOut();
		$(campo_resultado).css("display","none");
		
		if(valor_user==0){
			if (valor==0){				
				$("#responder-form").load("includes/modules/muro/pages/muro-respuestas.php?idvc="+id_comentario, function(){			
					$(campo).attr("value",1);
					$(campo_votaciones).html(" " + (valor_votaciones+1));
					$(campo_resultado).html("Votacion realizada con exito");
				});
			}
			else{$(campo_resultado).html("Ya has votado este comentario");}
		}
		else{$(campo_resultado).html("No puedes votar tus propios comentarios");}
		$(campo_resultado).fadeIn();
	});

		
	function ShowMensaje(mensaje){
		$("#responder-form").removeClass("muro-ok")
							.removeClass("muro-ko")
							.html('<p>'+mensaje+'</p>')
							.fadeIn()
							.css("display","block");		
	}
	
});
$(document).ready(function(){


	

	//FUNCIONES PARA LOS COMENTARIOS / MURO
	$("#muro-submit").click(function(){
		$("#muro-form").submit();
	});

	$("#muro-form").submit(function(){
		var resultado_ok = true;
		if (jQuery.trim($("#texto-comentario").removeClass("input-alert").val()) == ""){
			$('#texto-comentario').addClass("input-alert").attr("placeholder", $('#texto-comentario').data("alert")).focus();
			resultado_ok = false;
		}

		return resultado_ok;

	});

	$(".murogusta").tooltip({placement:"top"}).click(function(e){
		e.preventDefault();
		var id_comentario = $(this).attr("value");
		var campo = '#'+id_comentario;
		var campo_votaciones = '.' + id_comentario;
		var campo_resultado = '#muro-result-megusta' + id_comentario;
		var campo_users = '#user_' + id_comentario;
		var valor = $(campo).attr("value");
		var valor_votaciones = parseInt($(campo_votaciones).html());
		var valor_user = parseInt($(campo_users).attr("value"));
		
		$(campo_resultado).fadeOut().css("display","none");
		
		if(valor_user == 0){
			if (valor == 0){
				$("#responder-form").load("app/modules/muro/pages/muro-respuestas.php?idvc=" + id_comentario, function(){
					$(campo).attr("value", 1);
					$(campo_votaciones).html(" " + (valor_votaciones + 1));
					$(campo_resultado).html("Votacion realizada con exito");
				});
			}
			else{$(campo_resultado).html("Ya has votado este comentario");}
		}
		else{$(campo_resultado).html("No puedes votar tus propios comentarios");}
		$(campo_resultado).fadeIn();
	});
})
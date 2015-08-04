// JavaScript Document
jQuery(document).ready(function(){	
	$("#mensaje-new-trigger").click(function(e){
		e.preventDefault();
		$("#nick-comentario, #asunto-comentario, #texto-comentario").val("").removeClass("input-alert");
		$('#new_mensaje').modal();
	});

	$(".message-forward").click(function(){
		var id = $(this).data("id"),
			message_title = "Fwd: " + jQuery.trim($("#" + id).html()),
			message_nick = jQuery.trim($("#message-nick-" + id).html()),		
			message = message_nick + " : \n-------------------------------\n" + jQuery.trim($("#message-body-" + id).html());
		$("#texto-comentario").val(message);
		$("#asunto-comentario").val(message_title);
		$('#new_mensaje').modal();
	});

	$(".message-reply").click(function(){
		var id = $(this).data("id"),
			message_title = "Re: " + jQuery.trim($("#" + id).html()),
			message_nick = jQuery.trim($("#message-nick-" + id).html()),		
			message = message_nick + " : \n-------------------------------\n" + jQuery.trim($("#message-body-" + id).html());
		$("#texto-comentario").val(message);
		$("#asunto-comentario").val(message_title);
		$("#nick-comentario").val(message_nick);
		$('#new_mensaje').modal();
	});	

	$(".TituloNoleido").click(function(evento){
		evento.preventDefault();		
		if($(this).attr("value")==1){
			var contador_no_leidos=$("#contador-no-leidos").html();
			var contador_leidos=$("#contador-leidos").html();
			var id_mensaje=$(this).attr("id");
			var nick_span="#leidoMensajeNick"+id_mensaje;
			var time_span="#leidoMensajeTime"+id_mensaje;
			var mensaje_content="#MensajeOvejaContent"+id_mensaje;
			
			$(this).removeClass("TituloNoleido");
			$(this).removeClass("OvejaNoLeida");
			$(nick_span).removeClass("OvejaNoLeida");
			$(time_span).removeClass("OvejaNoLeida");
												
			$(mensaje_content).removeClass("MensajeNoLeido");
		
			if (contador_no_leidos==1){
				$("#contador-leidos-img").removeClass("menuicon-alert");
			}
			$("#contador-leidos-header").text(contador_no_leidos-1);
			$("#contador-no-leidos").text(contador_no_leidos-1);
			$("#contador-leidos-header").text(contador_no_leidos-1);	
			$.ajax( {
				type: "GET",
				url: "app/modules/mensajes/pages/mensajes-leer.php",
				data: {id: id_mensaje},
				cache: false
				});

			$(this).attr("value", 0);
		}
	});
	
	$(".titulo-mensaje").click(function(e){
		e.preventDefault();
		var id_mensaje=$(this).attr("id");
		var mensaje="#MensajeOveja"+id_mensaje;		
		$(mensaje).slideToggle();  
	});
	
	$("#message-form").submit(function(e){
		e.preventDefault();
	    $("#nick-comentario, #asunto-comentario, #texto-comentario").removeClass("input-alert");

	    var resultado_ok = true,
	    	destinatario = jQuery.trim($("#nick-comentario").val()),
	    	self = this;
		if (destinatario == ""){
			$("#nick-comentario").addClass("input-alert");
			resultado_ok = false;
		}
		if (destinatario == jQuery.trim($("#remitente-comentario").val())) {
			$("#nick-comentario").addClass("input-alert");
			resultado_ok = false;
		}
		
		if (jQuery.trim($("#asunto-comentario").val()) == "") {
			$("#asunto-comentario").addClass("input-alert");
			resultado_ok = false;
		}
		
		if (jQuery.trim($("#texto-comentario").val()) == "") {
			$("#texto-comentario").addClass("input-alert");
			resultado_ok = false;
		}

		//verificar usuario existe
		$.ajax( {
			type: "GET",
			url: "app/modules/mensajes/pages/mensajes-verify.php",
			data: { nick: destinatario },
			cache: false
			})
			.done(function(data) {
				if (data==0){
					$("#nick-comentario").addClass("input-alert");
				}
				else{
					if (resultado_ok == true){self.submit();}
				}
			})
			.fail(function(data) {
				$("#nick-comentario").addClass("input-alert");
				/*resultado_ok=false;*/
		});
	});
});
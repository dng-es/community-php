// JavaScript Document
$(function(){
    BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
})

jQuery(document).ready(function(){	
	$("#mensaje-new-trigger").click(function(e){
		e.preventDefault();

		$("#nick-comentario").val("").css({"background-color":"#fff","border-color":"#D8D8D8"});
		$("#asunto-comentario").val("").css({"background-color":"#fff","border-color":"#D8D8D8"});
		$("#texto-comentario").val("").css({"background-color":"#fff","border-color":"#D8D8D8"});

		$('#new_mensaje').modal();
	});

	$(".message-forward").click(function(){
		var id = $(this).data("id"),
			message_title = "Fwd: " + jQuery.trim($("#" + id).html()),
			message_nick = jQuery.trim($("#message-nick-" + id).html()),		
			message = message_nick + " escribió: \n-------------------------------\n" + jQuery.trim($("#message-body-" + id).html());
		$("#texto-comentario").val(message);
		$("#asunto-comentario").val(message_title);
		$('#new_mensaje').modal();
	});

	$(".message-reply").click(function(){
		var id = $(this).data("id"),
			message_title = "Re: " + jQuery.trim($("#" + id).html()),
			message_nick = jQuery.trim($("#message-nick-" + id).html()),		
			message = message_nick + " escribió: \n-------------------------------\n" + jQuery.trim($("#message-body-" + id).html());
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
				url: "includes/modules/mensajes/pages/mensajes-leer.php",
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
	    $("#nick-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});
	    $("#asunto-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});
	    $("#texto-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});   

	    var resultado_ok=true,
	    	destinatario = jQuery.trim($("#nick-comentario").val()),
	    	self = this;
		if (destinatario==""){
			$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		if (destinatario==jQuery.trim($("#remitente-comentario").val())) {
			$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		
		if (jQuery.trim($("#asunto-comentario").val())=="") {
			$("#asunto-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		
		if (jQuery.trim($("#texto-comentario").val())=="") {
			$("#texto-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}

		//verificar usuario existe
		$.ajax( {
			type: "GET",
			url: "includes/modules/mensajes/pages/mensajes-verify.php",
			data: { nick: destinatario },
			cache: false
			})
			.done(function(data) {
				if (data==0){
					$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
				}
				else{
					if (resultado_ok==true){self.submit();}
				}
			})
			.fail(function(data) {
				$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
				/*resultado_ok=false;*/
		});
	});
});
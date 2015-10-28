// JavaScript Document
jQuery(document).ready(function(){

	var timerProcess, 
		elpasedTime = 15000, 
		pasada = 0,
		id_message = 0,
		action = "",
		destino = $("#mailing-process-info");

	$("#proccess-message, #reproccess-message").click(function(evento){
		evento.preventDefault();
		proccessStart ($(this));
	});

	proccessStart = function (elem){
		id_message = elem.data("id");
		estado = elem.data("estado");
		action = elem.data("action");
		if (estado == "enabled"){
			destino.append(" Iniciando envío: ");
			elem.data("estado","disabled")
				.removeClass("btn-primary")
				.addClass("btn-default");
			proccessMsg(id_message, action);
			timerProcess = setTimeout( proccessIni,0);
		}
	}

	proccessIni = function (){
		timerProcess = setInterval( proccessMsg, elpasedTime );
	}

	proccessMsg = function (){
		pasada ++;
		//iniciar proceso
		$.ajax({
			type: "POST",
			url: "app/modules/mailing/pages/admin-message-proccess-step1.php",
			data: { id_message: id_message, action: action, pasada: pasada }
		})
		.fail(function(data){
			destino.append("<br />Error al cargar datos del envío. Pasada: " + pasada + "<br />" + data);
		})
		.always(function(data){
			destino.append(data).scrollBottom();
			if (data.indexOf("Esperado iniciar siguiente pasada...") == -1){
				destino.append("<br />------------Envio finalizado!!!------------");
				clearInterval(timerProcess);
			}
			else{
				destino.append(" (" + elpasedTime/1000 + " seg.)");
			}
		});
	}

	$.fn.scrollBottom = function(){
		destino.animate({
			scrollTop: 200
		}, 500);
	};

});
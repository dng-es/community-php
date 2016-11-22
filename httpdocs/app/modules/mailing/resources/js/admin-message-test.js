// JavaScript Document
jQuery(document).ready(function(){
	var timerProcess, 
		elpasedTime = 15000, 
		pasada = 0,
		id_message = 0,
		action = "",
		destino = $("#mailing-process-info");

	$("#SubmitTest").click(function(evento){
		evento.preventDefault();

		if (jQuery.trim($("#email_test").val()) == ""){
			 alert("Debes introducir los destinatarios.");
		}
		else{
			$.ajax({
				type: "POST",
				url: "app/modules/mailing/pages/admin-message-test.php",
				data: $('#formData').serialize()
			})
			.fail(function(data){
				alert("Error al enviar mensaje");
			})
			.always(function(data){
				alert("Mensaje enviado");
			});
		}
	});
});
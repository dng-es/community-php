jQuery(document).ready(function(){
	$(".inputFile").filestyle({ 
		image: "images/btn_examinar2.gif",
		imageheight:23,
		imagewidth: 66,
		width: 100
	});

	$(".subir-tarea").click(function(e){
		e.preventDefault();
		var identificador = "#subir-tarea-" + $(this).val();
		$(".form-tareas").slideUp();
		$(identificador).slideToggle();
	});

	$(".enviarButton").click(function(evento){
		$(".alert-message").css("display", "none");
		var form_ok = true;
		var identificador = $(this).attr("name");
		var identificador_fichero = "#nombre-fichero-" + identificador;
		var identificador_alerta = "#fichero-comentario-alert-" + identificador;
		var identificador_form="#data-" + identificador;
		if (jQuery.trim($(identificador_fichero).val()) == ""){
			$(identificador_alerta).html("Debe insertar un archivo.").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (form_ok == true){
			$(identificador_form).submit();
		}
	});

	$("#grupoSubmit").click(function(evento){
		$(".alert-message").css("display", "none");
		var form_ok = true;
		if (jQuery.trim($("#nombre-grupo").val()) == ""){
			$("#nombre-grupo-alert").html("Debes introducir el nombre del grupo.").fadeIn().css("display", "block");
			form_ok = false;
		}			
		if (form_ok == true){
			$("#grupo-crear").submit();
		}
	});

	$("#invitacionSubmit").click(function(evento){
		$(".alert-message").css("display", "none");
		var form_ok = true;
		if (jQuery.trim($("#user-nick").val()) == ""){
			$("#nick-alert").html("Debes introducir el nick del usuario al que quieres invitar.").fadeIn().css("display", "block");
			form_ok = false;
		}			
		if (form_ok == true){
			$("#grupo-invitar").submit();
		}
	});
});
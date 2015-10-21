// JavaScript Document
jQuery(document).ready(function(){
	showMuro();
	var timer = setInterval( showMuro, 30000);
	
	$("#muro-submit").click(function(e){
		ValidateMuro();
	});
	
	$("#muro-responder-submit").click(function(e){		
		ValidateResponder();
	});	
		
	$("#muro-responder-cerrar").click(function(e){
		$('#muro-responder-result').html('');
		$("#muro-responder").slideUp();
	});
	
	function showMuro(){
		$("#cargando").css("display", "inline");
		$('.user-tip').tooltip('destroy');
		$("#destino").load("app/modules/muro/pages/muro.php" + "?ms=" + new Date().getTime(), function(){
			$("#cargando").css("display", "none");
		});
	}
	
	function ShowMensaje(mensaje){
		$("#result-muro").removeClass("alert")
						 .removeClass("alert-danger")
						 .removeClass("alert-success")
						 .html('<p>'+mensaje+'</p>')
						 .fadeIn()
						 .css("display","block");		
	}
	
	function ShowMensajeResponder(mensaje){
		$('#muro-responder-result').html('<p>'+mensaje+'</p>');
		$("#muro-responder-result").fadeIn();
		$("#muro-responder-result").css("display","block");		
	}
	
	function ValidateResponder(){
		$("#muro-responder-result").html("");
		var resultado_ok = true;
		if (jQuery.trim($('#texto-responder').val()) == ""){
			ShowMensajeResponder("Debes insertar algo de texto.");
			resultado_ok = false;
		}
		if (document.getElementById('texto-responder').value.length>160){
			ShowMensajeResponder("Has superado el límite de caracteres. Máximo 160 caracteres.");
			resultado_ok = false;
		}
		if (resultado_ok == true){
			$.ajax({
				type: 'POST',
				url: 'app/modules/muro/pages/muro_process.php?t=1',
				data: $('#form-responder-muro').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					ShowMensajeResponder("Respuesta correctamente insertada en el muro");
					$("#texto-responder").val("")
					showMuro();
					$("#muro-responder").fadeOut(3000);
				}
			})
		}
		return false;
	}
	
	function ValidateMuro(){
		$("#result-muro").html("");
		var resultado_ok = true;
		if (jQuery.trim($('#texto-comentario').val()) == "") {
			ShowMensaje("Debes insertar algo de texto en el comentario.");
			$("#result-muro").addClass("alert alert-danger");
			resultado_ok = false;
		}
		if (document.getElementById('texto-comentario').value.length>160) {
			ShowMensaje("Has superado el límite de caracteres. Máximo 160 caracteres.");
			$("#result-muro").addClass("alert alert-danger");
			resultado_ok = false;
		}		
		if (resultado_ok == true){
			$.ajax({
				type: 'POST',
				url: 'app/modules/muro/pages/muro_process.php',
				data: $('#muro-form').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					ShowMensaje("Mensaje correctamente insertado en el muro");
					$("#texto-comentario").val("");
					$("#result-muro").addClass("alert alert-success").fadeOut(5000);
					showMuro();
				}
			})
		}
		return false;
	}
});
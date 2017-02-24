// JavaScript Document
jQuery(document).ready(function(){
	var id_comentario=$("#id_comentario_responder").val();
	showMuro(id_comentario);
	
	$("#muro-submit").click(function(e){
		ValidateMuro();
	});
	
	function showMuro(id_comentario){
		/*$("#cargando").css("display", "inline");*/
		$("#destino").load("app/modules/muro/pages/muro_responder_ajax.php?id=" + id_comentario, function(){
		/*$("#cargando").css("display", "none");*/
		});
	}
	
	function ShowMensaje(mensaje){
		$("#result-muro").removeClass("alert")
						.removeClass("alert-danger")
						.removeClass("alert-success")
						.html('<p>' + mensaje + '</p>')
						.fadeIn()
						.css("display","block");
	}
	
	function ValidateMuro(){
		$("#result-muro").html("");
		var form_ok = true;
		if ($('#texto-responder').val() == ""){
			ShowMensaje("Debes insertar algo de texto en el comentario.");
			$("#result-muro").addClass("alert alert-danger");
			form_ok = false;
		}

		if (document.getElementById('texto-responder').value.length > 160){
			ShowMensaje("Has superado el límite de caracteres. Máximo 160 caracteres.");
			$("#result-muro").addClass("alert alert-danger");
			form_ok = false;
		}	

		if (form_ok == true){
			$.ajax({
				type: 'POST',
				url: 'app/modules/muro/pages/muro_process.php',
				data: $('#form-responder-muro').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					ShowMensaje("Mensaje correctamente insertado en el muro");
					$('#texto-responder').val("");
					$("#result-muro").addClass("alert alert-success");
					showMuro(id_comentario);
				}
			})
		}
		return false;
	}
});
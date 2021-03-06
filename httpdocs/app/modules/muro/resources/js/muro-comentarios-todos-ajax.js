// JavaScript Document
jQuery(document).ready(function(){
	var id_muro=$("#tipo_muro").data("val");
	var pagina=$("#pagina").data("val");
	showMuro(id_muro,pagina);

	$("#muro-responder-submit").click(function(e){
		ValidateResponder();
	});

	$("#muro-responder-cerrar").click(function(e){
		$('#muro-responder-result').html('');
		$("#muro-responder").slideUp();
	});

	$("#muro-submit").click(function(e){
		ValidateMuro();
	});

	function showMuro(id_muro,pagina){
		$("#cargando").css("display", "inline");
		$("#destino").load("app/modules/muro/pages/muro_todos_ajax.php?c=" + id_muro + "&pag=" + pagina, function(){
			$("#cargando").css("display", "none");
		});
	}

	function ShowMensaje(mensaje){
		$("#result-muro").removeClass("alert")
						.removeClass("alert-danger")
						.removeClass("alert-success")
						.html('<p>' + mensaje + '</p>')
						.fadeIn()
						.css("display", "block");
	}

	function ValidateResponder(){
		$("#muro-responder-result").html("");
		var form_ok = true;  
		if ($('#texto-responder').val() == ""){
			ShowMensajeResponder("Debes insertar algo de texto.");
			form_ok = false;
		}
		if (document.getElementById('texto-responder').value.length > 160){
			ShowMensajeResponder("Has superado el límite de caracteres. Máximo 160 caracteres.");
			form_ok = false;
		}
		if (form_ok == true){
			$.ajax({
				type: 'POST',
				url: 'app/modules/muro/pages/muro_process.php',
				data: $('#form-responder-muro').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {
					ShowMensajeResponder("Respuesta correctamente insertada en el muro");
					$("#texto-responder").val("")
					showMuro(id_muro, pagina);
					$("#muro-responder").fadeOut(3000);
				}
			})
		}
		return false;
	}

	function ShowMensajeResponder(mensaje){
		$('#muro-responder-result').html('<p>' + mensaje + '</p>').fadeIn().css("display", "block");
	}

	function ValidateMuro(){
		$("#result-muro").html("");
		var form_ok = true;
		if ($('#texto-comentario').val() == ""){
			 ShowMensaje("Debes insertar algo de texto en el comentario.");
			 $("#result-muro").addClass("alert alert-danger");
			 form_ok = false;
		}
		if (document.getElementById('texto-comentario').value.length > 160){
			 ShowMensaje("Has superado el límite de caracteres. Máximo 160 caracteres.");
			 $("#result-muro").addClass("alert alert-danger");
			 form_ok = false;
		}
		if (form_ok == true){
			$.ajax({
				type: 'POST',
				url: 'app/modules/muro/pages/muro_process.php',
				data: $('#muro-form').serialize(),
				// Mostramos un mensaje con la respuesta de PHP
				success: function(data) {

					window.sweetAlertInitialize();
					swal({
						title: "Muy bien!",
						text: "Mensaje correctamente insertado en el muro",
						timer: 3000,
						type: "success",
						confirmButtonText: "Cerrar"
					});
					showMuro(id_muro, pagina);
				}
			})
		}
		return false;
	}
});
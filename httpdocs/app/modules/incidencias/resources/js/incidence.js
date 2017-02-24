// JavaScript Document
jQuery(document).ready(function(){

	$("#texto_incidencia").bootstrapTextArea({
		title: "Nuevo comentario", 
		saveText: "Aceptar",
		zoomText: "Ampliar",
		rows: 20,
		icon: "fa fa-pencil",
		autoexpand: true,
		maxSizeElement: 1500,
		counter: true,
		counterText: "Caracteres",
		counterCss: { display: "inline-block", color: "#666666", background: "transparent"}
	});

	//verificación datos del formulario
	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var resultado_ok = true;

		if (jQuery.trim($("#texto_incidencia").removeClass("input-alert").val()) == ""){
			$('#texto_incidencia').addClass("input-alert").attr("placeholder", $('#texto_incidencia').data("alert")).focus();
			resultado_ok = false;
		}

		return resultado_ok;
	});

	$("#reopenBtn").click(function(evento){
		evento.preventDefault();
		swal({
			title: "Confirmación de cambio de estado",
			text: "¿Seguro que deseas reabrir la incidencia?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#formData").attr('action', 'incidence?a=0').submit();
		});
	});	
	
	$("#cancelarBtn").click(function(evento){
		evento.preventDefault();
		swal({
			title: "Confirmación de cambio de estado",
			text: "¿Seguro que deseas cancelar la incidencia?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Cancelar",
			confirmButtonText: "Confirmar",
			closeOnConfirm: false
		},
		function(){
			$("#formData").attr('action', 'incidence?a=2').submit();
		});
	});


});
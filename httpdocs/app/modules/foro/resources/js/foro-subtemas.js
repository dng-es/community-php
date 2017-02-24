// JavaScript Document
jQuery(document).ready(function(){
	$("#texto-descripcion").bootstrapTextArea({
									title: "Descripción del foro", 
									lblSave: "Aceptar",
									lblZoom: "Ampliar",
									rows: 20
									});

	$("#tema-form").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($('#nombre-tema').removeClass("input-alert").val()) == ""){
			$('#nombre-tema').addClass("input-alert").attr("placeholder", $('#nombre-tema').prop("title")).focus();
			form_ok = false;
		}
		if (jQuery.trim($('#texto-descripcion').removeClass("input-alert").val()) == ""){
			$('#texto-descripcion').addClass("input-alert").attr("placeholder", $('#texto-descripcion').prop("title")).focus();
			form_ok = false;
		}

		return form_ok;
	});
});
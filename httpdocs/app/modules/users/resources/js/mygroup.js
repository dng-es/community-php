// JavaScript Document
jQuery(document).ready(function(){

	$(".numeric").numeric();

	$("#text_alert").bootstrapTextArea({
		title: "Descripción",
		lblSave: "Aceptar",
		lblZoom: "Ampliar",
		rows: 20
	});

	$("#new-user-trigger").click(function(e){
		e.preventDefault();
		if ($("#new-user-container").hasClass('div-drop-visible')){
			$("#new-user-container").slideUp().removeClass('div-drop-visible');
		}
		else{
			$("#new-user-container").show().addClass('div-drop-visible');
		}
	});
	
	//verificación datos del formulario
	$("#add-form").submit(function(evento){
		var form_ok = true;   
		if (jQuery.trim($("#id_username").removeClass("input-alert").val())<=0) {
				$('#id_username').addClass("input-alert").attr("placeholder",$('#id_username').data("alert")).focus();
			form_ok = false;
		}

		
		if (jQuery.trim($("#empresa_user").removeClass("input-alert").val())=="") {
			form_ok = false;
			$("#empresa_user").addClass("input-alert").attr("placeholder",$('#empresa_user').data("alert")).focus();
		}

		if (jQuery.trim($("#user-nombre").removeClass("input-alert").val())=="") {
			$('#user-nombre').addClass("input-alert").attr("placeholder",$('#user-nombre').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#user-apellidos").removeClass("input-alert").val())=="") {
				$('#user-apellidos').addClass("input-alert").attr("placeholder",$('#user-apellidos').data("alert")).focus();
			form_ok = false;
		}	 
		if (validateEmail($("#user-email").removeClass("input-alert").val())==false) {
				$('#user-email').addClass("input-alert").attr("placeholder",$('#user-email').data("alert")).focus();
			form_ok = false;
		}

/*		if (jQuery.trim($("#telefono").removeClass("input-alert").val())=="") {
			$('#telefono').addClass("input-alert").attr("placeholder",$('#telefono').data("alert")).focus();
			form_ok=false;
		}	*/
	
		return form_ok;
	});
});
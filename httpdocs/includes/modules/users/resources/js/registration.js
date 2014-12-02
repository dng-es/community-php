// JavaScript Document
jQuery(document).ready(function(){	
	$('input[type=file]').bootstrapFileInput();

	$("#declaracion-trigger").click(function(event) {
		event.preventDefault();
		$('#declaracionModal').modal('show');
	});

	$("#policy-trigger").click(function(event) {
		event.preventDefault();
		$('#policyModal').modal('show');
	});

	$("#user-empresa").blur(function(evento){
		//verificar cod. tienda
		$.ajax({
			type: "POST",
			url: "includes/modules/users/pages/registration_process.php",
			data: { cod_tienda: $("#user-empresa").val() }
		})
		.fail(function(data) {
			$("#user-empresa").attr("data-c","0");
		})
		.always(function(data) {
			if (data == 'ko'){
				$("#user-empresa").attr("data-c","0");
				$("#user-empresa-nombre").val("");
			}
			else{
				$("#user-empresa").attr("data-c","1");
				$("#user-empresa-nombre").val(data);
			}
		});
	});

	$("#confirm-form").submit(function(evento){
	   $(".alert-message").html("");
	   $(".alert-message").css("display","none");
	   
	

	   var resultado_ok=true;   
	   if (check_nif_cif_nie($("#username-text").val())<=0) 
	   {
			 $("#username-text-alert").html("Debes intruducir un DNI válido.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-empresa").attr("data-c")) == 0) 
	   {
			 $("#tienda-alert").html("Debes intruducir un código de tienda válido.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (validateEmail($("#user-email").val())==false) 
	   {
			 $("#user-email-alert").html("Debes introducir un email válido.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nick").val())=="") 
	   {
			 $("#user-nick-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nombre").val())=="") 
	   {
			 $("#user-nombre-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-apellidos").val())=="") 
	   {
			 $("#user-apellidos-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }	   
	   if ($("#user-date").val()!="" && esFechaValida($("#user-date").val())==false) 
	   {
			 $("#user-date-alert").html("Debes intruducir una fecha válida. Formato aaaa-mm-dd.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-pass").val())=="") 
	   {
			 $("#user-pass-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-repass").val())=="") 
	   {
			 $("#user-repass-alert").html("Debes intruducir algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }	
	   if (jQuery.trim($("#user-repass").val())!=jQuery.trim($("#user-pass").val())) 
	   {
			 $("#user-repass-alert").html("Las contraseñas no coinciden.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }
	   if ($("#user-declaracion").is(":checked")==false) 
	   {
			 $("#user-declaracion-alert").html("Debes aceptar los términos y condiciones.").fadeIn().css("display","block");
			 resultado_ok=false;
	   }	   
	   return resultado_ok;
	});
});
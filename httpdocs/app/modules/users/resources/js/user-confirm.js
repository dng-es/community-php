// JavaScript Document
jQuery(document).ready(function(){	
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});

	$("#declaracion-trigger").click(function(event) {
		event.preventDefault();
		$('#declaracionModal').modal('show');
	});

	$("#policy-trigger").click(function(event) {
		event.preventDefault();
		$('#policyModal').modal('show');
	});

	$("#confirm-form").submit(function(evento){
	   $(".alert-message").html("");
	   $(".alert-message").css("display","none");
	   
	   
	   var resultado_ok=true;   
	   if (validateEmail($("#user-email").val())==false) 
	   {
			 $("#user-email-alert").html("Debes introducir un email válido.");
			 $("#user-email-alert").fadeIn();
			 $("#user-email-alert").css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nick").val())=="") 
	   {
			 $("#user-nick-alert").html("Debes intruducir algo de texto.");			 
			 $("#user-nick-alert").fadeIn();
			 $("#user-nick-alert").css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-nombre").val())=="") 
	   {
			 $("#user-nombre-alert").html("Debes intruducir algo de texto.");			 
			 $("#user-nombre-alert").fadeIn();
			 $("#user-nombre-alert").css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-apellidos").val())=="") 
	   {
			 $("#user-apellidos-alert").html("Debes intruducir algo de texto.");			 
			 $("#user-apellidos-alert").fadeIn();
			 $("#user-apellidos-alert").css("display","block");
			 resultado_ok=false;
	   }	   
	   if ($("#user-date").val()!="" && esFechaValida($("#user-date").val())==false) 
	   {
			 $("#user-date-alert").html("Debes intruducir una fecha válida. Formato aaaa-mm-dd.");			 
			 $("#user-date-alert").fadeIn();
			 $("#user-date-alert").css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-pass").val())=="") 
	   {
			 $("#user-pass-alert").html("Debes intruducir algo de texto.");			 
			 $("#user-pass-alert").fadeIn();
			 $("#user-pass-alert").css("display","block");
			 resultado_ok=false;
	   }
	   if (jQuery.trim($("#user-repass").val())=="") 
	   {
			 $("#user-repass-alert").html("Debes intruducir algo de texto.");			 
			 $("#user-repass-alert").fadeIn();
			 $("#user-repass-alert").css("display","block");
			 resultado_ok=false;
	   }	
	   if (jQuery.trim($("#user-repass").val())!=jQuery.trim($("#user-pass").val())) 
	   {
			 $("#user-repass-alert").html("Las contraseñas no coinciden.");			 
			 $("#user-repass-alert").fadeIn();
			 $("#user-repass-alert").css("display","block");
			 resultado_ok=false;
	   }

	   if ($("#user-declaracion").is(":checked")==false) 
	   {
			 $("#user-declaracion-alert").html("Debes aceptar los términos y condiciones.");			 
			 $("#user-declaracion-alert").fadeIn();
			 $("#user-declaracion-alert").css("display","block");
			 resultado_ok=false;
	   }	   
	   return resultado_ok;
	});
});
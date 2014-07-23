// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();
	$(".numeric").numeric();

	// $("#tipo-lista-fichero").click(function(){
	// 	$("#nombre-fichero").closest(".file-input-wrapper").removeClass("disabled");
	// });

	// $("#tipo-lista-lista").click(function(){
	// 	$("#nombre-fichero").closest(".file-input-wrapper").addClass("disabled");
	// });
	
	$("#datetimepicker1").datetimepicker({
      language: "es-ES"
    });

	$("#formData").submit(function(evento){
		return sendForm("mensaje");
	});

	$("#SubmitAgenda").click(function(evento){
		if (sendForm("agenda")){
			$("#formData").attr("action", "?page=user-message&accion2=ok&act=new&id=" + $("#template_message").val() + "&a=1");
			$("#formData").submit();
		}
	});

	function sendForm(tipo){
		$(".alert-message").html("").css("display","none");
		var resultado_ok=true;


		if (jQuery.trim($("#asunto_message").val())=="") 
		{
			 $("#asunto-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		if (jQuery.trim($("#nombre_message").val())=="") 
		{
			 $("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		if (validateEmail($("#email_message").val())==false) 
		{
			 $("#email-alert").html("Debes insertar un email válido.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	
						
		if (jQuery.trim($("#texto_message").val())=="") 
		{
			 $("#texto-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}

		if ($('#texto2_message').length){
			if (jQuery.trim($("#texto2_message").val())=="") 
			{
				 $("#texto2-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
				 resultado_ok=false;
			}
		}

		if ($("#tipo-lista-lista:checked").length > 0){
			if ($("#id_list").val()=="0") 
			{
				 $("#lista-alert").html("Debes seleccionar una de tus listas.").fadeIn().css("display","block");
				 resultado_ok=false;
			}	
		}
		
		if ($("#tipo-lista-fichero:checked").length > 0){
			if (jQuery.trim($("#nombre-fichero").val())=="") 
			{
				 $("#fichero-alert").html("Debes cargar un fichero con los emails.").fadeIn().css("display","block");
				 resultado_ok=false;
			}	
		}		

		if (tipo=="agenda"){
			var fecha = jQuery.trim($("#user-date").val());
			if (fecha == "") 
			{
				 $("#user-date-alert").html("Debes insertar una fecha.").fadeIn().css("display","block");
				 resultado_ok=false;
			}
			else{
				var nowTemp = new Date();
				var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
				fecha = new Date (fecha);
				if (fecha.valueOf() < now.valueOf()){
					$("#user-date-alert").html("Debes insertar una fecha posterior a hoy.").fadeIn().css("display","block");
				 	resultado_ok=false;
				}

			}
		}
				
		return resultado_ok;		
	}
});
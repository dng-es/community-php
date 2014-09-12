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
	
	$("#datetimepicker1, #datetimepicker2").datetimepicker({
      language: "es-ES"
    });


	$("#SubmitData").click(function(e){
		e.preventDefault();
		$("#formData")
			.attr("action", "?page=user-message&id=" + $("#template_message").val() + "&accion2=ok")
			.submit();

	});	

	$("#SubmitAgenda").click(function(evento){
		if (sendForm("agenda")){
			$("#formData").attr("action", "?page=user-message&accion2=ok&act=new&id=" + $("#template_message").val() + "&a=1");
			$("#formData").submit();
		}
	});

	$("#PreviewData").click(function(e){
		e.preventDefault();
		if (sendForm("preview")){
			$("#formData")
				.attr("action", "?page=user-message-preview")
				.attr('target', '_blank')
				.submit();
		}
	});

	function sendForm(tipo){
		$(".alert-message").html("").css("display","none");
		var resultado_ok=true;


		if (jQuery.trim($("#asunto_message").val())=="") {
			 $("#asunto-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		if (jQuery.trim($("#nombre_message").val())=="") {
			 $("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 resultado_ok=false;
		}	

		if (validateEmail($("#email_message").val())==false) {
			 $("#email-alert").html("Debes insertar un email válido.").fadeIn().css("display","block");
			 resultado_ok=false;
		}

		if (tipo!="preview"){
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
		}	

		if (tipo=="agenda"){
			var fecha = jQuery.trim($("#user-date").val());
			if (fecha == "") {
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
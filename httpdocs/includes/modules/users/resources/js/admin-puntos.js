// JavaScript Document
jQuery(document).ready(function(){
	$("#SubmitData").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   var resultado_ok=true;   
		if (jQuery.trim($('#id_usuario').val())=="") {		 
			 $("#id-usuario-alert").html("Tienes que insertar un usuario (no nick).").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#num_puntos').val())=="") {		 
			 $("#num-huellas-alert").html("Tienes que insertar un número.").fadeIn().css("display","block");
			 resultado_ok=false;
		}		
		if (isNaN($("#num_puntos").val())) {
			 $("#num-huellas-alert").html("Tienes que insertar un número.").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#motivo_puntos').val())=="") {		 
			 $("#motivo-huellas-alert").html("Tienes que insertar un motivo.").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) {
			var username=$("#id_usuario").val()
				puntos=$("#num_puntos").val(),
				motivo_puntos=$("#motivo_puntos").val();
			$("#resultado-puntos").css("display","none")
									.load("includes/modules/users/pages/admin-puntos-ajax.php", {id_usuario: username,num: puntos, motivo: motivo_puntos})
									.fadeIn()
									.css("display","block");			
		}		
	});

	$('input[type=file]').bootstrapFileInput();

	$("#inputFile").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   
	   var resultado_ok=true;   
		if (jQuery.trim($("#nombre-fichero").val())=="") {
			 $("#fichero-alert").html("tienes que seleccionar un fichero.").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) {
			$("#formImport").submit();
		}		
	});
});
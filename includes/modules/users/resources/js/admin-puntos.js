// JavaScript Document
jQuery(document).ready(function(){
	$("#SubmitData").click(function(evento){
	   $(".alert-message").html("").css("display","none");
	   var resultado_ok=true;   
		if (jQuery.trim($('#id_usuario').val())=="") 
		{		 
			 $("#id-usuario-alert").html("Tienes que insertar un usuario (no nick).").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#num_huellas').val())=="") 
		{		 
			 $("#num-huellas-alert").html("Tienes que insertar un número.").fadeIn().css("display","block");
			 resultado_ok=false;
		}		
		if (isNaN($("#num_huellas").val())) 
		{
			 $("#num-huellas-alert").html("Tienes que insertar un número.").fadeIn().css("display","block");
			 resultado_ok=false;
		}
		if (jQuery.trim($('#motivo_huellas').val())=="") 
		{		 
			 $("#motivo-huellas-alert").html("Tienes que insertar un motivo.").fadeIn().css("display","block");
			 resultado_ok=false;
		}				
		if (resultado_ok==true) 
		{
			var username=$("#id_usuario").val();
			var num_huellas=$("#num_huellas").val();
			var motivo_huellas=$("#motivo_huellas").val();
			$("#resultado-huellas").css("display","none")
									.load("includes/modules/users/pages/admin-huellas-asignar.php", {id_usuario: username,num: num_huellas, motivo: motivo_huellas})
									.fadeIn()
									.css("display","block");			
		}		
	});
});
jQuery(document).ready(function(){

	$("#area_puntos").numeric();
	$("#area_limite").numeric();

	$(".edit-tarea").click(function(){
		var id_tarea = $(this).attr("code-t"),
			desc_tarea = $(this).attr("code-d"),
			tit_tarea = $(this).attr("code-tit"),
			trigger_edit = $(this);
		createDialogTarea(id_tarea,desc_tarea,tit_tarea,trigger_edit);
	});

	$("#SubmitData").click(function(evento){  
	   $(".alert-message").html("").css("display","none");	   	      
	   var form_ok=true;   
		if (jQuery.trim($("#area_nombre").val())=="") 
		{
			 $("#nombre-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 form_ok=false;
		}
		if (jQuery.trim($("#area_descripcion").val())=="") 
		{
			 $("#descripcion-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 form_ok=false;
		}

		if (jQuery.trim($("#area_puntos").val())=="") 
		{
			 $("#puntos-alert").html("Debes insertar las horas de vuelo.").fadeIn().css("display","block");
			 form_ok=false;
		}		
	
		if (jQuery.trim($("#area_canal").val())=="") 
		{
			 $("#canal-alert").html("Debes seleccionar un canal.").fadeIn().css("display","block");
			 form_ok=false;
		}
		if (form_ok) 
		{
			$("#formData").submit();
		}		
	});

	$("#SubmitGrupo").click(function(evento){  
	   $(".alert-message").html("").css("display","none");	   	      
	   var form_ok=true;   
		if (jQuery.trim($("#grupo_nombre").val())=="") 
		{
			 $("#grupo-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 form_ok=false;
		}
		if (form_ok) 
		{
			$("#formNewGrupo").submit();
		}		
	});	

	$("#SubmitTarea").click(function(evento){  
	   $(".alert-message").html("").css("display","none");	   	      
	   var form_ok=true;   
		if (jQuery.trim($("#tarea_titulo").val())=="") 
		{
			 $("#tarea-titulo-alert").html("Debesinsertar algo de texto.").fadeIn().css("display","block");
			 form_ok=false;
		}
		if (jQuery.trim($("#tarea_descripcion").val())=="") 
		{
			 $("#tarea-descripcion-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
			 form_ok=false;
		}	
		if (jQuery.trim($("#fichero-tarea").val())=="" && $("#tipo:last").attr("checked")==true) 
		{
			 $("#fichero-tarea-alert").html("Debes seleccionar un fichero.").fadeIn().css("display","block");
			 form_ok=false;
		}	
		if (form_ok) 
		{
			$("#formNewTarea").submit();
		}		
	});		
});

function createDialogTarea(id_tarea,desc_tarea,tit_tarea,trigger_edit){           
    $("#dialog-message:ui-dialog" ).dialog( "destroy" );
    $("#edit-tit").html(tit_tarea);        
    $("#edit-desc").val(desc_tarea); 
    $("#edit-id-tarea").val(id_tarea);
    $("#edit-desc-alert").html("").css("display","none");           
    $("#dialog-message" ).dialog({
      modal: true,
      show: "fold",
   	  hide: "scale",
   	  width: 560,
   	  height: 290,
   	  resizable: false,
   	  title:"modificar datos de la tarea",
   	  dialogClass: "dialog-alert-info",
   	  buttons: [ 
   	  		{ text: "guardar cambios",class: 'dialog-message-button', click: function() { 
   	  			$("#edit-desc-alert").html("").css("display","none");	   	      
			    var form_ok=true;   

				if (jQuery.trim($("#edit-desc").val())=="") 
				{
					 $("#edit-desc-alert").html("Debes insertar algo de texto.").fadeIn().css("display","block");
					 form_ok=false;
				}	
			
				if (form_ok) 
				{
					var new_desc = jQuery.trim($("#edit-desc").val());
					$.ajax({
		                type: 'POST',
		                url: 'admin-area-edit-t.php',
		                data: {tarea : id_tarea,descripcion:new_desc},
		                // Mostramos un mensaje con la respuesta de PHP
		                success: function(data) {
		                  if (data=='ok'){
							trigger_edit.attr("code-d",new_desc);
							$("#dialog-message:ui-dialog" ).dialog( "destroy" );
		                  }		                  
		                }
		            }); 
				}
   	  			 
   	  		} },
   	  		{ text: "cerrar",class: 'dialog-message-button', click: function() { 
   	  			$(this ).dialog( "close" ); } 
   	  		}
   	  ]
    });
}   
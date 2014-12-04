jQuery(document).ready(function(){	
	$("#SubmitForm").click(function(evento){
	    var resultado_ok=true;
		
		// $(".formTareaText").css("background-color","#ffffff");
	 //    $(".formTareaRadio").css("background-color","#ffffff");
	 //    $(".formTareaCheck").css("background-color","#ffffff");
		// $(".formTareaText").each(function(index) {
		// if (jQuery.trim($(this).val())=="") 
		// 	{
		// 		 $(this).css("background-color","#FEC9BC");
		// 		 resultado_ok=false;
		// 	}
		// });

		// $(".formTareaRadio").each(function(index) {
		// 	$(this).each(function(index) {
		// 		alert($(this).attr("checked"));
		// 		if ($(this).attr("checked")==true){return false;}
		// 	});	
		// 	resultado_ok=false;
		// });		
			



				
		if (resultado_ok==true) 
		{
			$("#formTarea").submit();
		}	
	});

	$("#FinalizarForm").click(function(evento){
		var id_tarea=$("#id_tarea").val();
		Confirma("¿Seguro que desea finalizar la tarea?.\nRecuerda  que previamente tienes que guardar tus respuestas.","?page=areas_form&id="+id_tarea+"&d=1");
	});
});
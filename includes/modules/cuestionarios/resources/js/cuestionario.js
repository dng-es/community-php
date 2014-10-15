jQuery(document).ready(function(){	
	$("#SubmitForm").click(function(evento){
	    var resultado_ok=true;
				
		if (resultado_ok==true) 
		{
			$("#formTarea").submit();
		}	
	});

	$("#FinalizarForm").click(function(evento){
		var id_cuestionario=$("#id_cuestionario").val();
		Confirma("¿Seguro que desea finalizar el cuestionario?.\nRecuerda  que previamente tienes que guardar tus respuestas.","?page=cuestionario&id="+id_cuestionario+"&d=1");
	});
});
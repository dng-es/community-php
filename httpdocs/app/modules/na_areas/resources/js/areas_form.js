jQuery(document).ready(function(){	
	$("#FinalizarForm").click(function(evento){
		var id_tarea=$("#id_tarea").val();
		Confirma("¿Seguro que desea finalizar la tarea?.\nRecuerda  que previamente tienes que guardar tus respuestas.","areas_form?id="+id_tarea+"&d=1");
	});
});
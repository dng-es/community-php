jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$(".ui-find-button").click(function(){
		$("#form-search-foro").submit();
	});

	$(".trigger-tarea").click(function(event){
		event.preventDefault();
		var elem = $(this).next(".form-tareas");
		elem.slideToggle();
	});

	$(".trigger-documentacion").click(function(e){
		e.preventDefault();
		var elem = $(this).next(".documentacion-tareas");
		elem.slideToggle();
	});

	$(".btnfileTarea").click(function(evento){
		$(".alert-message").css("display","none");
		var resultado_ok = true;
		var identificador = $(this).attr("name");
		var identificador_fichero = "#nombre-fichero-" + identificador;
		var identificador_alerta = "#fichero-comentario-alert-" + identificador;
		var identificador_form = "#data-"+identificador;
		if (jQuery.trim($(identificador_fichero).val()) == ""){
			$(identificador_alerta).html("Debes seleccionar un archivo.").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		if (resultado_ok == true){
			$(identificador_form).submit();
		}
	});
});
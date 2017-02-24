jQuery(document).ready(function(){
	$(".numeric").numeric();

	$("#datetimepicker1").datetimepicker({
		language: "es-ES"
	});

	$("#formDocumentos").submit(function(evento){
		var form_ok = true;
		return form_ok;
	});
});
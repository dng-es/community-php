// JavaScript Document
jQuery(document).ready(function(){

	$(".numeric").numeric();

	$("#datetimepicker1").datetimepicker({
      language: "es-ES"
    });	

	$("#formDocumentos").submit(function(evento){
		var resultado_ok = true;
		return resultado_ok;
	});

	
});
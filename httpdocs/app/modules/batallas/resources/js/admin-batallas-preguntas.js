// JavaScript Document
jQuery(document).ready(function(){
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES"
	});

	$("#resumen").click(function(e){
		e.preventDefault();
		location.href = "?page=admin-batallas-preguntas&export=true&r=true&date_ini=" + $("#date_ini").val()+ "&date_fin=" +$("#date_fin").val();
	});
	$("#detallado").click(function(e){
		e.preventDefault();
		location.href = "?page=admin-batallas-preguntas&export=true&d=true&date_ini=" + $("#date_ini").val()+ "&date_fin=" +$("#date_fin").val();
	});
	// $("#concreto").click(function(e){
	// 	e.preventDefault();
	// 	location.href = "?page=admin-batallas-preguntas&export=true&id="+$('#concreto').data("content")+"&date_ini=" + $("#date_ini").val()+ "&date_fin=" +$("#date_fin").val();
	// });

});
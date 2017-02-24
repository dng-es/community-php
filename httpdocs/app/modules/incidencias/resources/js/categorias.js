// JavaScript Document
jQuery(document).ready(function(){
	$.ajax({
		type: 'POST',
		url: 'app/modules/incidencias/pages/categorias-ajax.php',
		cache: false,
		data: {"opt" : "categorias"},
		success: function(data) {
			var response = $.parseJSON(data);
			$("#categoria_incidencia").typeahead({ source: response });
		}
	});
});
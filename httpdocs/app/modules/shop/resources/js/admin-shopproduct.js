jQuery(document).ready(function(){
	$(".numeric").numeric();
	$('input[type=file]').bootstrapFileInput();

	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");

		console.log($("#canal_product").val());
		var resultado_ok = true;
		return resultado_ok;
	});

	$.ajax({
		type: 'POST',
		url: 'app/modules/shop/pages/shopproduct-ajax.php',
		cache: false,
		data: {"opt" : "categorias"},
		success: function(data) {
			var response = $.parseJSON(data);
			$("#category_product").typeahead({ source: response });
		}
	});

	$.ajax({
		type: 'POST',
		url: 'app/modules/shop/pages/shopproduct-ajax.php',
		cache: false,
		data: {"opt" : "subcategorias"},
		success: function(data) {
			var response = $.parseJSON(data);
			$("#subcategory_product").typeahead({ source: response });
		}
	});
});
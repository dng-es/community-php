jQuery(document).ready(function(){
	$(".numeric").numeric();
	$('input[type=file]').bootstrapFileInput();

	$("#datetimepicker1, #datetimepicker2").datetimepicker({
		language: "es-ES",
		startDate: "2014/01/01"
	});


	$("#formData").submit(function(evento){
		$(".alert-message").html("").css("display", "none");

		var form_ok = true;

		if (jQuery.trim($("#date_ini_product").removeClass("input-alert").val())=="") {
			$('#date_ini_product').addClass("input-alert").attr("placeholder", $('#date_ini_product').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#date_fin_product").removeClass("input-alert").val())=="") {
			$('#date_fin_product').addClass("input-alert").attr("placeholder", $('#date_fin_product').data("alert")).focus();
			form_ok = false;
		}

		if ($("#canal_product").val() == null){
			$("#formData").find("[data-id='canal_product']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='canal_product']").removeClass("input-alert");

		if ($("#id_manufacturer").val() == ''){
			$("#formData").find("[data-id='id_manufacturer']").addClass("input-alert");
			form_ok = false;
		}
		else $("#formData").find("[data-id='id_manufacturer']").removeClass("input-alert");
		
		return form_ok;
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
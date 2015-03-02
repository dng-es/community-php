$(document).ready(function(){
	$("#archivo-cmb").change(function(){
		var valor = $(this).val(),
			myarr = valor.split(",");
		window.location = "blog-list?m=" + myarr[0] + "&a=" + myarr[1];
	});
})
// JavaScript Document
jQuery(document).ready(function(){
	//verificación datos del formulario
	$("#form-order").submit(function(evento){
		$(".alert-message").html("").css("display","none");
		var resultado_ok = true;

		if (jQuery.trim($("#name_order").removeClass("input-alert").val()) == ""){
			$('#name_order').addClass("input-alert").attr("placeholder", $('#name_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#surname_order").removeClass("input-alert").val()) == ""){
			$('#surname_order').addClass("input-alert").attr("placeholder", $('#surname_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#telephone_order").removeClass("input-alert").val()) == ""){
			$('#telephone_order').addClass("input-alert").attr("placeholder", $('#telephone_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#address_order").removeClass("input-alert").val()) == ""){
			$('#address_order').addClass("input-alert").attr("placeholder", $('#address_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#city_order").removeClass("input-alert").val()) == ""){
			$('#city_order').addClass("input-alert").attr("placeholder", $('#city_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#state_order").removeClass("input-alert").val()) == ""){
			$('#state_order').addClass("input-alert").attr("placeholder", $('#state_order').data("alert")).focus();
			resultado_ok = false;
		}

		if (jQuery.trim($("#postal_order").removeClass("input-alert").val()) == ""){
			$('#postal_order').addClass("input-alert").attr("placeholder", $('#postal_order').data("alert")).focus();
			resultado_ok = false;
		}								
	
		return resultado_ok;
	});
});
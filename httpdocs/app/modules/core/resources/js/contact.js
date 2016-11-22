$(document).ready(function(){
	$(".jtextarea").jtextarea({maxSizeElement: 1000, textElement: "Caracteres", 
						cssElement: { display: "inline-block", color: "#999999", background: "transparent"}});

	$(".message-form").css({"display":"none"});
	
	$("#contact_form").submit(function(e){

		$(".alert-message").html("").css("display","none");
		var resultado_ok = true;


		if (jQuery.trim($("#subject_form").removeClass("input-alert").val().length) < 2){
			$('#subject_form').addClass("input-alert").attr("placeholder", $('#subject_form').data("alert")).focus();
			resultado_ok = false;
		}
		if (jQuery.trim($("#body_form").removeClass("input-alert").val().length) < 5 || jQuery.trim($("#body_form").val().length) > 1000){
			$('#body_form').addClass("input-alert").attr("placeholder", $('#body_form').data("alert")).focus();
			resultado_ok = false;
		}

		return resultado_ok;
	});
});
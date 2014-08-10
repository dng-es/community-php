$(document).ready(function(){
	$(".message-form").css({"display":"none"});
	
	$("#contact_form").submit(function(e){
		var form_ok=true;
		$(".message-form").slideUp();
		if($("#subject_form").val().length<2){
			$("#message-form-subject").slideDown();
			$("#subject_form").focus();
			form_ok=false;
		}
		if($("#body_form").val().length<5 || $("#body_form").val().length>1000){
			$("#message-form-body").slideDown();
			$("#body_form").focus();
			form_ok=false;
		}
		return form_ok;
	});
});
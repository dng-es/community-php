$(document).ready(function(){
	$(".jtextarea").jtextarea({maxSizeElement: 1000,
		 cssElement: { display: "inline-block",color: "#FF6600",background: "#fff"}});
	
	$(".message-form").css({"display":"none"});
	
	$("#contact_form").submit(function(e){
		var form_ok=true;
		$(".message-form").slideUp();
		if(jQuery.trim($("#subject_form").val()).length<2){
			$("#message-form-subject").slideDown();
			$("#subject_form").focus();
			form_ok=false;
		}
		if(validateEmail($("#email_form").val())==false){
			$("#message-form-email").slideDown();
			$("#email_form").focus();
			form_ok=false;
		}		
		if(jQuery.trim($("#body_form").val()).length<5 || jQuery.trim($("#body_form").val()).length>1000){
			$("#message-form-body").slideDown();
			$("#body_form").focus();
			form_ok=false;
		}
		return form_ok;
	});
});
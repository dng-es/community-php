$(document).ready(function(){
	$(".message-form").css({"display":"none"});
	
	$("#EnviarForm").click(function(e){
		var form_ok=true;
		$(".message-form").slideUp();
		if($("#subject_form").val().length<2){
			$("#message-form-subject").slideDown();
			$("#subject_form").focus();
			form_ok=false;
		}
		if(validateEmail($("#email_form").val())==false){
			$("#message-form-email").slideDown();
			$("#email_form").focus();
			form_ok=false;
		}		
		if($("#body_form").val().length<5 || $("#body_form").val().length>1000){
			$("#message-form-body").slideDown();
			$("#body_form").focus();
			form_ok=false;
		}
		if (form_ok==true)
		{
			$("#contact_form").action='?page=contact';
        	$("#contact_form").submit();
		}
	});
});

function validateEmail(email)
{
// a very simple email validation checking. 
// you can add more complex email checking if it helps 
    if(email.length <= 0)
	{
	  return false;
	}
    var splitted = email.match('^(.+)@(.+)$');
    if(splitted == null) return false;
    if(splitted[1] != null )
    {
      var regexp_user=/^\'?[\w-_\.]*\'?$/;
      if(splitted[1].match(regexp_user) == null) return false;
    }
    if(splitted[2] != null)
    {
      var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
      if(splitted[2].match(regexp_domain) == null) 
      {
	    var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
	    if(splitted[2].match(regexp_ip) == null) return false;
      }// if
      return true;
    }
return false;
}
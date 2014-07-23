
$(document).ready(function() {	
		
	//Validacion del formulario
	$("#form-login").submit(function(){
		return true;
	});	
	
 
	$("#PassSubmit").click(function(){
		$("#form-lostpw").submit();
	});
});



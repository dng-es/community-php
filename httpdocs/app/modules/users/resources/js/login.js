$(document).ready(function() {	
	//Validacion del formulario
	$("#form-login").submit(function(){
		return true;
	});	


	// $(".login-container form").animate({
	// 	"right": "0",
	// 	opacity:1
	// },500);

	$("#login-container-deg").animate({
		"margin-top": ["10%","easeOutBounce"],
		opacity:1
	}, 1000, function(){


		// $(".login-container").animate({
		// 	opacity: 1
		// },300);
	} );

});
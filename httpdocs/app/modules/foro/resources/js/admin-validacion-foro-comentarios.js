jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event) {
		event.preventDefault()
		$(this).next("div .modal").modal();
	});

	$(".ui-modif-btn").click(function(){
		$("#form-login").submit();
	});	
});
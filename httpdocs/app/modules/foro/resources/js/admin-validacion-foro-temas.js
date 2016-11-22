jQuery(document).ready(function(){
	$(".abrir-modal").click(function(event){
		event.preventDefault()
		$(this).next("div .modal").modal();
	});
});
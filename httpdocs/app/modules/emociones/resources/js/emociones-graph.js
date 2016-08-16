jQuery(document).ready(function(){
	$('.graph-user, .graph-total').tooltip();
	$(".emocion-graph-img").tooltip({placement:"bottom"});
	$("#semana").change(function(evento){
		$("#formEmociones").submit();	
	});
});
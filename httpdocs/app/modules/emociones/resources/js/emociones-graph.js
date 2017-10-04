jQuery(document).ready(function(){
	$('.graph-bar-user, .graph-bar-total').tooltip();
	$(".emocion-graph-img").tooltip({placement:"bottom"});
	$("#semana").change(function(evento){
		$("#formEmociones").submit();
	});

	$(".graph-bar-user").each(function(evento){
		$(this).animate({"height": $(this).data('height')},1100);
	});

	$(".graph-bar-total").each(function(evento){
		$(this).animate({"height": $(this).data('height')},700);
	});	
});
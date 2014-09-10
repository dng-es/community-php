// JavaScript Document
$(function(){
    BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
})

jQuery(document).ready(function(){	
	$("#mensaje-new-trigger").click(function(e){
		e.preventDefault();
		$("#mensaje-new").slideDown();
		$("#nick-comentario").attr("value","").css({"background-color":"#fff","border-color":"#D8D8D8"});
		$("#asunto-comentario").attr("value","").css({"background-color":"#fff","border-color":"#D8D8D8"});
		$("#texto-comentario").attr("value","").css({"background-color":"#fff","border-color":"#D8D8D8"});
	});
	
	$("#mensaje-cerrar").click(function(){
		$("#mensaje-new").slideUp();
	});
	$(".TituloNoleido").click(function(evento){
		evento.preventDefault();		
		if($(this).attr("value")==1){
			var contador_no_leidos=$("#contador-no-leidos").html();
			var contador_leidos=$("#contador-leidos").html();
			var id_mensaje=$(this).attr("id");
			var nick_span="#leidoMensajeNick"+id_mensaje;
			var time_span="#leidoMensajeTime"+id_mensaje;
			var mensaje_content="#MensajeOvejaContent"+id_mensaje;
			
			$(this).removeClass("TituloNoleido");
			$(this).removeClass("OvejaNoLeida");
			$(nick_span).removeClass("OvejaNoLeida");
			$(time_span).removeClass("OvejaNoLeida");
												
			$(mensaje_content).removeClass("MensajeNoLeido");
		
			if (contador_no_leidos==1){
				$("#contador-leidos-img").removeClass("menuicon-alert");}
			$("#contador-leidos-header").text(contador_no_leidos-1);
			$("#contador-no-leidos").text(contador_no_leidos-1);
			$("#contador-leidos").text(contador_leidos-(-1));
			$("#contador-leidos-header").text(contador_no_leidos-1);	
			$("#leer-oveja").load("includes/modules/mensajes/pages/mensajes-leer.php", {id: id_mensaje});
			$(this).attr("value", 0);
		}
	});
	
	$(".titulo-mensaje").click(function(evento){
		evento.preventDefault();
		var id_mensaje=$(this).attr("id");
		var mensaje="#MensajeOveja"+id_mensaje;		
		$(mensaje).slideToggle();  
	});
	
	$("#coment-submit").click(function(evento){
	    $("#nick-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});
	    $("#asunto-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});
	    $("#texto-comentario").css({"background-color":"#fff","border-color":"#D8D8D8"});   
	    var resultado_ok=true;   
		if (jQuery.trim($("#nick-comentario").val())=="") 
		{
			$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		if (jQuery.trim($("#nick-comentario").val())==jQuery.trim($("#remitente-comentario").val())) 
		{
			$("#nick-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		
		if (jQuery.trim($("#asunto-comentario").val())=="") 
		{
			$("#asunto-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
		
		if (jQuery.trim($("#texto-comentario").val())=="") 
		{
			$("#texto-comentario").css({"background-color":"#FEC9BC","border-color":"#fb8a6f"});
			resultado_ok=false;
		}
				
		if (resultado_ok==true) {$("#coment-form").submit();}
	});
});
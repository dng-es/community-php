// JavaScript Document
var page_num = 1,
	id_album = 0;		

function getImages(){
	$.ajax({
	url: "includes/modules/fotos/pages/fotos-load-ajax.php",
	data: {pag: page_num, id: id_album, f: decodeURIComponent(find_text)},
	cache: false,
	success: function(html){
		if(html)			{
		    $("#photos").append(html);
		    page_num = page_num +1;
		}
		else{
			$('#cargando-infinnite').hide();
			$('#cargando-infinnite-end').show();
		}
	}
	});	
}

$(window).scroll(function(){
	/*$(".footer").outerHeight()*/
    if( ($(window).scrollTop()) == ($(document).height() - $(window).height()))    {
        getImages();
    }
});

jQuery(document).ready(function(){
	BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});

	id_album = $.getURLParam("id");
	find_text = $.getURLParam("find_reg");

	$('#nombre-foto').bootstrapFileInput();

	getImages();

	$('#cargando-infinnite').click(function(e){
		e.preventDefault();
		getImages();
	});

	$("#photos").on("mouseenter", "div a", function(){
		$(this).next(".photo-info").stop().slideToggle();
	}).on("mouseleave", "div a", function(){
		$(this).next(".photo-info").stop().slideToggle();
	});

	$("#photos").on("mouseenter", ".photo-info", function(){
		$(this).stop().slideToggle();
	}).on("mouseleave", ".photo-info", function(){
		$(this).stop().slideToggle();
	});	


	$("#photos").on("click", "div a.trigger-foto-comments", function(e){
		e.preventDefault();
		var id_file = $(this).attr("data-id");
		$(".modal-body").load("includes/modules/fotos/pages/fotos-comments-ajax.php?id=" + id_file,function(){
			$('#myModal').modal('show');
		})
	});
	
	$("#foto-submit").click(function(evento){
	   $("#alertas-participa").html("");
	   $("#alertas-participa").css("display","none");
	   
	   var resultado_ok=true;   
	   var texto_alerta="";
		if (jQuery.trim($("#titulo-foto").val())=="") 
		{
			 texto_alerta += "Debes intruducir un titulo de la foto. ";
			 resultado_ok=false;
		}
		
		if (jQuery.trim($("#nombre-foto").val())=="") 
		{
			 texto_alerta += "Debes insertar una foto.";
			 resultado_ok=false;
		}
				
		if (resultado_ok==true) 
		{
			$("#foto-form").submit();
		}
		else
		{			
			 $("#alertas-participa").html(texto_alerta);	 
			 $("#alertas-participa").fadeIn();
			 $("#alertas-participa").css("display","block");
		}		
	});
});
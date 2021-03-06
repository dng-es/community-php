// JavaScript Document
var page_num = 1,
	id_album = 0,
	tag = '',
	id_promocion = 0,
	nick = "";

function getImages(){
	$.ajax({
		url: "app/modules/fotos/pages/fotos-load-ajax.php",
		data: {pag: page_num,tags: tag , id: id_album, idp: id_promocion, f: decodeURIComponent(find_text), n: nick},
		cache: false,
		success: function(html){
			if(html){
				$("#photos").append(html);
				page_num = page_num + 1;
			}
			else{
				$('#cargando-infinnite').hide();
				$('#cargando-infinnite-end').show();
			}
			$(".menu-hidden-container").css({"height" : $("#container-content").outerHeight()});
		}
	});
}

$(window).scroll(function(){
	/*$(".footer").outerHeight()*/
	if( ($(window).scrollTop()) == ($(document).height() - $(window).height())){
		getImages();
	}
});

/*$(window).on('load', function() {
    $('.gallery-img').addClass(function() {
        if (this.height === this.width) {
            return 'square';
        } else if (this.height > this.width) {
            return 'tall';
        } else {
            return 'wide';
        }
    });
});*/

jQuery(document).ready(function(){
	id_album = $.getURLParam("id");
	tag = $.getURLParam("tag");
	id_promocion = $.getURLParam("idp");
	nick = $.getURLParam("n");
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

	$("#photos").on("load", "div a img", function(){
		console.log($(this).top());
	});

	$("#photos").on("mouseenter", ".photo-info", function(){
		$(this).stop().slideToggle();
	}).on("mouseleave", ".photo-info", function(){
		$(this).stop().slideToggle();
	});

	$("#photos").on("click", "div a.trigger-foto-comments", function(e){
		e.preventDefault();
		var id_file = $(this).attr("data-id");
		$("#fotosModal .modal-body").load("app/modules/fotos/pages/fotos-comments-ajax.php?id=" + id_file,function(){
			$('#fotosModal').modal('show');
		})
	});

	$("#createAlbum").click(function(e){
		e.preventDefault();
		$('#albumModal').modal('show');
	});

	$("#formAlbum").submit(function(){
		$.ajax({
			type: 'POST',
			url: 'app/modules/fotos/pages/album_process.php',
			cache: false,
			data: $('#formAlbum').serialize(),
			success: function(data) {
				var response = $.parseJSON(data);
				swal({
					title: $("#albumModalLabel").html(),
					text: response.description,
					type: response.message,
					confirmButtonColor: "#000",
					confirmButtonText: "Cerrar"
				}, function(){
					if (response.message == 'success') {
						$('#albumModal').modal('hide');
						//resfrescar combo

						$.ajax({
							type: 'get',
							url: 'app/modules/fotos/pages/album_process.php',
							cache: false,
							data: {"albums" : true},
							success: function(data) {
								$('#id_album').html(data);
								
							}
						});
					}
				});
			}
		});
		return false;
	});

	$("#foto-form").submit(function(evento){
		$("#alertas-participa").css("display", "none");
		var form_ok = true;
		if (jQuery.trim($("#titulo-foto").val()) == ""){
			$("#alertas-participa").fadeIn().css("display", "block");
			form_ok = false;
		}

		if (jQuery.trim($("#nombre-foto").val()) == ""){
			$("#alertas-participa").fadeIn().css("display", "block");
			form_ok = false;
		}

		return form_ok;
	});
});
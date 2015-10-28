// JavaScript Document
jQuery(document).ready(function(){
	var maxsize_textarea = 600;
	
	$(".jtextareaComentar").jtextarea({maxSizeElement: maxsize_textarea,
				cssElement: { display: "inline-block", color: "#666666", background: "transparent"}});


	$(".comment-info .label").tooltip({
		placement: "bottom",
		container: "body",
	});
	
	$("#coment-form").submit(function(evento){
		var resultado_ok = true;
		if (jQuery.trim($('#texto-comentario').removeClass("input-alert").val()) == ""){
			$('#texto-comentario').addClass("input-alert").attr("placeholder", $('#texto-comentario').prop("title")).focus();
			 resultado_ok = false;
		}
		if (document.getElementById('texto-comentario').value.length > maxsize_textarea){
			 resultado_ok = false;
		}
		return resultado_ok;
	});

	$(".comment-reply-trigger").click(function(e){
		e.preventDefault();
		$(this).closest(".comment-info").next(".comment-reply").slideToggle();
	});

	$(".comment-reply-form").submit(function(evento){
		$(".alert-message").css("display", "none");

		var resultado_ok = true,
		elem = $(this).find('textarea');
		if (jQuery.trim(elem.val()) == ""){
			elem.next(".alert-message").fadeIn().css("display", "block");
			resultado_ok = false;
		}
		return resultado_ok;
	});
});


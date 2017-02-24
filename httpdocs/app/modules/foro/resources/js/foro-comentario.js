// JavaScript Document
jQuery(document).ready(function(){
	var maxsize_textarea = 600;

	$("#texto-comentario").bootstrapTextArea({
		title: "Nuevo comentario", 
		saveText: "Aceptar",
		zoomText: "Ampliar",
		rows: 20,
		icon: "fa fa-pencil",
		autoexpand: true,
		maxSizeElement: maxsize_textarea,
		counter: true,
		counterText: "Caracteres",
		counterCss: { display: "inline-block", color: "#666666", background: "transparent"}
	});
	
	// $(".jtextareaComentar").jtextarea({maxSizeElement: maxsize_textarea,
	// 			cssElement: { display: "inline-block", color: "#666666", background: "transparent"}});

	$(".comment-info .label").tooltip({
		placement: "bottom",
		container: "body",
	});
	
	$("#coment-form").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($('#texto-comentario').removeClass("input-alert").val()) == ""){
			$('#texto-comentario').addClass("input-alert").attr("placeholder", $('#texto-comentario').prop("title")).focus();
			form_ok = false;
		}
		if (document.getElementById('texto-comentario').value.length > maxsize_textarea){
			form_ok = false;
		}
		return form_ok;
	});

	$(".comment-reply-trigger").click(function(e){
		e.preventDefault();
		$(this).closest(".comment-info").next(".comment-reply").slideToggle();
		$(this).closest(".comment-info").next(".comment-reply").find("form").find("textarea").focus();
	});

	$(".comment-reply-form").submit(function(evento){
		$(".alert-message").css("display", "none");

		var form_ok = true,
		elem = $(this).find('textarea');
		if (jQuery.trim(elem.val()) == ""){
			elem.next(".alert-message").fadeIn().css("display", "block");
			form_ok = false;
		}
		return form_ok;
	});
});


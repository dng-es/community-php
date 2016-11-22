jQuery(document).ready(function(){

	$(".abrir-modal").click(function(event){
		event.preventDefault()
		$(this).next("div .modal").modal();
	});

	$('input[type=file]').bootstrapFileInput();
	$("#area_puntos").numeric();
	$("#area_limite").numeric();

	$(".edit-tarea").click(function(){
		var id_tarea = $(this).attr("code-t"),
			desc_tarea = $(this).attr("code-d"),
			tit_tarea = $(this).attr("code-tit"),
			trigger_edit = $(this);
		createDialogTarea(id_tarea,desc_tarea,tit_tarea,trigger_edit);
	});

	$("#formData").submit(function(evento){
		var form_ok = true;
		if (jQuery.trim($("#area_nombre").removeClass("input-alert").val()) == ""){
			$('#area_nombre').addClass("input-alert").attr("placeholder", $('#area_nombre').data("alert")).focus();
			form_ok = false;
		}
		if (jQuery.trim($("#area_descripcion").removeClass("input-alert").val()) == ""){
			$('#area_descripcion').addClass("input-alert").attr("placeholder", $('#area_descripcion').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#area_puntos").removeClass("input-alert").val()) == ""){
			$('#area_puntos').addClass("input-alert").attr("placeholder", $('#area_puntos').data("alert")).focus();
			form_ok = false;
		}

		if (jQuery.trim($("#area_limite").removeClass("input-alert").val()) == ""){
			$('#area_limite').addClass("input-alert").attr("placeholder", $('#area_limite').data("alert")).focus();
			form_ok = false;
		}
	
		if (jQuery.trim($("#area_canal").removeClass("input-alert").val()) == ""){
			$('#area_canal').addClass("input-alert").attr("placeholder", $('#area_canal').data("alert")).focus();
			form_ok = false;
		}
		return form_ok;
	});

	$("#SubmitGrupo").click(function(evento){  
		$(".alert-message").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#grupo_nombre").val()) == ""){
			$("#grupo-alert").fadeIn().css("display","block");
			form_ok = false;
		}
		if (form_ok){
			$("#formNewGrupo").submit();
		}
	});

	$("#SubmitTarea").click(function(evento){
		$(".alert-message").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#tarea_titulo").val()) == ""){
			$("#tarea-titulo-alert").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (jQuery.trim($("#tarea_descripcion").val()) == ""){
			$("#tarea-descripcion-alert").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (jQuery.trim($("#fichero-tarea").val()) == "" && $("#tipo:last").attr("checked") == true){
			$("#fichero-tarea-alert").fadeIn().css("display", "block");
			form_ok = false;
		}
		if (form_ok){
			$("#formNewTarea").submit();
		}
	});
});

function createDialogTarea(id_tarea,desc_tarea,tit_tarea,trigger_edit){
	$("#dialog-message:ui-dialog" ).dialog("destroy");
	$("#edit-tit").html(tit_tarea);
	$("#edit-desc").val(desc_tarea);
	$("#edit-id-tarea").val(id_tarea);
	$("#edit-desc-alert").css("display","none");
	$("#dialog-message" ).dialog({
		modal: true,
		show: "fold",
		hide: "scale",
		width: 560,
		height: 290,
		resizable: false,
		title:"modificar datos de la tarea",
		dialogClass: "dialog-alert-info",
		buttons: [
				{text:"guardar cambios", class:'dialog-message-button', click:function(){
					$("#edit-desc-alert").html("").css("display","none");
				var form_ok = true;

				if (jQuery.trim($("#edit-desc").val()) == ""){
					$("#edit-desc-alert").fadeIn().css("display","block");
					form_ok = false;
				}

				if (form_ok){
					var new_desc = jQuery.trim($("#edit-desc").val());
					$.ajax({
						type: 'POST',
						url: 'admin-area-edit-t.php',
						data: {tarea : id_tarea,descripcion:new_desc},
						// Mostramos un mensaje con la respuesta de PHP
						success: function(data){
							if (data == 'ok'){
								trigger_edit.attr("code-d", new_desc);
								$("#dialog-message:ui-dialog" ).dialog("destroy");
							}
						}
					});
				}

			} },
			{text: "cerrar",class: 'dialog-message-button', click: function(){ 
				$(this).dialog( "close" );} 
			}
	]
	});
}
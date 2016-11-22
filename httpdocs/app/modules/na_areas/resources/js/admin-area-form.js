jQuery(document).ready(function(){	
	$(".area-detalle").wrapInner("<div class='area-detalle-out' />");

	$("#SubmitData").click(function(evento){  
		$(".alert-message").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#pregunta_texto").val()) == ""){
			 $("#pregunta-alert").fadeIn().css("display", "block");
			 form_ok = false;
		}
		if (form_ok){
			$("#formData").submit();
		}
	});

	$("#pregunta_tipo").change(function(){
		var tipo = $("#pregunta_tipo").val();
		if (tipo == "texto"){
			$("#container-respuestas").hide();
		}
		else{
			$("#container-respuestas").show();
		}
	});

	$("#agregar-respuestas").click(function(e){
		e.preventDefault();
		var indice = parseInt($("#contador-respuestas").val());
		
		var original_texto = document.getElementById("textoRespuesta1");
		var nuevo_texto = original_texto.cloneNode(true);
		var nuevo_texto_id = "textoRespuesta" + (indice + 1);
		nuevo_texto.id = nuevo_texto_id;
		destino = document.getElementById("container-respuestas");
		destino.appendChild(nuevo_texto);
		$("#" + nuevo_texto_id).text("Respuesta" + (indice + 1) + ": ");

		var original = document.getElementById("respuesta1");
		var nuevo = original.cloneNode(true);
		var nuevo_id = "respuesta" + (indice + 1);
		nuevo.id = nuevo_id;
		nuevo.name = nuevo_id;
		destino = document.getElementById("container-respuestas");
		destino.appendChild(nuevo);
		$("#" + nuevo_id).val("").focus();

		$("#contador-respuestas").val(indice + 1);
	});
});
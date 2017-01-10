jQuery(document).ready(function(){	
	$("#SubmitData").click(function(evento){
		$(".alert-message").css("display","none");
		var form_ok = true;
		if (jQuery.trim($("#pregunta_texto").val()) == ""){
			$("#pregunta-alert").fadeIn().css("display","block");
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
		else if(tipo=='unica'){
			$("#container-respuestas").show();
			$(".radioContainer").show();
			$(".checkboxContainer").hide();
		}
		else{
			$("#container-respuestas").show();
			$(".radioContainer").hide();
			$(".checkboxContainer").show();
		}
	});

	$("#agregar-respuestas").click(function(e){
		e.preventDefault();
		var tipo = $("#pregunta_tipo").val();
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
		$("#" + nuevo_id).val("");
		$("#" + nuevo_id).focus();

		var original_radio=document.getElementById("radioRespuesta1");
		var nuevo_radio=original_radio.cloneNode(true);
		var nuevo_radio_id="radioRespuesta"+(indice+1);
		//nuevo_radio.id = nuevo_radio_id;
		//nuevo_radio.name = nuevo_radio_id;
		nuevo_radio.value = (indice+1);
		nuevo_radio.className = "radioForm"
		destino=document.getElementById("container-respuestas");
		var container_radio = document.createElement("div");
		container_radio.className = "radioContainer";
		destino.appendChild(container_radio);
		container_radio.appendChild(nuevo_radio);
		var texto_radio_content = document.createTextNode(" Respuesta correcta");
		container_radio.appendChild(texto_radio_content);
		var separator_radio = document.createElement("hr");
		container_radio.appendChild(separator_radio);
		
		var original_check=document.getElementById("checkRespuesta1");
		var nuevo_check=original_check.cloneNode(true);
		var nuevo_check_id="checkRespuesta"+(indice+1);
		nuevo_check.id = nuevo_check_id;
		nuevo_check.name = nuevo_check_id;
		nuevo_check.className = "checkForm"
		destino=document.getElementById("container-respuestas");
		var container_check = document.createElement("div");
		container_check.className = "checkboxContainer";
		destino.appendChild(container_check);
		container_check.appendChild(nuevo_check);
		var texto_check_content = document.createTextNode("Respuesta correcta"); 
		container_check.appendChild(texto_check_content);
		var separator_check = document.createElement("hr");
		container_check.appendChild(separator_check);

		if (tipo=='multiple') container_radio.style.display = "none";
		if (tipo=='unica') container_check.style.display = "none";

		$("#contador-respuestas").val(indice + 1);
	});
});
// JavaScript Document
jQuery(document).ready(function(){

	DragDrop();

	function DragDrop(){

		var drag1 = document.getElementById("drag1");
		var drag2 = document.getElementById("drag2");
		var drop1 = document.getElementById("drop1");
		var drop2 = document.getElementById("drop2");

		drag1.ondragstart = function(e){
			//Guardamos el id del elemento para transferirlo al elemento drop
			//Contenido es una clave que nos permitirá acceder al valor asignado
			e.dataTransfer.setData("contenido", e.target.id);
		}

		drag2.ondragstart = function(e){
			//Guardamos el id del elemento para transferirlo al elemento drop
			//Contenido es una clave que nos permitirá acceder al valor asignado
			e.dataTransfer.setData("contenido", e.target.id);
		}

		drop1.ondragover = function(e){
			//Cancelar el evento que impide que podamos soltar el elemento drag
			e.preventDefault();
		}

		drop1.ondrop = function(e){
			//Obtenemos los datos a través de la clave contenido, en este caso el id
			var id = e.dataTransfer.getData("contenido");
			e.target.appendChild(document.getElementById(id));
		}

		drop2.ondragover = function(e){
			//Cancelar el evento que impide que podamos soltar el elemento drag
			e.preventDefault();
		}

		drop2.ondrop = function(e){
			//Obtenemos los datos a través de la clave contenido, en este caso el id
			var id = e.dataTransfer.getData("contenido");
			e.target.appendChild(document.getElementById(id));
		}
	}
});
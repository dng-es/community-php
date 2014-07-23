<?php
function archivoBlog($elements){
	echo '<div class="btn-group btn-block">
			  <button type="button" class="btn btn-default desplegable">---Seleccionar archivo---</button>
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			    <span class="sr-only">Toggle Dropdown</span>
			  </button>
			  <ul class="dropdown-menu" role="menu">';
				foreach($elements as $element):
					$nombre=strftime("%B",mktime(0, 0, 0, $element['mes'], 1, 2000));
					//echo '<option value="'.$element['mes'].','.$element['ano'].'">'.ucfirst($nombre).' '.$element['ano'].' ('.$element['contador'].')</option>';
					echo '<li><a href="?page=blog-list&a='.$element['ano'].'&m='.$element['mes'].'">'.ucfirst($nombre).' '.$element['ano'].' ('.$element['contador'].')</a></li>';
				endforeach;
	echo ' 	  </ul>
		  </div>';	
}

function entradasBlog($elements){
	foreach($elements as $element):		
		echo '<div class="blog-recientes">
				<div class="modal-img-container">
					<a href="?page=blog&id='.$element['id_tema'].'"><img src="images/foro/'.$element['imagen_tema'].'" title="'.$element['nombre'].'" /></a>
				</div>
				<div>
					<a href="?page=blog&id='.$element['id_tema'].'">'.$element['nombre'].'</a><br />
					<span>'.dateLong($element['date_tema']).'</span>
				</div>
			  </div>';
	endforeach;	
}

function searchBlog(){
	echo '<form class="form-inline" role="form" action="?page=blog-list" method="post" id="form-blog">
				<div class="form-group">
					<label class="sr-only" for="find_reg">buscar</label>
					<input class="form-control" id="find_reg" name="find_reg" placeholder="buscar en el blog">
				</div>
				<button type="submit" class="btn btn-default">Buscar</button>
			</form>';
}

function categoriasBlog($elements){
	echo '<ul class="lista-lateral">';
	foreach($elements as $element):
		echo '<li><a href="?page=blog-list&c='.$element.'">'.ucfirst($element).'</a></li>';
	endforeach;	
	echo '</ul>';
}
?>
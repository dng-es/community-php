<?php
function archivoBlog($elements){
	echo '<div class="btn-group btn-block">
			  <button type="button" class="btn btn-default desplegable">---'.strTranslate("Choose_archive").'---</button>
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			    <span class="caret"></span>
			    <span class="sr-only">Toggle Dropdown</span>
			  </button>
			  <ul class="dropdown-menu" style="width:96%" role="menu">';
				foreach($elements as $element):
					$nombre=strftime("%B",mktime(0, 0, 0, $element['mes'], 1, 2000));
					//echo '<option value="'.$element['mes'].','.$element['ano'].'">'.ucfirst($nombre).' '.$element['ano'].' ('.$element['contador'].')</option>';
					echo '<li><a href="blog-list?a='.$element['ano'].'&m='.$element['mes'].'">'.ucfirst($nombre).' '.$element['ano'].' ('.$element['contador'].')</a></li>';
				endforeach;
	echo ' 	  </ul>
		  </div>';
}

function entradasBlog($elements){
	foreach($elements as $element):		
		echo '<div class="media-preview-container">
				<a href="blog?id='.$element['id_tema'].'">
				<img src="images/foro/'.$element['imagen_tema'].'" class="media-preview" alt="'.$element['nombre'].'" /></a>
				<div>
					<a href="blog?id='.$element['id_tema'].'">'.$element['nombre'].'</a><br />
					<span>'.getDateFormat($element['date_tema'], "LONG").'</span>
				</div>
			  </div>';
	endforeach;	
}

function searchBlog(){ ?>
	<form role="form" action="blog-list" method="post" id="form-blog">
		<div class="input-group">
			<label class="sr-only" for="find_reg"><?php echo strTranslate("Search");?></label>
			<input class="form-control" id="find_reg" name="find_reg" placeholder="<?php echo strtolower(strTranslate("Search"));?>">
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
			</div>
		</div>
	</form>
<?php }

function categoriasBlog($elements){
	echo '<ul class="lista-lateral">';
	foreach($elements as $element):
		echo '<li><a href="blog-list?c='.$element.'">'.ucfirst($element).'</a></li>';
	endforeach;	
	echo '</ul>';
}
?>
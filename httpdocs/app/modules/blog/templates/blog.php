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
					$nombre = strftime("%B",mktime(0, 0, 0, $element['mes'], 1, 2000));
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
					<span><small>'.getDateFormat($element['date_tema'], "LONG").'</small></span>
				</div>
			  </div>';
	endforeach;
}

function searchBlog(){ ?>
	<form role="form" action="blog-list" method="get" id="form-blog">
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

function nextPost($id_tema, $filtro_blog){
	$foro = new foro();
	$siguiente_disabled = "";
	$siguiente = $foro->getTemas($filtro_blog." AND activo=1 AND ocio=1 AND id_tema<".$id_tema." ORDER BY id_tema DESC LIMIT 1");
	if (count($siguiente) != 1){
		$siguiente_disabled = "disabled";
		$siguiente_enlace = "#";
	}
	else $siguiente_enlace = 'blog?id='.$siguiente[0]['id_tema']; ?>
	<li class="next <?php echo $siguiente_disabled ;?>"><a href="<?php echo $siguiente_enlace;?>"><?php echo strTranslate("Next_post");?> &rarr;</a></li>
	<?php 
}

function previousPost($id_tema, $filtro_blog){
	$foro = new foro();
	$anterior_disabled = "";
	$anterior = $foro->getTemas($filtro_blog." AND activo=1 AND ocio=1 AND id_tema>".$id_tema." ORDER BY id_tema ASC  LIMIT 1");
	if (count($anterior)!=1){
		$anterior_disabled = "disabled";
		$anterior_enlace = "#";
	}
	else $anterior_enlace = "blog?id=".$anterior[0]['id_tema'];
	?>
	<li class="previous <?php echo $anterior_disabled;?>"><a href="<?php echo $anterior_enlace;?>">&larr; <?php echo strTranslate("Previous_post");?></a></li>
	<?php 
}
?>
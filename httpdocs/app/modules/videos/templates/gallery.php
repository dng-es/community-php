<?php
templateload("tipuser", "users");
templateload("player", "videos");

/**
 * Show video gallery
 * @param  array 		$elements     	Arrays of elements to show
 * @param  boolean 		$rating       	Elements can be rating (votes, like it, ...)
 * @param  int 			$id_promocion 	Id promcion/reto. 0 if gallery does not belong to any promocion/reto
 * @param  int 			$cols         	Number of cols to be shown
 */
function galleryVideos($elements, $rating, $id_promocion, $cols){
	$columna = 1;
	if ($cols == 3){ $grid_cols = "col-md-4";}
	else{$grid_cols = "col-md-3";}
	foreach($elements as $element):
		if ($columna == 1) echo '<div class="row">';
		echo '<div class="'.$grid_cols.'">';
		showVideoGaleria($element, $rating, 0, $id_promocion);
		echo "</div>";
		if ($columna == $cols){
			echo '</div>';
			$columna = 0;
		}
		$columna++;
	endforeach;
	if ($columna <= $cols and $columna > 1) echo '</div>';
}

/**
 * Show video gallery
 * @param  array 		$file_galeria   Video to show
 * @param  boolean 		$rating       	Elements can be rating (votes, like it, ...)
 * @param  int 			$id_promocion 	Id promcion/reto. 0 if gallery does not belong to any promocion/reto
 */
function showVideoGaleria($file_galeria, $rating = true, $id_promocion = 0){
	
	$videos = new videos();	
	$title = (strlen($file_galeria['titulo']) > 40 ? substr($file_galeria['titulo'], 0, 38)."..." : $file_galeria['titulo']);
	$nick = ($file_galeria['nick'] == "" ? "(sin nick)" : $file_galeria['nick']);

	//SOLO SI SE PERMITEN VOTACIONES SE MUESTRA EL LINK PARA VOTAR
	global $page;
	$num_pag = (isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1);
	if ($page == 'reto') $page='reto?id='.$file_galeria['id_promocion'];
	else $page = $page.'?pag='.$num_pag;

	$destination = "";
	if (isset($_POST['find_reg']) and $_REQUEST['find_reg'] != "") $destination .= "&f=".$_POST['find_reg'];
	if (isset($_REQUEST['f']) and $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
	if (isset($_REQUEST['pag']) and $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];
	?>

	<div class="thumbnail">
		<?php playVideo("VideoGaleria".$file_galeria['id_file'], PATH_VIDEOS.$file_galeria['name_file'], 240, 180);?>
		<div class="caption">
			<div><?php echo $title;?></div>
			<div>
				<?php 
				echo '<span class="text-primary"><b>'.$nick.'</b> - '.getDateFormat($file_galeria['date_video'], "SHORT").'</span>';
				userTip($file_galeria['id_file'], $file_galeria, userEstrellas($file_galeria['participaciones']), 0);
				?>
			</div>
			<div>
				<?php 
				if ($file_galeria['tipo_video'] != "") echo ' - '.$file_galeria['tipo_video'].'</span>';
				if ($rating) $votes = ' <a href="'.$page.'&id='.$id_promocion.'&idvv='.$file_galeria['id_file'].$destination.'" title="'.strTranslate("Vote_video").'" class="fa fa-heart"></a> '.$file_galeria['videos_puntos'];
				else $votes = ' <span class="fa fa-heart"></span> '.$file_galeria['videos_puntos'];
				echo $votes;
				if ($_SESSION['user_perfil'] == 'admin') echo ' <span class="text-primary"><b>id:</b></span> '.$file_galeria['id_file'];
				?>
			</div>
		</div>
	</div>
	<?php
}
?>
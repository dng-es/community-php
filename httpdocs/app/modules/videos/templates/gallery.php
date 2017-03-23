<?php
templateload("tipuser", "users");
templateload("player", "videos");

/**
 * Show video gallery
 * @param  array 		$elements     	Arrays of elements to show
 * @param  boolean 		$rating       	Elements can be rating (votes, like it, ...)
 * @param  int 			$id_promocion 	Id promcion/reto. 0 if gallery does not belong to any promocion/reto
 * @param  int 			$cols         	Number of cols to be shown
 * @return								HTML gallery
 */
function galleryVideos($elements, $rating, $id_promocion, $cols){
	$columna = 1;
	if ($cols == 3) $grid_cols = "col-md-4";
	else $grid_cols = "col-md-3";
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
	if ($columna <= $cols && $columna > 1) echo '</div>';
}

/**
 * Show carousel
 * @param  array 		$elements   	Videos to show
 * @param  string 		$id_carousel	ID crousel
 * @param  string 		$tag 			Carousel tag
 * @return								HTML carousel
 */
function showVideoCarousel($elements, $id_carousel, $tag = ''){ ?>
	<div class="carousel slide infinite" id="<?php echo $id_carousel;?>">
		<div class="carousel-inner">
			<?php foreach ($elements['items'] as $key=>$element):?>
			<div data-limit="<?php echo $elements['total_reg'];?>" class="item <?php echo ($key == 0 ? 'active' : '');?>">
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
					<?php showVideoGaleriaSimple($element, $tag);?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
		<?php if ($elements['total_reg'] > 6):?>
		<a class="left carousel-control" href="#<?php echo $id_carousel;?>" data-slide="prev"><i class="control-icon glyphicon glyphicon-chevron-left"></i></a>
		<a class="right carousel-control" href="#<?php echo $id_carousel;?>" data-slide="next"><i class="control-icon glyphicon glyphicon-chevron-right"></i></a>
		<?php endif;?>
	</div>
	<hr />
<?php }

/**
 * Show video gallery simple
 * @param  array 		$element   		Video to show
 * @param  string		$tag 			Video tag
 * @return								HTML carousel item
 */
function showVideoGaleriaSimple($element, $tag = ''){ ?>
	<a href="videos?id=<?php echo $element['id_file'];?>&tag=<?php echo $tag;?>">
	<img src="<?php echo PATH_VIDEOS.$element['name_file'];?>.jpg" width="100%" alt="<?php echo prepareString($element['titulo']);?>" />
	</a>
	<a class="slide-info-title" href="videos?id=<?php echo $element['id_file'];?>&tag=<?php echo $tag;?>"><?php echo $element['titulo'];?></a>
	<p class="slide-info"><?php echo getDateFormat($element['date_video'], "LONG");?></p>
	<!-- <a class="slide-info" href="user-profile?n=<?php //echo $element['nick'];?>">
		<span class="fa-stack">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-user fa-stack-1x fa-inverse"></i>
		</span> <?php //echo $element['nick'];?><br />
	</a> -->
	<a class="slide-info" href="user-profile?n=<?php echo $element['nick'];?>">
		<img src="<?php echo usersController::getUserFoto($element['foto']);?>" class="slide-user" />
		 <?php echo $element['nick'];?>
	</a>
<?php }

/**
 * Show video gallery
 * @param  array 		$file_galeria   Video to show
 * @param  boolean 		$rating       	Elements can be rating (votes, like it, ...)
 * @param  int 			$id_promocion 	Id promcion/reto. 0 if gallery does not belong to any promocion/reto
 * @return								HTML thumbnail
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
	if (isset($_POST['find_reg']) && $_REQUEST['find_reg'] != "") $destination .= "&f=".$_POST['find_reg'];
	if (isset($_REQUEST['f']) && $_REQUEST['f'] != "") $destination .= "&f=".$_REQUEST['f'];
	if (isset($_REQUEST['pag']) && $_REQUEST['pag'] != "") $destination .= "&pag=".$_REQUEST['pag'];
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
<?php } ?>
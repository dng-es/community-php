<?php
/**
 * Show Photo gallery
 * @param  	Array 		$elements 		Photo items
 * @param  	Boolean		$rating 		Las fotos pueden o no ser votadas
 * @param  	Int 		$id_promocion	Id de la promocion de la foto
 * @param  	String 		$destination 	Pagina de destino
 * @param  	Boolean		$comments 		Se muestra o no el numero de comentarios
 * @param  	Int 		$id_album 		Id del album al que pertenecen las fotos
 * @param  	String 		$tag 			Tags empleadas en el link
 * @return 	String       				HTML panel
 */
function galleryPhotos($elements, $rating, $id_promocion, $destination = "fotos", $comments = true, $id_album = 0, $tag = ''){
	foreach($elements as $element):
		showFotoGaleria($element, $rating, $id_promocion, $destination, $comments, $id_album, $tag);
	endforeach;
}

/**
 * Show Photo gallery item
 * @param  	Array 		$file_galeria 	Photo item
 * @param  	Boolean		$rating 		Las fotos pueden o no ser votadas
 * @param  	Int 		$id_promocion	Id de la promocion de la foto
 * @param  	String 		$destination 	Pagina de destino
 * @param  	Boolean		$comments 		Se muestra o no el numero de comentarios
 * @param  	Int 		$id_album 		Id del album al que pertenecen las fotos
 * @param  	String 		$tag 			Tags empleadas en el link
 * @return 	String       				HTML panel
 */
function showFotoGaleria($file_galeria, $rating = true, $id_promocion = 0, $destination = "fotos", $comments = true, $id_album = 0, $tag = ''){
	$titulo = (strlen($file_galeria['titulo']) > 30 ? substr($file_galeria['titulo'], 0, 28)."..." : $file_galeria['titulo']);
	$num_comentarios = connection::countReg("galeria_fotos_comentarios", " AND id_file=".$file_galeria['id_file']." AND estado=1 ");
	$nick = ($file_galeria['nick'] == "" ? "(sin nick)" : $file_galeria['nick']);

	echo '<div>
			<a href="#" data-id="'.$file_galeria['id_file'].'" class="trigger-foto-comments">
			<img class="gallery-img" src="'.PATH_FOTOS.$file_galeria['name_file'].'" alt="'.prepareString($file_galeria['titulo']).'" /></a>
			<div class="photo-info">';
	if ($comments == true) echo '<span>'.$num_comentarios.' <i class="fa fa-comment"></i></span>';
	echo '		<p><a target="_blank" href="'.PATH_FOTOS.$file_galeria['name_file'].'" title="'.strTranslate("Full_screen").'" ><i class="fa fa-desktop"></i></a> '.$titulo.' </p>
			</div>
			<span class="photo-likes">';
	if ($rating){echo ' <a href="'.$destination.'?id='.$id_album.'&tags='.$tag.'&idp='.$id_promocion.'&idvf='.$file_galeria['id_file'].'"  title="'.strTranslate("Photo_vote").'">'.$file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span></a>';}
	else {echo $file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span>';}
	echo '</span>
	</div>';
}
?>
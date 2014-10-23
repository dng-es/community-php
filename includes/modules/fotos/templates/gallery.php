<?php

//templateload("tipuser","users");

function galleryPhotos($elements, $rating, $id_promocion, $cols){
	foreach($elements as $element):
	     showFotoGaleria($element,$rating,$id_promocion);
	endforeach;
}

function showFotoGaleria($file_galeria, $rating=true, $reto=0, $pagina = "fotos"){
	$titulo =(strlen($file_galeria['titulo'])>30 ? substr($file_galeria['titulo'],0,28)."..." : $file_galeria['titulo']);
	$num_comentarios = connection::countReg("galeria_fotos_comentarios", " AND id_file=".$file_galeria['id_file']." AND estado=1 ");	
	$nick = ($file_galeria['nick']=="" ? "(sin nick)" : $file_galeria['nick']);
	
	echo '<div>
			<a href="#" data-id="'.$file_galeria['id_file'].'" class="trigger-foto-comments">
			<img src="'.PATH_FOTOS.$file_galeria['name_file'].'" alt="'.$file_galeria['titulo'].'" /></a>
			<div class="photo-info">
				<span>'.$num_comentarios.' <i class="fa fa-comment"></i></span>
				<p><a target="_blank" href="'.PATH_FOTOS.$file_galeria['name_file'].'" title="pantalla completa" ><i class="fa fa-desktop"></i></a> '.$titulo.' </p>
			</div>
			<span class="photo-likes">';		
	if ($rating){echo ' <a href="?page='.$pagina.'&id='.$reto.'&idvf='.$file_galeria['id_file'].'"  title="votar foto">'.$file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span></a>';}
	else {echo $file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span>';}
	echo '</span>
	</div>';		  
}
?>
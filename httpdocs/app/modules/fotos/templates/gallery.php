<?php

//templateload("tipuser","users");

function galleryPhotos($elements, $rating, $id_promocion, $cols, $pagina = "fotos", $comments = true){
	foreach($elements as $element):
	     showFotoGaleria($element,$rating,$id_promocion, $pagina, $comments);
	endforeach;
}

function showFotoGaleria($file_galeria, $rating=true, $reto=0, $pagina = "fotos", $comments=true){
	$titulo =(strlen($file_galeria['titulo'])>30 ? substr($file_galeria['titulo'],0,28)."..." : $file_galeria['titulo']);
	$num_comentarios = connection::countReg("galeria_fotos_comentarios", " AND id_file=".$file_galeria['id_file']." AND estado=1 ");	
	$nick = ($file_galeria['nick']=="" ? "(sin nick)" : $file_galeria['nick']);
	
	echo '<div>
			<a href="#" data-id="'.$file_galeria['id_file'].'" class="trigger-foto-comments">
			<img class="gallery-img" src="'.PATH_FOTOS.$file_galeria['name_file'].'" alt="'.$file_galeria['titulo'].'" /></a>
			<div class="photo-info">';
	if ($comments==true) echo '<span>'.$num_comentarios.' <i class="fa fa-comment"></i></span>';
	echo '		<p><a target="_blank" href="'.PATH_FOTOS.$file_galeria['name_file'].'" title="'.strTranslate("Full_screen").'" ><i class="fa fa-desktop"></i></a> '.$titulo.' </p>
			</div>
			<span class="photo-likes">';		
	if ($rating){echo ' <a href="'.$pagina.'?id='.$reto.'&idvf='.$file_galeria['id_file'].'"  title="'.strTranslate("Photo_vote").'">'.$file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span></a>';}
	else {echo $file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span>';}
	echo '</span>
	</div>';		  
}
?>
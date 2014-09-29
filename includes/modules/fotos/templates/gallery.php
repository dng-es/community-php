<?php

//templateload("tipuser","users");

function galleryPhotos($elements, $rating, $id_promocion, $cols){
	$columna = 1;
	if ($cols == 3){ $grid_cols = "col-md-4";}
	else{$grid_cols = "col-md-3";}

	foreach($elements as $element):
	     //if ($columna ==1){echo '<div class="row">';}
	     //echo '<div style="width:40%;display:block;display:inline">';
	     showFotoGaleria($element,$rating,0,$id_promocion);
	     //echo "</div>";
	     // if ($columna == $cols){echo '</div>';$columna=0;}
	     // $columna++;
	endforeach;

	//if ($columna <= $cols and $columna>1){echo '</div>';}
}

function showFotoGaleria($file_galeria, $rating=true, $movil=0, $reto=0, $pagina = "fotos"){
	if (strlen($file_galeria['titulo'])>30){ $titulo = substr($file_galeria['titulo'],0,28)."...";}
	else {$titulo = $file_galeria['titulo'];}

	$num_comentarios = connection::countReg("galeria_fotos_comentarios", " AND id_file=".$file_galeria['id_file']." AND estado=1 ");
	
	$nick = $file_galeria['nick'];
	if ($nick==""){ $nick = "(sin nick)"; }
	
	echo '<div>
			<a href="#" data-id="'.$file_galeria['id_file'].'" class="trigger-foto-comments" >
			<img src="'.PATH_FOTOS.$file_galeria['name_file'].'" /></a>
			<div class="photo-info">
				<span>
					'.$num_comentarios.' <i class="fa fa-comment"></i>
				</span>
				<p>
				<a target="_blank" href="'.PATH_FOTOS.$file_galeria['name_file'].'" title="pantalla completa" ><i class="fa fa-desktop"></i></a> 
				'.$titulo.' 
				</p>
			</div>';
	
	echo '<span class="photo-likes">';		
	if ($rating){echo ' <a href="?page='.$pagina.'&id='.$reto.'&idvf='.$file_galeria['id_file'].'"  title="votar foto">'.$file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span></a>';}
	else {echo $file_galeria['fotos_puntos'].' <span class="fa fa-heart"></span>';}
	echo '</span>';			

	echo '</div>';		  
}
?>
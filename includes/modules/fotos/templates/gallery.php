<?php

templateload("tipuser","users");

function galleryPhotos($elements, $rating, $id_promocion, $cols){
	$columna = 1;
	if ($cols == 3){ $grid_cols = "col-md-4";}
	else{$grid_cols = "col-md-3";}
	foreach($elements as $element):
	     if ($columna ==1){echo '<div class="row">';}
	     echo '<div class="'.$grid_cols.'">';
	     showFotoGaleria($element,$rating,0,$id_promocion);
	     echo "</div>";
	     if ($columna == $cols){echo '</div>';$columna=0;}
	     $columna++;
	endforeach;
	if ($columna <= $cols and $columna>1){echo '</div>';}
}

function showFotoGaleria($file_galeria, $rating=true, $movil=0, $reto=0){
	if (strlen($file_galeria['titulo'])>30){ $titulo = ubstr($file_galeria['titulo'],0,28)."...";}
	else {$titulo = $file_galeria['titulo'];}
	
	$nick = $file_galeria['nick'];
	if ($nick==""){ $nick = "(sin nick)"; }
	
	echo '<div class="thumbnail">
			<a href="'.PATH_FOTOS.$file_galeria['name_file'].'" rel="prettyPhoto[gallery1]">
			<img title="'.$file_galeria['titulo'].'" src="'.PATH_FOTOS.$file_galeria['name_file'].'" /></a>
			<div class="caption">'.$titulo.'
  			<div class="img-info"><a id="a'.$file_galeria['id_file'].'" href="$a'.$file_galeria['id_file'].'Tip?width=350" 
			class="betterTip comunidad-color" title="Datos del usuario <em>'.$file_galeria['nick'].'</em>">
			<b>'.$nick.'</b></a> - '.strftime(DATE_FORMAT_SHORT,strtotime($file_galeria['date_foto'])).'</div>';							
	userTip($file_galeria['id_file'],$file_galeria,userEstrellas($file_galeria['participaciones']),$movil);				
			

			
	//SOLO SI SE PERMITEN VOTACIONES SE MUESTRA EL LINK PARA VOTAR
	global $page;
	if ($pagina=='reto'){$pagina='reto&id='.$file_galeria['id_promocion'];}
	else {$pagina=$page.'&pag='.$_REQUEST['pag'];}
	if ($rating){$me_gusta=' <a href="?page='.$pagina.'&id='.$reto.'&idvf='.$file_galeria['id_file'].'"  title="votar foto" class="fa fa-heart"></a> '.$file_galeria['fotos_puntos'];}
	else {$me_gusta=' <span class="fa fa-heart"></span> '.$file_galeria['fotos_puntos'];}
	echo $me_gusta;
	if ($_SESSION['user_perfil']=='admin'){ echo ' <span class="comunidad-color"><b>id:</b></span> '.$file_galeria['id_file'];}
	echo '</div></div>';		  
}
?>
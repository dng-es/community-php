<?php

templateload("tipuser","users");

function showComentarioPromocion($comentario_muro,$id_promocion,$votaciones=true,$movil=0){
	//respuestas al comentario
	$respuestas=users::countReg("muro_comentarios"," AND id_comentario_id=".$comentario_muro['id_comentario']." AND estado=1 ");
	echo '<div class="media">';
	userFicha($comentario_muro,$movil);
	echo '	<p><b>'.$comentario_muro['nick'].'</b> dice: ('.strftime(DATE_FORMAT_SHORT,strtotime($comentario_muro['date_comentario'])).')</p>
				<p>'.$comentario_muro['comentario'].'</p>';
				
				//SOLO SI SE PERMITEN VOTACIONES SE MUESTRA EL LINK PARA VOTAR
				if ($votaciones==true){
					$me_gusta=' <a class="fa fa-heart" href="?page=reto&id='.$id_promocion.'&idv='.$comentario_muro['id_comentario'].'" title="votar comentario"></a> '.$comentario_muro['votaciones'].'';}
				else {$me_gusta=' <span class="fa fa-heart"></span> '.$comentario_muro['votaciones'];}
				echo $me_gusta;
	echo '	</div>
			<hr />'; 
}
?>
<?php

function commentFoto($comentario,$destino="fotos-comentarios"){
	echo '<div class="media">';
	userFicha($comentario);
	$texto_id = ($_SESSION['user_perfil']=='admin' ? "id: ".$comentario['id_comentario'] : "");
	echo '		<p><b>'.$comentario['nick'].'</b> dice: ('.strftime(DATE_FORMAT_SHORT,strtotime($comentario['date_comentario'])).') '.$texto_id.'</p>
				<p>
				<a name="comentario-id-'.$comentario['id_comentario'].'" id="comentario-id-'.$comentario['id_comentario'].'"></a>
				</p>
				<p>'.$comentario['comentario'].'</p>
				<p>';				
	// echo '		<a class="trigger-voto fa fa-heart" href="#" data-id="'.$comentario['id_comentario'].'" title="votar comentario">
	// 			'.$comentario['votaciones'].'</a>
	// 			<span class="alert alert-danger"></span>';
	echo '		</p>';				
	echo '</div>';		
}
?>
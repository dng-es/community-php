<?php

templateload("tipuser","users");

function videoCommentGallery($comentarios, $destino = "videos-comentarios"){
	if (count($comentarios) > 0){
		foreach($comentarios as $comentario):
			videoComment($comentario, $destino);
		endforeach;	
	}
	else{
		echo '<br /><div class="alert alert-warning"><i class=" fa fa-info-circle"></i> Todavia no existen comentarios en este video. Se el primero en hacerlo!!</div>';
	}
}

function videoComment($comentario, $destino = "videos-comentarios"){
	echo '<div class="media">';
	userFicha($comentario);
	echo '		<p><b>'.$comentario['nick'].'</b> '.strTranslate("says").': ('.strftime(DATE_FORMAT_SHORT,strtotime($comentario['date_comentario'])).') '.$texto_id.'</p>
				<p>
				<a name="comentario-id-'.$comentario['id_comentario'].'" id="comentario-id-'.$comentario['id_comentario'].'"></a>
				</p>
				<p>'.$comentario['comentario'].'</p>
				<p>';				
	echo '		<a class="trigger-video fa fa-heart tooltip-top" href="?page='.$destino.'&idvc='.$comentario['id_comentario'].'" data-id="'.$comentario['id_comentario'].'" title="votar">
				'.$comentario['votaciones'].'</a>
				<span class="alert alert-danger"></span>';
	if ($_SESSION['user_perfil']=='admin') { echo ' <b>id:</b> '.$comentario['id_comentario'];}
	echo '		</p>';				
	echo '</div><hr />';		
}
?>
<?php
templateload("tipuser", "users");

function commentMuro($comment, $allow_reply = true){
	//respuestas al comentario
	$respuestas = connection::countReg("muro_comentarios", " AND id_comentario_id=".$comment['id_comentario']." AND estado=1 ");
	$votado = connection::countReg("muro_comentarios_votaciones", " AND id_comentario=".$comment['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
	if ($_SESSION['user_name'] == $comment['user_comentario']) $votado_user = 1;
	else $votado_user = 0;
	echo '<div class="media">';
	userFicha($comment);
	echo '	<p>
			<a href="user-profile?n='.$comment['nick'].'"><small>'.$comment['nick'].'</small></a>';
	echo '	<small><span class="date-format-ago" data-date="'.$comment['date_comentario'].'">'.getDateFormat($comment['date_comentario'], "DATE_TIME").'</span></small>';
	if ($_SESSION['user_canal'] == 'admin') echo '<br /><small>'.strTranslate("Channel").': '.$comment['canal_comentario'].'</small>';

	echo '	</p>
			<p id="texto-comentario-'.$comment['id_comentario'].'">'.showHtmlLinks($comment['comentario']).'</p>
			<div class="legend">
				<span class="muro-votado" id="'.$comment['id_comentario'].'" value="'.$votado.'"></span>
				<span class="muro-votado-user" id="user_'.$comment['id_comentario'].'" value="'.$votado_user.'"></span>
				<a href="#" class="murogusta fa fa-heart '.$comment['id_comentario'].'" 
					value="'.$comment['id_comentario'].'" 
					href="'.$comment['votaciones'].'" 
					title="'.strTranslate("Vote_comment").'">
					'.$comment['votaciones'].'
				</a>';
	if ($allow_reply):
	echo '		<span value="'.$comment['comentario'].'">
					<a href="#" class="responder-triger fa fa-comment" title="'.strTranslate("Reply").'" tipom="'.$comment['tipo_muro'].'" value="'.$comment['id_comentario'].'"> '.$respuestas.'</a>
				</span>
				
				<span style="margin-left:5px">
					<a href="muro-comentarios-respuestas?id='.$comment['id_comentario'].'" class="tooltip-top" title="'.strTranslate("Show_all_replies").'"> <span class="fa fa-sign-in"></span></a>
				</span>';
	endif;
	echo '	</div>
		</div>';
	echo '	<div id="muro-result-megusta'.$comment['id_comentario'].'" class="text-danger"></div>';
	echo '	<hr>';
}

function commentMuro2($comentario_muro){
		$votado = connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$comentario_muro['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
		if ($_SESSION['user_name'] == $comentario_muro['user_comentario']) $votado_user = 1;
		else $votado_user = 0;
		echo '<div class="media">
				<div class="pull-right text-primary">
					<span class="muro-votado" id="'.$comentario_muro['id_comentario'].'" value="'.$votado.'"></span>
					
					<span class="muro-votado-user" id="user_'.$comentario_muro['id_comentario'].'" value="'.$votado_user.'"></span>
					<span class="murogusta fa fa-heart '.$comentario_muro['id_comentario'].'" 
						value="'.$comentario_muro['id_comentario'].'" 
						href="'.$comentario_muro['votaciones'].'" 
						title="'.strTranslate("Vote_comment").'">
						'.$comentario_muro['votaciones'].'
					</span>
				</div>';
		userFicha($comentario_muro);
		echo '		<p class="text-primary"><b>'.$comentario_muro['nick'].'</b> <span class="date-format-ago" data-date="'.$comentario_muro['date_comentario'].'">'.getDateFormat($comentario_muro['date_comentario'], "DATE_TIME").'</span>:';
		//SOLO LOS ADMIN PUEDEN VER EL CANAL
		if ($_SESSION['user_canal'] == 'admin'){  echo ' ('.strTranslate("Channel").': '.$comentario_muro['canal_comentario'].')';}
		echo '		</p>
					<p id="texto-comentario-'.$comentario_muro['id_comentario'].'">'.$comentario_muro['comentario'].'</p>';

		echo '<div id="muro-result-megusta'.$comentario_muro['id_comentario'].'" class="text-danger"></div>';
		echo ' <hr>
			</div>';
}
?>
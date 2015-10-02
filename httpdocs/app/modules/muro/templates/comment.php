<?php

templateload("tipuser", "users");

function commentMuro($comment){
    global $page,$muro;
	//respuestas al comentario
	$respuestas = connection::countReg("muro_comentarios", " AND id_comentario_id=".$comment['id_comentario']." AND estado=1 ");
	$votado = connection::countReg("muro_comentarios_votaciones", " AND id_comentario=".$comment['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
	if ($_SESSION['user_name']==$comment['user_comentario']) $votado_user = 1;
	else $votado_user = 0;
	echo '<div class="media">';
	userFicha($comment);
	echo '	<p>
			<a href="user-profile?n='.$comment['nick'].'"><small>'.$comment['nick'].'</small></a>';
	echo ' 	<small><span class="date-format-ago" data-date="'.$comment['date_comentario'].'">'.getDateFormat($comment['date_comentario'], "DATE_TIME").'</span></small>';
    if ($_SESSION['user_perfil'] == 'admin' or $_SESSION['user_perfil'] == 'formador'){  
    	echo '<br /><small>'.strTranslate("Channel").': '.$comment['canal_comentario'].'</small>';
    }
    

	echo '	</p>
			<p id="texto-comentario-'.$comment['id_comentario'].'">'.showHtmlLinks($comment['comentario']).'</p>			
			<div class="legend">
				<span class="muro-votado" id="'.$comment['id_comentario'].'" value="'.$votado.'"></span>							
				<span class="muro-votado-user" id="user_'.$comment['id_comentario'].'" value="'.$votado_user.'"></span>
				<span class="murogusta fa fa-heart '.$comment['id_comentario'].'" 
					value="'.$comment['id_comentario'].'" 
					href="'.$comment['votaciones'].'" 
					title="'.strTranslate("Vote_comment").'">
					'.$comment['votaciones'].'
				</span>
				
				<span value="'.$comment['comentario'].'">
		  			<span class="responder-triger fa fa-comment" title="'.strTranslate("Reply").'" tipom="'.$comment['tipo_muro'].'" value="'.$comment['id_comentario'].'"> '.$respuestas.'</span>
				</span>
				
				<span style="margin-left:5px">				
			    	 <a href="muro-comentarios-respuestas?id='.$comment['id_comentario'].'" class="tooltip-top" title="'.strTranslate("Show_all_replies").'"> <span class="fa fa-sign-in"></span></a>
				</span>
			</div>
		</div>';
	echo '	<div id="muro-result-megusta'.$comment['id_comentario'].'" class="text-danger"></div>';
	echo '	<hr>';  
}
?>
<?php

templateload("tipuser","users");

function commentMuro($comment){
    global $page,$muro;
	if ($page=='muro_comentarios') {$pagina=$page.'&c='.$comment['tipo_muro'];}
	else {$pagina=$page;}
	//respuestas al comentario
	$respuestas = connection::countReg("muro_comentarios"," AND id_comentario_id=".$comment['id_comentario']." AND estado=1 ");
	$votado = connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$comment['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
	if ($_SESSION['user_name']==$comment['user_comentario']) {$votado_user=1;}
	else {$votado_user=0;}
	echo '<div class="media">';
	userFicha($comment);
	echo '	<p>
			<a href="?page=profile&n='.$comment['nick'].'"><small>'.$comment['nick'].'</small></a>';
	echo ' 	<span class="date-format-ago" data-date="'.$comment['date_comentario'].'">'.getDateFormat($comment['date_comentario'], "DATE_TIME").'</span>';
    if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){  echo '<br />canal '.$comment['canal_comentario'];}
    

	echo '	</p>
			<p id="texto-comentario-'.$comment['id_comentario'].'">'.$comment['comentario'].'</p>			
		</div>
		<div class="legend pull-right" style="margin-right:10px">
			<span class="muro-votado" id="'.$comment['id_comentario'].'" value="'.$votado.'"></span>							
			<span class="muro-votado-user" id="user_'.$comment['id_comentario'].'" value="'.$votado_user.'"></span>
			<span class="murogusta fa fa-heart '.$comment['id_comentario'].'" 
				value="'.$comment['id_comentario'].'" 
				href="'.$comment['votaciones'].'" 
				title="votar">
				'.$comment['votaciones'].'
			</span>
			
			<span value="'.$comment['comentario'].'">
	  			<span class="responder-triger fa fa-comment" title="responder" tipom="'.$comment['tipo_muro'].'" value="'.$comment['id_comentario'].'"> '.$respuestas.'</span>
			</span>
			
			<span style="margin-left:10px">				
		    	 <a href="?page=muro-comentarios-respuestas&id='.$comment['id_comentario'].'" class="tooltip-top" title="ver todas las respuestas"> <span class="fa fa-sign-in"></span></a>
			</span>
		</div>';
	echo '	<div id="muro-result-megusta'.$comment['id_comentario'].'" class="text-danger"></div>';
	echo '	<hr>';  
}
?>
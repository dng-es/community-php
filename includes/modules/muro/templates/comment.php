<?php

templateload("tipuser","users");

function commentMuro($comentario_muro){
    global $page,$muro;
	if ($page=='muro_comentarios') {$pagina=$page.'&c='.$comentario_muro['tipo_muro'];}
	else {$pagina=$page;}
	//respuestas al comentario
	$respuestas = connection::countReg("muro_comentarios"," AND id_comentario_id=".$comentario_muro['id_comentario']." AND estado=1 ");
	$votado = connection::countReg("muro_comentarios_votaciones"," AND id_comentario=".$comentario_muro['id_comentario']." AND user_votacion='".$_SESSION['user_name']."' ");
	if ($_SESSION['user_name']==$comentario_muro['user_comentario']) {$votado_user=1;}
	else {$votado_user=0;}
	echo '<div class="media">';
	userFicha($comentario_muro);
	echo '	<p><b>'.$comentario_muro['nick'].'</b> <span class="date-format-ago" data-date="'.$comentario_muro['date_comentario'].'">'.strftime(DATE_TIME_FORMAT,strtotime($comentario_muro['date_comentario'])).'</span> '.strTranslate("says").':';
    //SOLO LOS FORMADORES Y ADMIN PUEDEN VER EL CANAL
    if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){  echo ' (canal '.$comentario_muro['canal_comentario'].')';}
	echo '	</p>
			<p id="texto-comentario-'.$comentario_muro['id_comentario'].'">'.$comentario_muro['comentario'].'</p>			
			<div class="legend">
				<span class="muro-votado" id="'.$comentario_muro['id_comentario'].'" value="'.$votado.'"></span>							
				<span class="muro-votado-user" id="user_'.$comentario_muro['id_comentario'].'" value="'.$votado_user.'"></span>
				<span class="murogusta fa fa-heart '.$comentario_muro['id_comentario'].'" 
					value="'.$comentario_muro['id_comentario'].'" 
					href="'.$comentario_muro['votaciones'].'" 
					title="votar">
					'.$comentario_muro['votaciones'].'
				</span>
				
				<span value="'.$comentario_muro['comentario'].'">
		  			<span class="responder-triger fa fa-comment" title="responder" tipom="'.$comentario_muro['tipo_muro'].'" value="'.$comentario_muro['id_comentario'].'"> '.$respuestas.'</span>
				</span>
				
				<span style="margin-left:10px">				
			    	 <a href="?page=muro-comentarios-respuestas&id='.$comentario_muro['id_comentario'].'" class="tooltip-top" title="ver todas las respuestas"> <span class="fa fa-sign-in"></span></a>
				</span>
			</div>';
	echo '	<div id="muro-result-megusta'.$comentario_muro['id_comentario'].'" class="text-danger"></div>';
	echo '	<hr>
		</div>';  
}
?>
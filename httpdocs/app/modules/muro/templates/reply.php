<?php
function replyMuro(){
	echo '<div id="muro-responder" class="panel panel-default">
			<div id="muro-responder-cerrar"><span class="fa fa-times"></span></div>
			<div class="panel-heading">'.strTranslate("Reply_comment").'</div>
			<div id="muro-responder-content" class="panel-body">';
//SOLO LOS COMERCIALES,FORMADORES Y ADMIN PUEDEN INSERTAR COMENTARIOS
		  if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='usuario' or $_SESSION['user_perfil']=='formador' or $_SESSION['user_perfil']=='responsable' or $_SESSION['user_perfil']=='forosIns')
		  {	
			echo '	<span id="muro-respuesta-comentario"></span>
	              	<form action="" name="form-responder-muro" id="form-responder-muro" method="post" role="form" class="form-horizontal">
						<input type="hidden" id="id_comentario_responder" name="id_comentario_responder" value="" />
						<input type="hidden" name="tipo_muro" id="tipo_muro" value="" />
						<textarea maxlength="160" class="form-control" id="texto-responder" name="texto-responder"></textarea>
						<button id="muro-responder-submit" class="btn btn-primary btn-block" type="button">'.strTranslate("Reply").'</button>
					</form>';	
		  }
		  else { echo "<p>No dispone de permisos para responder mensajes en el muro.</p>";}	
  echo '	<span id="muro-responder-result"></span>';		
  echo '</div>';
  echo '</div>';	
}
?>
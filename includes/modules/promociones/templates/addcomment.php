<?php
function addComment(){
	echo '	<script type="text/javascript" src="'.getAsset("promociones").'js/reto-comentario.js"></script>
			<div id="banner-comentarios-form">
			<h4>Sube tu comentarios</h4
			<p>Envía un comentario a la comunidad donde este reflejada tu Actytu Kiabi.</p>
			<form id="coment-form" name="coment-form" action="" method="post" role="form">
				<input type="hidden" name="tipo_muro" id ="tipo_muro" value="'.$nombre_promocion.'" />';	
	echo '		<label for="texto-comentario" class="sr-only">Texto:</label>
				<input type="text" id="texto-comentario" name="texto-comentario" class="form-control" placeholder="Escribe tu respuesta"><br />';
	if ($_SESSION['user_perfil']=='admin' or $_SESSION['user_perfil']=='formador'){
		  echo '<label for="canal-comentario" class="sr-only">Canal:</label>
				<select name="canal-comentario" id="canal-comentario" class="form-control">
					<option value="comercial">Canal comerciales</option>
					<option value="gerente">Canal gerentes</option>
				</select><br />';}											
	echo '		<button class="btn btn-primary btn-block" type="submit" id="coment-submit" name="coment-submit">Enviar comentario</button>
			</form>
			</div>';
}
?>
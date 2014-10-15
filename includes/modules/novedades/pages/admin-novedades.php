<?php

addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js", 
					 getAsset("novedades")."js/admin-novedades.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Novedades</h1>
		<?php 
		session::getFlashMessage( 'actions_message' ); 
		novedadesController::updateAction();
		?>
		<p>Introduce la novedad para hoy, podrá ser un texto, una imagen o un video. La novedad anterior será modificada por la nueva que introduzcas.</p>
		<form id="formData" name="formData" method="post" enctype="multipart/form-data" action="" role="form">

			<label>Canal:</label>
			<select name="canal" id="canal" class="form-control">
			<?php ComboCanales();?>
			</select>

			<label checkbox-inline>
				<input type="checkbox" id="activo"  name="activo" checked="checked"> Activa
			</label>
			
			<textarea cols="40" rows="5" name="texto"></textarea>
			<script type="text/javascript">
				var editor=CKEDITOR.replace('texto',{customConfig : 'config-page.js'});
				CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
			</script>
			<br />	
			<input type="submit" name="SubmitData" class="btn btn-primary" value="Guardar datos" />
			<br /><br />
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>
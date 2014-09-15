<?php

addJavascripts(array(getAsset("destacados")."js/admin-destacados.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

session::getFlashMessage( 'actions_message' );
destacadosController::updateAction();		
?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Destacado del día</h1>
		<p>Introduce los datos del nuevo destacado del día: Id del archivo; selecciona si es un video o una foto; el canal donde quieres que aparezca
		como destacado; e introduce un texto por el que destacas el contenido enviado por el usuario.</p>
		<form id="formData" name="formData" method="post" action="" role="form">
		<table cellspacing="0" cellpadding="2px">
			<tr><td valign="top"><label for="id_destacado">ID contenido:</label></td>
			<td colspan="3">
				<input type="text" name="id_destacado" id="id_destacado" class="form-control" />
				<span id="id-destacado-alert" class="alert-message"></span>
			</td></tr>
			<tr><td valign="top"><label for="tipo_destacado">Tipo contenido:</label></td>
			<td>
				<select name="tipo_destacado" id="tipo_destacado" class="form-control">
					<option value="video">video</option>
					<option value="foto">foto</option>
				</select>
			</td>
			<td valign="top"><label for="canal_destacado">Canal:</label></td>
			<td>
				<select name="canal_destacado" id="canal_destacado" class="form-control">
					<option value="comercial">Comerciales</option>
					<option value="gerente">Gerentes</option>
				</select>
			</td></tr>
			<tr><td colspan="4"><label for="texto_destacado">Motivo selección:</label>
			</td></tr>
			<tr><td colspan="4">
				<textarea class="form-control" name="texto_destacado" id="texto_destacado"></textarea>
				<span id="texto-destacado-alert" class="alert-message"></span>
			</td></tr>
			<tr><td colspan="4"><button type="button" id="SubmitData" name="SubmitData" class="btn btn-primary">Modificar destacado</button></td></tr>
		</table>
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>
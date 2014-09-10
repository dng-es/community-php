<?php
define('KEYWORDS_META_PAGE', $ini_conf['SiteKeywords']);
define('SUBJECT_META_PAGE', $ini_conf['SiteSubject']);

addJavascripts(array(getAsset("users")."js/admin-puntos.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);?>

<div class="row row-top">
	<div class="col-md-9">
		<h1>Asignación de puntos</h1>
		<p>Puedes asignar puntos a los usuarios, tambien puedes restarles puntos introducciendo un valor negativo. 
		Para sumar o restar puntos intruduce el usuario (no nick), el número de puntos y el motivo de la asignación.</p><br />

		<form id="formData" name="formData" method="post" action="" role="form">
		<table cellspacing="0" cellpadding="2px">
				<tr><td valign="top"><label for="id_usuario">Usuario:</label></td>
				<td>
					<input type="text" name="id_usuario" id="id_usuario" class="form-control" />
					<span id="id-usuario-alert" class="alert-message alert alert-danger"></span>
				</td></tr>
				<tr>
			<td valign="top"><label for="num_huellas">Puntos:</label></td>
				<td>
					<input size="6" type="text" name="num_huellas" id="num_huellas" class="form-control" />
					<span id="num-huellas-alert" class="alert-message alert alert-danger"></span>
				</td></tr>
				<tr><td valign="top"><label for="motivo_huellas">Motivo:</label></td>
				<td>
					<input type="text" name="motivo_huellas" id="motivo_huellas" class="form-control" />
					<span id="motivo-huellas-alert" class="alert-message alert alert-danger"></span>
				</td></tr>    
			<tr><td colspan="2">
				<br />
				<button type="button" id="SubmitData" name="SubmitData" class="btn btn-primary">Asignar puntos</button></td></tr>
		</table>
		</form>
		<div id="resultado-huellas"></div>
	</div>
	<?php menu::adminMenu();?>
</div>
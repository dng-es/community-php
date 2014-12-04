<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-puntos.js"));
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"?page=admin-users"),
			array("ItemLabel"=>"Asignación de puntos", "ItemClass"=>"active"),
		));
		?>
		<p>Puedes asignar puntos a los usuarios, tambien puedes restarles puntos introducciendo un valor negativo. 
		Para sumar o restar puntos intruduce el usuario (no nick), el número de puntos y el motivo de la asignación.</p><br />

		<form id="formData" name="formData" method="post" action="" role="form">
			<label for="id_usuario">Usuario:</label>
			<input type="text" name="id_usuario" id="id_usuario" class="form-control" />
			<span id="id-usuario-alert" class="alert-message alert alert-danger"></span>

			<label for="num_puntos">Puntos:</label>
			<input size="6" type="text" name="num_puntos" id="num_puntos" class="form-control" />
			<span id="num-huellas-alert" class="alert-message alert alert-danger"></span>

			<label for="motivo_puntos">Motivo:</label>
			<input type="text" name="motivo_puntos" id="motivo_puntos" class="form-control" />
			<span id="motivo-huellas-alert" class="alert-message alert alert-danger"></span>

			<br />
			<button type="button" id="SubmitData" name="SubmitData" class="btn btn-primary">Asignar puntos al usuario</button>
		</form>
		<br />
		<div id="resultado-puntos"></div>
		<h2>Carga de fichero</h2>
		<p>Selecciona un fichero Excel con los usuarios a  sumar o restar <?php echo strTranslate("APP_points");?>. 
		El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo pinchando <a href="docs/model_puntos.xls"><b>aquí</b></a>.</p>
		<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="?page=admin-cargas-puntos-process" role="form">
			<label for="nombre-fichero">Selecciona el fichero excel (.xls): </label><br />
			<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="Seleccionar fichero" />
			<span id="fichero-alert" class="alert-message"></span>
			<input type="button" id="inputFile" name="inputFile" value="Importar fichero" class="btn btn-primary" />
		</form>
		<br />
	</div>
	<?php menu::adminMenu();?>
</div>
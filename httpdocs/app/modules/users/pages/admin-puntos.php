<?php
addJavascripts(array("js/bootstrap.file-input.js", 
					"js/jquery.numeric.js", 
					getAsset("users")."js/admin-puntos.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("Points_assignment"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>Puedes asignar <?php e_strTranslate("APP_points");?> a los usuarios, tambien puedes restarles <?php e_strTranslate("APP_points");?> introducciendo un valor negativo. 
						Para sumar o restar <?php e_strTranslate("APP_points");?> intruduce el usuario (no nick), el número de <?php e_strTranslate("APP_points");?> y el motivo de la asignación.</p><br />

						<form id="formData" name="formData" method="post" action="" role="form">
							<div class="form-group">
								<label for="id_usuario"><?php e_strTranslate("User");?>:</label>
								<input data-alert="<?php e_strTranslate("Required_field");?>" type="text" name="id_usuario" id="id_usuario" class="form-control" />
							</div>

							<div class="form-group">
								<label for="num_puntos"><?php echo ucfirst(strTranslate("APP_points"));?>:</label>
								<input data-alert="<?php e_strTranslate("Required_field");?>" size="6" type="text" name="num_puntos" id="num_puntos" class="form-control" />
							</div>

							<div class="form-group">
								<label for="motivo_puntos">Motivo:</label>
								<input data-alert="<?php e_strTranslate("Required_field");?>" type="text" name="motivo_puntos" id="motivo_puntos" class="form-control" />
							</div>

							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Asignar <?php e_strTranslate("APP_points");?> al usuario</button>
						</form>
						<br />
						<div id="resultado-puntos"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>Selecciona un fichero Excel con los usuarios a  sumar o restar <?php e_strTranslate("APP_points");?>. 
						El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo pinchando <a href="docs/model_puntos.xls"><b>aquí</b></a>.</p>
						<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-cargas-puntos-process" role="form">
							<label for="nombre-fichero">Selecciona el fichero excel (.xls): </label><br />
							<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="Seleccionar fichero" />
							<span id="fichero-alert" class="alert-message"></span>
							<input type="button" id="inputFile" name="inputFile" value="Importar fichero" class="btn btn-primary" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
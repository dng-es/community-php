<?php
addJavascripts(array("js/bootstrap.file-input.js", 
					"js/jquery.numeric.js", 
					getAsset("users")."js/admin-creditos.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>"Asignación de ".strTranslate("APP_Credits"), "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>Puedes asignar <?php e_strTranslate("APP_Credits");?> a los usuarios, tambien puedes restarles <?php e_strTranslate("APP_Credits");?> introducciendo un valor negativo. 
						Para sumar o restar <?php e_strTranslate("APP_Credits");?> intruduce el usuario (no nick), el número de <?php e_strTranslate("APP_Credits");?> y el motivo de la asignación.</p><br />

						<form id="formData" name="formData" method="post" action="" role="form">
							<div class="form-group">
								<label for="id_usuario"><?php e_strTranslate("User");?>:</label>
								<input data-alert="<?php e_strTranslate("Required_field");?>" type="text" name="id_usuario" id="id_usuario" class="form-control" />
							</div>

							<div class="form-group">
								<label for="num_puntos"><?php echo ucfirst(strTranslate("APP_Credits"));?>:</label>
								<input data-alert="<?php e_strTranslate("Required_field");?>" size="6" type="text" name="num_puntos" id="num_puntos" class="form-control" />
							</div>

							<div class="form-group">
								<label for="motivo_puntos">Motivo:</label>
								<input type="text" data-alert="<?php e_strTranslate("Required_field");?>" name="motivo_puntos" id="motivo_puntos" class="form-control" />
							</div>

							<div class="form-group">
								<label for="motivo_puntos">Detalle:</label>
								<textarea name="detalle_puntos" rows="5" id="detalle_puntos" class="form-control"></textarea>
							</div>
							
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary">Asignar <?php e_strTranslate("APP_Credits");?> al usuario</button>
						</form>
						<br />
						<div id="resultado-puntos"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<p>Selecciona un fichero Excel con los usuarios a  sumar o restar <?php e_strTranslate("APP_Credits");?>. 
						El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo pinchando <a href="docs/model_creditos.xls"><b>aquí</b></a>.</p>
						<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-cargas-creditos-process" role="form">
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
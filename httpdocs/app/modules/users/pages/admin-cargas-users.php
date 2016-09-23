<?php addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-cargas.js"));?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("Users_import"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<p>Selecciona un fichero Excel con los usuarios a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/model_users.xls"><b><?php e_strTranslate("Click_here")?></b></a>.</p>
				<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-cargas-user-process" role="form">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" class="styled" id="insert" name="insert" checked>
						<label for="insert">Insertar <?php e_strTranslate("Users");?></label>
						<p class="text-muted">Insertar nuevos usuarios</p>
					</div>

					<div class="checkbox checkbox-primary">
						<input type="checkbox" class="styled" id="update" name="update" checked>
						<label for="update">Modificar <?php e_strTranslate("Users");?></label> 
						<p class="text-muted">Se modificaran los campos <?php e_strTranslate("Channel");?> y <?php e_strTranslate("Group_user");?>, los usuarios serán reactivados</p>
					</div>
					
					<div class="checkbox checkbox-primary">
						<input type="checkbox" class="styled" id="delete" name="delete" checked>
						<label for="delete">Eliminar <?php e_strTranslate("Users");?></label>
						<p class="text-muted">Se eliminar aquellos que no figuren en el fichero. No se tendrán en cuenta los perfiles admin</p>
					</div>

					<label for="nombre-fichero"><?php e_strTranslate("Choose_file")?> Excel (.xls): </label><br />
					<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php e_strTranslate("Choose_file")?>" />
					<span id="fichero-alert" class="alert-message"></span>
					<input type="button" id="inputFile" name="inputFile" value="<?php e_strTranslate("Import_file")?>" class="btn btn-primary" />
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
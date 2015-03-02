<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-cargas.js"));
?>
<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Carga de ventas", "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<p>Selecciona un fichero Excel con los datos a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/model_incentivos.xls"><b><?php echo strTranslate("Click_here")?></b></a>.</p>
				<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-cargas-incentives-process" role="form">
					<label for="nombre-fichero"><?php echo strTranslate("Choose_file")?> Excel (.xls): </label><br />
					<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php echo strTranslate("Choose_file")?>" />
					<span id="fichero-alert" class="alert-message"></span>
					<input type="button" id="inputFile" name="inputFile" value="<?php echo strTranslate("Import_file")?>" class="btn btn-primary" />
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
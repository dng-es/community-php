<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-cargas.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives-targets"),
			array("ItemLabel"=>strTranslate("Incentives_sales"), "ItemUrl"=>"admin-incentives-ventas"),
			array("ItemLabel"=>strTranslate("Incentives_sales_import"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<p>Selecciona el fichero Excel con los datos a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/model_incentivos.xls"><b><?php e_strTranslate("Click_here")?></b></a>.</p>
				<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-incentives-ventas-cargas-process" role="form">
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
<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("users")."js/admin-cargas.js"));
$id_objetivo = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
$objetivo = incentivosObjetivosController::getItemAction($id_objetivo);
$modelo = ($objetivo['tipo_objetivo'] == 'Tienda' ? "model_incentivos_groups" : "model_incentivos_users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives"),
			array("ItemLabel"=>strTranslate("Incentives_targets"), "ItemUrl"=>"admin-incentives-targets-detail?id=".$id_objetivo),
			array("ItemLabel"=>"Importar objetivos", "ItemClass"=>"active"),
		));
		?>
		<div class="section inset">
			<h4><?php e_strTranslate("Incentives_target");?>: <?php echo $objetivo['nombre_objetivo'];?></h4>
			<p>Selecciona el fichero Excel con los datos a cargar. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/<?php echo $modelo;?>.xls"><b><?php e_strTranslate("Click_here")?></b></a>.</p>
			<form id="formImport" name="formImport" enctype="multipart/form-data" method="post" action="admin-incentives-targets-cargas-process?id=<?php echo $id_objetivo;?>" role="form">
				<label for="nombre-fichero"><?php e_strTranslate("Choose_file")?> Excel (.xls): </label><br />
				<input id="nombre-fichero" name="nombre-fichero" type="file" class="btn btn-default" title="<?php e_strTranslate("Choose_file")?>" />
				<span id="fichero-alert" class="alert-message"></span>
				<input type="button" id="inputFile" name="inputFile" value="<?php e_strTranslate("Import_file")?>" class="btn btn-primary" />
			</form>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
addJavascripts(array("js/mociones-graph.js"));
addJavascripts(array("js/bootstrap.file-input.js",
			getAsset("emociones")."js/admin-emocion.js"));

$accion = (isset($_GET['act']) ? $_GET['act'] : "new");
$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Emociones"), "ItemUrl"=>"admin-emociones"),
			array("ItemLabel"=>"Datos de la emoción", "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		emocionesController::createAction();
		emocionesController::updateAction($id);
		$elements = emocionesController::getItemAction($id);
		?>
		<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-5 form-group">
							<label>nombre de la emoción:</label>
							<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['name_emocion'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>
						
						<div class="col-md-4 form-group">
							<label for="info_file">Imágen de la emoción:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="seleccionar archivo de imagen" />
						</div>
						<div class="col-md-3 form-group">
						<?php
						if ($elements[0]['image_emocion']!=""){ 
							echo '<img src="images/banners/'.$elements[0]['image_emocion'].'" style="height: 100px" />';
						}

						?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<input type="submit" name="SubmitData" id="SubmitData" class="btn btn-primary" value="guardar emoción" />
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
addJavascripts(array("js/mociones-graph.js"));
addJavascripts(array("js/bootstrap.file-input.js",
			getAsset("emociones")."js/admin-emocion.js"));

$accion = (isset($_GET['act']) ? $_GET['act'] : "new");
$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>
<div class="row row-top">
	<div class="col-md-6 col-md-offset-3">
	<div class="col-md-12">
  		<h1>gestión de emociones</h1>
		<?php
		session::getFlashMessage('actions_message');
		emocionesController::createAction();
		emocionesController::updateAction($id);
		$elements = emocionesController::getItemAction($id);
		?>
		<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
			<input type="hidden" name="id" value="<?php echo $id;?>" />
			<label>nombre de la emoción:</label>
			<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements[0]['name_emocion'];?>" />
			<span id="title-alert" class="alert-message"></span>
			<br />
			<div class="row">
				<div class="col-md-6">
					<label for="info_file">Imágen de la emoción:</label><br />
					<input name="info_file" id="info_file" type="file" class="btn btn-default" title="seleccionar archivo de imagen" />
				</div>
				<div class="col-md-6">
				<?php
				if ($elements[0]['image_emocion']!=""){ 
					echo '<img src="images/banners/'.$elements[0]['image_emocion'].'" style="height: 100px" />';
				}

				?>
				</div>
			</div>
			 
			<span id="file-alert" class="alert-message"></span>
			<br /><br />
			<input type="button" name="SubmitData" id="SubmitData" class="btn btn-primary pull-right" value="guardar emoción" />
		</form>

	</div>
	</div>
	<?php menu::adminMenu();?>
</div>
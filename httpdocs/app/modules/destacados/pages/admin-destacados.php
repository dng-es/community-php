<?php
addJavascripts(array(getAsset("destacados")."js/admin-destacados.js", "js/jquery.numeric.js"));
templateload("cmbCanales", "users");
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Highlights"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Highlights"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		destacadosController::updateAction();
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" action="" role="form" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="id_destacado">ID:</label>
						<div class="col-sm-2">
							<input data-alert="<?php e_strTranslate("Required_number");?>" type="text" name="id_destacado" id="id_destacado" class="form-control numeric" />
						</div>

						<label class="col-sm-1 control-label" for="tipo_destacado"><?php e_strTranslate("Type");?>:</label>
						<div class="col-sm-3">
							<select name="tipo_destacado" id="tipo_destacado" class="form-control">
								<option value="video"><?php e_strTranslate("Video");?></option>
								<option value="foto"><?php e_strTranslate("Photo");?></option>
							</select>
						</div>

						<label class="col-sm-1 control-label" for="canal_destacado"><?php e_strTranslate("Channel");?>:</label>
						<div class="col-sm-3">
							<select name="canal_destacado" id="canal_destacado" class="form-control">
								<?php ComboCanales();?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="texto_destacado">Motivo selección:</label>
						<div class="col-sm-10">
							<textarea data-alert="<?php e_strTranslate("Required_field");?>" class="form-control" name="texto_destacado" id="texto_destacado"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-2">
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary btn-block"><?php e_strTranslate("Update");?></button>
						</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
	<?php menu::adminMenu();?>
</div>
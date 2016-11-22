<?php
addJavascripts(array("js/bootstrap.file-input.js", 
					"js/bootstrap-select.js",
					getAsset("campaigns")."js/admin-campaign.js"));

addCss(array("css/libs/bootstrap-select/bootstrap-select.css"));

session::getFlashMessage('actions_message');
campaignsController::createAction();
campaignsController::updateAction();
$plantilla = campaignsController::getItemAction();
?>
<div class="row row-top">	
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Campaigns"), "ItemUrl"=>"admin-campaigns"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Campaign"), "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id_campaign" id="id_campaign" value="<?php echo $plantilla['id_campaign'];?>" />

					<div class="col-md-12 form-group">
						<label for="name_campaign"><?php e_strTranslate("Name");?>:</label>
						<input type="text" name="name_campaign" id ="name_campaign" class="form-control form-big" value="<?php echo $plantilla['name_campaign'];?>" />
						<span id="nombre-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
					</div>

					<div class="col-md-4 form-group">
						<label><?php e_strTranslate("Type");?>:</label>
						<select name="id_type" id="id_type" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
						<?php
						$campaigns = new campaigns();
						$tipo_campana = $campaigns->getCampaignsTypes("");
						foreach($tipo_campana as $campana):
							echo '<option value="'.$campana['id_campaign_type'].'" '.($campana['id_campaign_type'] == $plantilla['id_campaign_type'] ? 'selected="selected"' : '').'>'.$campana['campaign_type_name'].'</option>';    
						endforeach;
						?>
						</select>
					</div>

					<div class="col-md-4 form-group">
						<label for="canal_campaign"><?php e_strTranslate("Channel");?></label>
						<select id="canal_campaign" name="canal_campaign" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
							<option value="">--Todos los canales--</option>
							<?php ComboCanales($plantilla['canal_campaign']);?>
						</select>
					</div>

					<div class="col-md-4 form-group">
						<div class="checkbox checkbox-primary">
							<input type="checkbox" name="novedad" id="novedad"<?php echo $plantilla['novedad'] == 1 ? ' checked="checked"' : "";?>>
							<label for="novedad"><?php e_strTranslate("News");?></label>
						</div>
					</div>

					<div class="col-md-12 form-group">
						<label for="desc_campaign"><?php e_strTranslate("Description");?>:</label>
						<textarea class="form-control" rows="8" id="desc_campaign" name="desc_campaign"><?php echo $plantilla['desc_campaign'];?></textarea>
						<span id="descripcion-alert" class="alert-message alert alert-danger"><?php e_strTranslate("Required_field");?></span>
					</div>


					<div class="col-md-12 form-group">				
						<div class="row">
							<div class="col-md-3">
								<label for="nombre-fichero">Imagen miniatura de la campaña</label>
								<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php e_strTranslate("Choose_file");?>" />
								<?php 
								if (isset($plantilla['imagen_mini']) and $plantilla['imagen_mini'] != ""){
									echo '<br /><img src="images/banners/'.$plantilla['imagen_mini'].'" style="width:100%" />';
								}
								?>
							</div>	
							<div class="col-md-3">
								<label for="nombre-fichero">Imagen Slide de la campaña</label>
								<input name="nombre-fichero-big" id="nombre-fichero-big" type="file" class="btn btn-primary btn-block" title="<?php e_strTranslate("Choose_file");?>" />
								<?php 
								if (isset($plantilla['imagen_big']) and $plantilla['imagen_big'] != ""){
									echo '<br /><img src="images/banners/'.$plantilla['imagen_big'].'" style="width:100%" />';
								}
								?>
							</div>
						</div>
					</div>

					<div class="col-md-12 form-group">
						<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit"><?php e_strTranslate("Save_data");?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("campaigns")."js/admin-campaign.js"));

session::getFlashMessage( 'actions_message' ); 
campaignsController::createAction();
campaignsController::updateAction();
$plantilla = campaignsController::getItemAction();	

?>
<div class="row row-top">	
	<div class="col-md-9 inset">
		<ol class="breadcrumb">
			<li><a href="?page=home"><?php echo strTranslate("Home");?></a></li>
			<li><a href="?page=admin"><?php echo strTranslate("Administration");?></a></li>
			<li><a href="#"><?php echo strTranslate("Campaigns");?></a></li>
			<li class="active"><?php echo strTranslate("Edit");?> <?php echo strTranslate("Campaign");?></li>
		</ol>
		<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
			<input type="hidden" name="id_campaign" id="id_campaign" value="<?php echo $plantilla['id_campaign'];?>" />
			
			<div class="checkbox">
				<label>
					<input type="checkbox" name="novedad" id="novedad"<?php echo $plantilla['novedad']==1 ? ' checked="checked"' : "";?>> Novedad
				</label>
			</div>

			<div class="form-group">
				<label for="name_campaign"><?php echo strTranslate("Name");?>:</label>
				<input type="text" name="name_campaign" id ="name_campaign" class="form-control" value="<?php echo $plantilla['name_campaign'];?>" />
				<span id="nombre-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
			</div>

			<div class="form-group">
				<label for="desc_campaign"><?php echo strTranslate("Description");?>:</label>
				<textarea class="form-control" rows="8" id="desc_campaign" name="desc_campaign"><?php echo $plantilla['desc_campaign'];?></textarea>
				<span id="descripcion-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
			</div>

			<div class="form-group">
				<label>Tipo de campaña:</label>
				<select name="id_type" id="id_type" class="form-control">
				<?php
				$campaigns = new campaigns();
				$tipo_campana = $campaigns->getCampaignsTypes("");
				foreach($tipo_campana as $campana):
					echo '<option value="'.$campana['id_campaign_type'].'" '.($campana['id_campaign_type']==$plantilla['id_campaign_type'] ? 'selected="selected"' : '').'>'.$campana['campaign_type_name'].'</option>';    
				endforeach;
				?>
				</select>
			</div>

			<div class="form-group">				
				<div class="row">
					<div class="col-md-3">
						<label for="nombre-fichero">Imagen miniatura de la campaña</label>
						<input name="nombre-fichero" id="nombre-fichero" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Choose_file");?>" />
						<?php 
						if (isset($plantilla['imagen_mini']) and $plantilla['imagen_mini']!=""){
							echo '<br /><img src="images/banners/'.$plantilla['imagen_mini'].'" style="width:100%" />';
						}
						?>
					</div>	
					<div class="col-md-3">
						<label for="nombre-fichero">Imagen Slide de la campaña</label>
						<input name="nombre-fichero-big" id="nombre-fichero-big" type="file" class="btn btn-primary btn-block" title="<?php echo strTranslate("Choose_file");?>" />
						<?php 
						if (isset($plantilla['imagen_big']) and $plantilla['imagen_big']!=""){
							echo '<br /><img src="images/banners/'.$plantilla['imagen_big'].'" style="width:100%" />';
						}
						?>
					</div>	
				</div>			
			</div>

			<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit"><?php echo strTranslate("Save");?></button>
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>
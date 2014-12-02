<?php
addJavascripts(array(getAsset("campaigns")."js/admin-campaigns-type.js"));

session::getFlashMessage( 'actions_message' ); 
campaignsController::createTypeAction();
campaignsController::updateTypeAction();
$plantilla = campaignsController::getItemTypesAction();	

?>
<div class="row row-top">	
	<div class="col-md-9 inset">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Campaigns"), "ItemUrl"=>"?page=admin-campaigns"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Campaign_types"), "ItemClass"=>"active"),
		));?>
		<form id="formData" name="formData" method="post" action="" role="form" enctype="multipart/form-data">
			<input type="hidden" name="id" id="id" value="<?php echo $plantilla['id_campaign_type'];?>" />
			<div class="form-group">
				<label for="name"><?php echo strTranslate("Name");?>:</label>
				<input type="text" name="name" id ="name" class="form-control" value="<?php echo $plantilla['campaign_type_name'];?>" />
				<span id="nombre-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
			</div>

			<div class="form-group">
				<label for="desc"><?php echo strTranslate("Description");?>:</label>
				<textarea class="form-control" rows="8" id="desc" name="desc"><?php echo $plantilla['campaign_type_desc'];?></textarea>
				<span id="descripcion-alert" class="alert-message alert alert-danger"><?php echo strTranslate("Required_field");?></span>
			</div>
			<button class="btn btn-primary" id="SubmitData" name="SubmitData" type="submit"><?php echo strTranslate("Save");?></button>
		</form>	
	</div>
	<?php menu::adminMenu();?>
</div>
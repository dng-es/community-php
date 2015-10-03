<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Channel_list"), "ItemUrl"=>"admin-canales"),
			array("ItemLabel"=>strTranslate("Channel"), "ItemClass"=>"active"),
		));
		
		session::getFlashMessage('actions_message');
		usersCanalesController::createAction();
		usersCanalesController::updateAction();
		$elements = usersCanalesController::getItemAction();
		?>	
		<div class="panel">
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" action="">
					<input type="hidden" id="id_canal" name="id_canal" value="<?php echo $elements['canal'];?>" />
					<div class="row">
						<div class="col-md-6">
							<label for="canal"><small><?php echo strTranslate("Channel");?>: <span class="text-muted">(texto corto identificativo del canal)</span></small></label>
							<input type="text" class="form-big form-control<?php if (isset($_REQUEST['id']) and $_REQUEST['id']!="") {echo ' TextDisabled" readonly="readonly';}?>" id="canal" name="canal" value="<?php echo $elements['canal'];?>" data-alert="<?php echo strTranslate("Required_field");?>" />
						</div>
						<div class="col-md-6">
					  		<label for="canal_name"><small><?php echo strTranslate("Description");?>:</small></label>
					  		<input type="text" class="form-control TextDisabled" id="canal_name" name="canal_name" value="<?php echo $elements['canal_name'];?>" />
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-md-12">
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
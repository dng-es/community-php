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
		$temas = FileSystem::showDirFolders(__DIR__."/../../../../themes/");
		?>
		<div class="panel">
			<div class="panel-body">
				<form id="formData" role="form" name="formData" method="post" action="">
					<input type="hidden" id="id_canal" name="id_canal" value="<?php echo $elements['canal'];?>" />
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="canal"><small><?php e_strTranslate("Channel");?>: <span class="text-muted">(texto corto identificativo del canal)</span></small></label>
							<input type="text" class="form-control<?php if (isset($_REQUEST['id']) and $_REQUEST['id']!="") {echo ' TextDisabled" readonly="readonly';}?>" id="canal" name="canal" value="<?php echo $elements['canal'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>

						<div class="col-md-3 form-group">
							<label for="theme"><small><?php e_strTranslate("Theme");?>:</small></label>
							<select id="theme" name="theme" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
								<?php foreach($temas as $tema): ?>
								<option <?php echo ($tema == $elements['theme'] ? ' selected="selected" ' : "");?> value="<?php echo $tema;?>"><?php echo $tema;?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-md-3 form-group">
                            <label class="control-label" for="canal_lan"><small><?php e_strTranslate("Language");?></small></label>
                            <select name="canal_lan" id="canal_lan" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%">
                                <?php ComboLanguages($elements['canal_lan']);?>
                            </select>
                        </div>

					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="canal_name"><small><?php e_strTranslate("Description");?>:</small></label>
							<input type="text" class="form-big form-control TextDisabled" id="canal_name" name="canal_name" value="<?php echo $elements['canal_name'];?>" />
						</div>
					</div>					
					<br />
					<div class="row">
						<div class="col-md-12 form-group">
							<button type="submit" id="SubmitData" name="SubmitData" class="btn btn-primary"><?php e_strTranslate("Save_data");?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
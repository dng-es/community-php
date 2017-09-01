<?php addJavascripts(array(getAsset("configuration")."js/admin-translation.js"));?>
<div class="row  row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Modules_settings"), "ItemUrl"=>"admin-modules"),
			array("ItemLabel"=>strTranslate("Translation"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		configurationTranslationsController::updateAction();
		$module = (isset($_REQUEST['id']) ? sanitizeInput($_REQUEST['id']) : "");
		$language = $_SESSION['language'];
		$elements = configurationTranslationsController::getLanguageFile($module, $language);
		//$elements = ksort($elements);
		// echo '<pre>';
		$modules = configurationController::getListModulesAction();
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				Traducciones del modulo <b><big><em><?php echo e_strTranslate(ucfirst($module));?></em></big></b> para el idioma: <img alt="<?php echo $language;?>" src="app/languages/<?php echo $language;?>/images/flag.png" class="lang-img" />
			</div>
			<div class="panel-body">
				<?php if(count($elements) > 0):?>
				<form id="formData" name="formData" method="post" action="" role="form" class="form-horizontal">
					<input type="hidden" name="language_trans" id="language_trans" value="<?php echo $language;?>" />
					<input type="hidden" name="module_trans" id="module_trans" value="<?php echo $module;?>" />
					<div class="row">
						<div class="col-md-2 col-md-offset-8">		
							<button type="button" class="btn btn-warning btn-block" onclick="location.href='<?php echo $_SERVER['REQUEST_URI'];?>'; return false;">Reiniciar cambios</button>
						</div>
						<div class="col-md-2">		
							<button type="submit" class="btn btn-primary btn-block"><?php e_strTranslate("Save_data");?></button>
						</div>
					</div>
					<hr />
					<div class="row">
					<?php foreach ($elements as $key => $value):?>
						<div class="form-group col-md-6">
							<label class="col-sm-4 control-label" for="<?php echo $key;?>"><small><?php echo $key;?></small></label>
							<div class="col-sm-7">
								<input type="text" class="form-control" id="<?php echo $key;?>" name="<?php echo $key;?>" value="<?php echo $value;?>" data-alert="<?php e_strTranslate("Required_field");?>" />
								<?php $path = realpath(dirname(__FILE__))."/../../";
								$ocurrencias = "";
								foreach($modules as $module):
									$ocurrencias_module = "";
									$dir_name = $path.$module['folder']."/pages";
									$ficheros = FileSystem::showFilesFolder($dir_name);
									
									$module_find = "";
									foreach($ficheros as $fichero):
										$fichero_content = file_get_contents($dir_name."/".$fichero);
										if (strrpos($fichero_content, $key)) {
											if ($module['folder'] != $module_find) $ocurrencias_module = "<b>".strTranslate("Module")." ".$module['folder']."</b><ul>";
											$module_find = $module['folder'];
											$ocurrencias_module .= "<li>".substr($fichero, 0, -4)."</li>";
										}
									endforeach;
									if ($ocurrencias_module != "") $ocurrencias_module .= "</ul>";
									$ocurrencias .= $ocurrencias_module;
								endforeach;
								//buscar en header
								$fichero_content = file_get_contents($path."/class.headers.php");
								if (strrpos($fichero_content, $key)) {
									if ($module['folder'] != $module_find) $ocurrencias .= "<b>Header</b><ul>";
									$ocurrencias .= "<li>PageHeader</li>";
								}
								//buscar en menu
								$fichero_content = file_get_contents($path."/class.menu.php");
								if (strrpos($fichero_content, $key)) {
									if ($module['folder'] != $module_find) $ocurrencias .= "<b>Menu</b><ul>";
									$ocurrencias .= "<li>PageMenu</li>";
								}								
								//buscar en footer
								$fichero_content = file_get_contents($path."/class.footer.php");
								if (strrpos($fichero_content, $key)) {
									if ($module['folder'] != $module_find) $ocurrencias .= "<b>Footer</b><ul>";
									$ocurrencias .= "<li>PageFooter</li>";
								}	

								if ($ocurrencias == "") $ocurrencias ="<em>".strTranslate("Located_in_templates")."</em>";
								?>
								</small>
							</div>
							<div class="col-sm-1">
								<button type="button" class="btn btn-info popover-dismiss" data-toggle="popover" title="<?php e_strTranslate("Place_in");?>" data-content="<?php echo $ocurrencias;?>"><i class="fa fa-info"></i></button>
							</div>
						</div>
					<?php endforeach;?>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-2 col-md-offset-8">		
							<button type="button" class="btn btn-warning btn-block" onclick="location.href='<?php echo $_SERVER['REQUEST_URI'];?>'; return false;">Reiniciar cambios</button>
						</div>
						<div class="col-md-2">		
							<button type="submit" class="btn btn-primary btn-block"><?php e_strTranslate("Save_data");?></button>
						</div>
					</div>
				</form>
				<?php else:?>
					<div class="alert alert-warning"><i class="fa fa-warning"></i> No se encuenta el fichero de traducciones.</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
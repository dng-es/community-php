<?php
set_time_limit(0);
ini_set('memory_limit', '-1');

//EXPORT MODULES/PAGES
configurationController::exportModulesPagesAction();
addJavascripts(array(getAsset("configuration")."js/admin-modules.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Modules_settings"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		configurationController::updateAction();
		$modules = configurationController::getListModulesAction();
		global $modules_data;
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h2><?php e_strTranslate("Modules_installed");?></h2>
				<ul>
					<li><a href="admin-modules?export=true">Descargar</a> detalle de páginas por módulo.</li>
					<li><a class="" href="admin-translation?id=core_ini" title="<?php e_strTranslate("Translations");?>"><?php e_strTranslate("Translations");?></a> fichero general de idiomas de la aplicación.</li>
				</ul>
				<div class="">
					<?php foreach($modules as $module): ?>
						<div class="config-section panel panel-default">
							<?php 
							$module_config = getModuleConfig($module['folder']);
							$key = array_search($module['folder'], arraycolumn($modules_data, 'name'));
							$language_file = realpath(dirname(__FILE__)).'/../../'.$module['folder'].'/resources/languages/'.$_SESSION['language'].'/language.php';
							?>
							<div class="panel-heading">
								<h3 class="panel-title"><?php e_strTranslate(ucfirst($module['folder']));?> <small><i data-html="true" class="pull-right user-tip fa fa-info-circle text-muted" title="<?php echo str_replace('"', '\'', $module['ann']);?>"></i></small>
								</h3>
							</div>
							<div class="panel-body" style="height:80px">
								<ul class="list-unstyled">
									<?php if (file_exists($language_file)):?>
									<li><i class="fa fa-globe"></i> <a class="" href="admin-translation?id=<?php echo $module['folder'];?>" title="<?php e_strTranslate("Translations");?>"><small><?php e_strTranslate("Translations");?></small></a></li>
									<?php endif;?>
									
									<?php if (isset($module_config['options']) || isset($module_config['channels'])):?>
									<li><i class="fa fa-gears"></i> <a data-module="<?php echo $module['folder'];?>" class="configuration-trigger" href="#" title="<?php e_strTranslate("Configuration");?>"><small><?php e_strTranslate("Configuration");?></small></a></li>
									<?php endif;?>
								</ul>
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>

<!-- Modal -->
<div class="modal modal-wide fade" id="configurationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Configuration");?> <small></small></h4>
			</div>
			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
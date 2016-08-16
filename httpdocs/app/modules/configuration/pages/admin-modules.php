<?php
addJavascripts(array(getAsset("configuration")."js/admin-modules.js"));

session::getFlashMessage('actions_message');
configurationController::updateAction();
$modules = configurationController::getListModulesAction();

global $modules_data;
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Modules_settings"), "ItemClass"=>"active"),
		));?>

		<div class="panel panel-default">
			<div class="panel-body">
				<h2><?php e_strTranslate("Modules_installed");?></h2>
				<div class="">
					<?php foreach($modules as $module): ?>
						<div class="config-section panel panel-default">
							<?php 
							$module_config = getModuleConfig($module['folder']);
							$key = array_search($module['folder'], arraycolumn($modules_data, 'name'));
							?>
							<div class="panel-heading">
								<h3 class="panel-title"><?php echo strTranslate(ucfirst($module['folder']));?> <small><i data-html="true" class="pull-right user-tip fa fa-info-circle text-muted" title="<?php echo str_replace('"', '\'', $module['ann']);?>"></i></small>
								</h3>
							</div>
							<div class="panel-footer" style="height:40px">&nbsp;
							<?php
							echo (isset($module_config['options']) ? '<a data-module="'.$module['folder'].'" class="configuration-trigger btn btn-default btn-xs pull-right" href="#" title="'.strTranslate("Configuration").'"><small>'.strTranslate("Configuration").'</small>&nbsp;<i class="fa fa-gear"></i></a>' : '').'';?>
							</div>
						</div>
					<?php endforeach; ?>
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
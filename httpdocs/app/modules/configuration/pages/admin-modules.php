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
				<p><?php echo strTranslate("Modules_installed");?></p><br />
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<?php foreach($modules as $module):
							$module_config = getModuleConfig($module['folder']);
							$key = array_search($module['folder'], arraycolumn($modules_data, 'name'));
							echo '<tr>
							<td><h4>'.strTranslate(ucfirst($module['folder'])).'</h4></td>
							<td class="legend">'.$module['ann'].'</td>
							<td>'.(isset($module_config['options']) ? '<a data-module="'.$module['folder'].'" class="configuration-trigger btn btn-default btn-xs" href="#" title="'.strTranslate("Configuration").'"><small>'.strTranslate("Configuration").'</small>&nbsp;<i class="fa fa-gear"></i></a>' : '').'</td>
							</tr>';
						endforeach; ?>
					</table>
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
				<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Configuration");?> <small></small></h4>
			</div>
			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
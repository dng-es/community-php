<?php
addJavascripts(array(getAsset("configuration")."js/admin-modules.js"));

session::getFlashMessage( 'actions_message' ); 
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

		<p>A continuación se muestran todos los módulos instalados</p><br />
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<?php foreach($modules as $module):
					$module_config = getModuleConfig($module['folder']);	
					$key = array_search($module['folder'], arraycolumn($modules_data, 'name'));
					echo '<tr>
					<td width="40px"><center><i class="icon-fun fa fa-'.$modules_data[$key]['icon'].'"></center></td>
					<td>'.strTranslate(ucfirst($module['folder'])).'</td>
					<td class="legend">'.$module['ann'].'</td>
					<td width="40px">'.(isset($module_config['options']) ? '<a data-module="'.$module['folder'].'" class="configuration-trigger" href="#" title="'.strTranslate("Configuration").'"><i class="fa fa-gear"></i></a>' : '<i class="fa fa-gear disabled"></i>').'</td>
					</tr>';
				endforeach; ?>
			</table>
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
			<div class="modal-body">
			
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
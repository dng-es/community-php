<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

addJavascripts(array(getAsset("configuration")."js/admin-modules.js"));

session::getFlashMessage( 'actions_message' ); 
configurationController::updateAction();
$elements = configurationController::getItemAction();
$modules = configurationController::getListModulesAction();
?>
<div class="row  row-top">
	<div class="col-md-9">
		<h1><?php echo strTranslate("Modules_settings");?></h1>

		
		<br />
		<P>A continuación se muestran todos los módulos instalados</P>
		<table class="table">
			<tr>
				<th width="40px"></th>
				<th><?php echo strTranslate("Name");?></th>
				<th><?php echo strTranslate("Descripction");?></th>
			</tr>
		<?php foreach($modules as $module):
				$module_config = getModuleConfig($module['folder']);	
				echo '<tr>
				<td>'.(isset($module_config['options']) ? '<a data-module="'.$module['folder'].'" class="configuration-trigger" href="#" title="'.strTranslate("Configuration").'"><i class="fa fa-gear"></i></a>' : '<i class="fa fa-gear disabled"></i>').'</td>
				<td>'.$module['folder'].'</td>
				<td class="legend">'.$module['ann'].'</td>
				</tr>';
			endforeach;
		?>
		</table>

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
<?php
na_areasController::exportAreasAction();
na_areasController::exportUsersAreasAction();
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Na_areas"), "ItemUrl"=>"admin-areas"),
			array("ItemLabel"=> strTranslate("Na_areas_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		na_areasController::activateAction();
		na_areasController::getListAction();
		$elements = na_areasController::getListAction(10);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-area?act=new"><?php e_strTranslate("Na_areas_new");?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true&q=<?php echo $elements['find_reg'];?>"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'], "admin-areas", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Na_areas");?></th>
							<th><?php e_strTranslate("Channel");?></th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
							<?php
							if($element['estado'] == 1){
								$imagen_revision = '<i class="fa fa-check icon-ok"></i>';
								$valor_activar = 0;
								$texto_activar = "desactivar";
							}
							else{
								$imagen_revision = '<i class="fa fa-exclamation icon-alert"></i>';
								$valor_activar = 1;
								$texto_activar = "activar";
							}
							?>
								<tr>
								<td nowrap="nowrap">
									<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
										onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-areas?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_area'];?>&e=2')"><i class="fa fa-trash icon-table"></i>
									</button>
									
									<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
										onClick="location.href='admin-area?act=edit&id=<?php echo $element['id_area'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
									</button>

									<a type="button" href="admin-areas?id=<?php echo $element['id_area'];?>" class="btn btn-default btn-xs fa fa-download icon-table" title="Descargar usuarios"></a>

									<button type="button" class="btn btn-default btn-xs" onClick="Confirma('¿Seguro que quieres <?php echo $texto_activar;?> el curso?', 'admin-areas?act=del&e=<?php echo $valor_activar;?>&id=<?php echo $element['id_area'];?>'); return false;" 
									title="<?php echo $texto_activar;?> curso" /><?php echo $imagen_revision;?>
									</button>
								</td>
								<td><?php echo $element['area_nombre'];?>
								<br /><em class="text-muted"><small><?php echo getDateFormat($element['area_fecha'], "LONG");?></small></em></td>
								<td><?php echo $element['area_canal'];?></td>
								</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
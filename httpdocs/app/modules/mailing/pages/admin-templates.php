<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"admin-templates"),
			array("ItemLabel"=>strTranslate("Mailing_templates"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		mailingTemplatesController::deleteAction();
		mailingTemplatesController::updateEstadoAction();
		$elements = mailingTemplatesController::getListAction(20);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-template?act=new"><?php e_strTranslate("New_template");?></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Title");?></th>
							<th><?php e_strTranslate("Type");?></th>
							<th><?php e_strTranslate("Campaign");?></th>
							<th><center><?php e_strTranslate("Active");?></center></th>
						</tr>
						<?php foreach($elements['items'] as $element):
							$new_act = ($element['activo'] == 1 ? 0 : 1);
						?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="Eliminar"
									onClick="Confirma('¿Seguro que deseas eliminar la plantilla?', 'admin-templates?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_template'];?>'); return false;"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="Ver/editar"
									onClick="location.href='admin-template?id=<?php echo $element['id_template'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['template_name'];?></td>
							<td><?php echo $element['tipo'];?></td>
							<td><?php echo $element['campana'];?></td>
							<td align="center">
								<a href="#" onClick="Confirma('¿Seguro que deseas cambiar el estado de la plantilla?', 'admin-templates?pag=<?php echo $elements['pag'];?>&act=dela&a=<?php echo $new_act;?>&id=<?php echo $element['id_template'];?>'); return false;" >
									<span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo']==0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span>
								</a>
							</td>
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
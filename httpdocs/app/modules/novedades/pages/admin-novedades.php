<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("News"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		novedadesController::deleteAction();
		$elements = novedadesController::getListAction(5555, " ORDER BY orden ASC ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-novedad"><?php e_strTranslate("News_new");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-novedades","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Title");?></th>
							<th><?php e_strTranslate("Channel");?></th>
							<th><?php e_strTranslate("Profile");?></th>
							<th><?php e_strTranslate("Type");?></th>
							<th><?php e_strTranslate("Active");?></th>
							<th class="text-center">Orden</th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-novedades?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_novedad'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
									onClick="location.href='admin-novedad?id=<?php echo $element['id_novedad'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['titulo'];?></td>
							<td><?php echo ($element['canal'] != '' ? $element['canal'] : "TODOS LOS CANALES");?></td>
							<td><?php echo ($element['perfil'] != '' ? $element['perfil'] : "TODOS LOS PERFILES");?></td>
							<td><?php echo $element['tipo'];?></td>
							<td><span class="label<?php echo ($element['activo'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span></td>
							<td class="text-center"><?php echo $element['orden'];?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
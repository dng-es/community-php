<?php usersTiendasController::exportListAction();?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Users"), "ItemUrl"=>"admin-users"),
			array("ItemLabel"=>strTranslate("Users_groups_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		$elements = usersTiendasController::getListAction(15);
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<li><a href="admin-cargas-tiendas"><?php e_strTranslate("Groups_import");?></a></li>
					<div class="pull-right">
						<?php SearchForm($elements['reg'], "admin-users-tiendas", "searchForm", strTranslate("Search_group"), strTranslate("Search"), "", "navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>ID</th>
							<th><?php e_strTranslate("Name");?></th>
							<th>Regional</th>   
							<th>Responsable</th>
							<th><?php e_strTranslate("Type");?></th>
							<th><center><?php e_strTranslate("Active");?></center></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td><?php echo $element['cod_tienda'];?></td>
							<td><?php echo $element['nombre_tienda'];?></td>
							<td><?php echo $element['regional_tienda'];?></td>
							<td><?php echo $element['responsable_tienda'];?></td>
							<td><?php echo $element['tipo_tienda'];?></td>
							<td><center><span class="label<?php echo ($element['activa'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['activa'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></center></td>
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
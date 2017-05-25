<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides"), "ItemUrl"=>"admin-guides"),
			array("ItemLabel"=>strTranslate("Guides_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		guidesController::deleteAction();
		$elements = guidesController::getListAction(10, " AND active_guide= 1 ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-guide"><?php e_strTranslate("Guides_new");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-guides","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px">&nbsp;</th>
					<th><?php e_strTranslate("Name");?></th>
					<th><?php e_strTranslate("Guide_type");?></th>
					<th class="text-center"><?php e_strTranslate("Order");?></th>
					</tr>
					<?php foreach($elements['items'] as $element): ?>
					<tr>
						<td nowrap="nowrap">
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
								onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-guides?act=del&e=0&id=<?php echo $element['id_guide'];?>'); return false"><i class="fa fa-trash icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
								onClick="location.href='admin-guide?id=<?php echo $element['id_guide'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
							</button>

						</td>
						<td><?php echo $element['name_guide'];?></td>
						<td><?php echo $element['type_guide'];?></td>
						<td class="text-center"><?php echo $element['order_guide'];?></td>
					</tr>
					<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
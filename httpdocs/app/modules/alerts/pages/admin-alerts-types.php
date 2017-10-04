<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("MOD_Alerts"), "ItemUrl"=>"admin-alerts"),
			array("ItemLabel"=>strTranslate("MOD_Alert_types"), "ItemClass"=>"active"),
		));
		session::getFlashMessage( 'actions_message' );
		alertsTypesController::deleteAction();
		$elements = alertsTypesController::getListAction(15, " AND estado_type=1 ")
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<ul class="nav nav-pills navbar-default">
							<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
							<li><a href="admin-alerts-type"><?php e_strTranslate("MOD_Alert_type_new");?></a></li>
							<div class="pull-right">
								<?php echo SearchForm($elements['reg'], "admin-alerts-types", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
							</div>
						</ul>


						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th><?php e_strTranslate("Category");?></th>
								<th><?php e_strTranslate("Profile");?></th>
								<th width="40px"></th>
								</tr>	
								<?php foreach($elements['items'] as $element):?>
									<tr>
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-alerts-types?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_alert_type'];?>'); return false"><i class="fa fa-trash icon-table"></i>
										</button>

										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-alerts-type?id=<?php echo $element['id_alert_type'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
										</button>
									</td>
									<td><?php echo $element['name_type'];?></td>
									<td><?php echo $element['perfiles_type'];?></td>
									<td><span class="label" style="color: #fff;background-color: <?php echo $element['color_type'];?>"><i class="fa fa-<?php echo $element['icon_type'];?>"></i></span></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>
						<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
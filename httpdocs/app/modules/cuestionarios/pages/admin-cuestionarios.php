<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Forms"), "ItemUrl"=>"admin-cuestionarios"),
			array("ItemLabel"=>strTranslate("Forms_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		cuestionariosController::deleteAction();
		cuestionariosController::cloneAction();
		$elements = cuestionariosController::getListAction(10, " AND activo<>2 ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-cuestionario"><?php e_strTranslate("New_form");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-cuestionarios","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px">&nbsp;</th>
					<th><?php e_strTranslate("Name");?></th>
					<th><center><?php e_strTranslate("Active");?></center></th>
					</tr>
					<?php foreach($elements['items'] as $element):?>
						<tr>
						<td nowrap="nowrap">
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
								onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-cuestionarios?act=del&e=2&id=<?php echo $element['id_cuestionario'];?>'); return false"><i class="fa fa-trash icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
								onClick="location.href='admin-cuestionario?id=<?php echo $element['id_cuestionario'];?>'"><i class="fa fa-edit icon-table"></i>
							</button>
							
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Reviews");?>"
								onClick="location.href='admin-cuestionario-revs?id=<?php echo $element['id_cuestionario'];?>'; return false"><i class="fa fa-check icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Show");?>" onClick="location.href='cuestionario?id=<?php echo $element['id_cuestionario'];?>'">
								<i class="fa fa-share icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Clone_item");?>" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_clone");?>', 'admin-cuestionarios?act=clone&id=<?php echo $element['id_cuestionario'];?>'); return false"><i class="fa fa-copy icon-table"></i>
							</button>
						</td>
						<td><?php echo $element['nombre'];?>
						<br /><em class="text-muted"><small><?php echo getDateFormat($element['date_tarea'], "LONG");?></small></em></td>
						<td><center><a href="admin-cuestionarios?act=del&e=<?php echo ($element['activo']==1 ? 0 : 1);?>&id=<?php echo $element['id_cuestionario'];?>"><span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo']==1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></a></center></td>
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
<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);

//EXPORT REGS.
rankingsController::ExportRankingDataAction();
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Rankings_list"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		rankingsController::deleteAction();
		$elements = rankingsController::getListAction(15, " AND activo<>2 ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">      
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-ranking"><?php e_strTranslate("New_ranking");?></a></li>
				</ul>
				
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px">&nbsp;</th>
					<th><?php e_strTranslate("Name");?></th>
					<th><?php e_strTranslate("Category");?></th>
					<th><?php e_strTranslate("Active");?></th>
					</tr>		
					<?php foreach($elements['items'] as $element):?>
						<tr>
						<td nowrap="nowrap">
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-rankings?e=2&act=del&id=<?php echo $element['id_ranking'];?>'); return false"><i class="fa fa-trash icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-ranking?id=<?php echo $element['id_ranking'];?>'"><i class="fa fa-edit icon-table"></i>
							</button>

							<button type="button" class="btn btn-default btn-xs">
								<a title="<?php e_strTranslate("Show");?>" target="_blank" href="rankings?id=<?php echo $element['id_ranking'];?>">
									<i class="fa fa-share icon-table"></i>
								</a>
							</button>

							<button type="button" class="btn btn-default btn-xs">
								<a href="admin-rankings?exp=<?php echo $element['id_ranking'];?>" class="fa fa-download icon-table" title="descargar datos"></a>
							</button>
						</td>
						<td><?php echo $element['nombre_ranking'];?></td>
						<td><?php echo $element['ranking_category_name'];?></td>
						<td><a href="admin-rankings?act=del&e=<?php echo ($element['activo']==1 ? 0 : 1);?>&id=<?php echo $element['id_ranking'];?>"><span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo']==1 ? "sí" : "no");?></span></a></td>
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
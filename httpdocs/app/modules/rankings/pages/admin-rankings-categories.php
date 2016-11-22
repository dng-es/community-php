<?php
//CONTROL NIVEL DE ACCESO
$perfiles_autorizados = array("admin");
session::AccessLevel($perfiles_autorizados);
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Listado de categorías"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' ); 
		$elements = rankingsController::getListCategoryAction(5, " ");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-rankings-category">nueva categoria</a></li>
				</ul>
				
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px">&nbsp;</th>
					<th><?php e_strTranslate("Name");?></th>
					<th>num.rankings</th>
					</tr>
					<?php foreach($elements['items'] as $element): 
						$num_rankings = connection::countReg("users_tiendas_rankings", " AND id_ranking_category=".$element['id_ranking_category']." ");
						?>
						<tr>
						<td nowrap="nowrap">
							<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-rankings-category?id=<?php echo $element['id_ranking_category'];?>'; return false"><i class="fa fa-edit icon-table"></i>
							</button>
						</td>
						<td><?php echo $element['ranking_category_name'];?></td>
						<td><?php echo $num_rankings;?></td>
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
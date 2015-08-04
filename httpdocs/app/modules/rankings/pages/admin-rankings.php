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
		<ul class="nav nav-pills navbar-default">      
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="admin-ranking"><?php echo strTranslate("New_ranking");?></a></li>
		</ul>
		
		<table class="table table_striped">
		<tr>
		<th width="40px">&nbsp;</th>
		<th><?php echo strTranslate("Name");?></th>
		<th><?php echo strTranslate("Category");?></th>
		<th><?php echo strTranslate("Active");?></th>
		</tr>		
		<?php foreach($elements['items'] as $element): ?>
			<tr>
			<td nowrap="nowrap">
				<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
					onClick="location.href='admin-ranking?id=<?php echo $element['id_ranking'];?>'">
				</span>

				<a title="<?php echo strTranslate("Show");?>" target="_blank" href="rankings?id=<?php echo $element['id_ranking'];?>">
					<i class="fa fa-share icon-table"></i>
				</a>

				<a href="admin-rankings?exp=<?php echo $element['id_ranking'];?>" class="fa fa-download icon-table" title="descargar datos"></a>

				<span class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
					onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-rankings?e=2&act=del&id=<?php echo $element['id_ranking'];?>')">
				</span>

			</td>						
			<td><?php echo $element['nombre_ranking'];?></td>
			<td><?php echo $element['ranking_category_name'];?></td>
			<td><a href="admin-rankings?act=del&e=<?php echo ($element['activo']==1 ? 0 : 1);?>&id=<?php echo $element['id_ranking'];?>"><span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo ($element['activo']==1 ? "sí" : "no");?></span></a></td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
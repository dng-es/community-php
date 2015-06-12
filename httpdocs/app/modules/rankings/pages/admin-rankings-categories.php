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
		<ul class="nav nav-pills navbar-default">      
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="?page=admin-rankings-category">nueva categoria</a></li>
		</ul>
		
		<table class="table table-striped">
		<tr>
		<th width="40px">&nbsp;</th>
		<th><?php echo strTranslate("Name");?></th>
		<th>num.rankings</th>
		</tr>		
		<?php foreach($elements['items'] as $element): 
		$num_rankings = connection::countReg("users_tiendas_rankings"," AND id_ranking_category=".$element['id_ranking_category']." ");
		?>
			<tr>
			<td nowrap="nowrap">
				<span class="fa fa-edit icon-table" title="<?php echo strTranslate("Edit");?>"
					onClick="location.href='?page=admin-rankings-category&id=<?php echo $element['id_ranking_category'];?>'">
				</span>
			</td>						
			<td><?php echo $element['ranking_category_name'];?></td>
			<td><?php echo $num_rankings;?></td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
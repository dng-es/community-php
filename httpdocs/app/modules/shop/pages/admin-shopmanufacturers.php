<?php
$filtro = " AND active_manufacturer=1 ";

if (isset($_POST['find_reg'])) $filtro .= " AND name_manufacturer LIKE '%".$_POST['find_reg']."%' ";
if (isset($_REQUEST['f'])) $filtro .= " AND name_manufacturer LIKE '%".$_REQUEST['f']."%' ";
$filtro .= " ORDER BY name_manufacturer DESC";

session::getFlashMessage( 'actions_message' );
shopManufacturersController::exportListAction($filtro);
shopManufacturersController::deleteAction();
$elements = shopManufacturersController::getListAction(15, $filtro);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=> strTranslate("Shop_manufacturers_list"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="admin-shopmanufacturer"><?php e_strTranslate("Shop_manufacturer_new");?></a></li>
			<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
			<div class="pull-right">
				<?php echo SearchForm($elements['reg'], "admin-shopmanufacturers", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
			</div>
		</ul>
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<tr>
					<th width="40px">&nbsp;</th>
					<th width="100px" class="text-center">ID</th>
					<th><?php e_strTranslate("Name");?></th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
				<tr>
					<td nowrap="nowrap">
						<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
							onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-shopmanufacturers?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_manufacturer'];?>'); return false"><i class="fa fa-trash icon-table"></i>
						</button>

						<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
							onClick="location.href='admin-shopmanufacturer?id=<?php echo $element['id_manufacturer'];?>'; return false"><i class="fa fa-edit icon-table"></i>
						</button>
					</td>
					<td class="text-center"><?php echo $element['id_manufacturer'];?></td>
					<td><?php echo $element['name_manufacturer'];?></td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-shopmanufacturers',strTranslate("Shop_manufacturers"), $elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
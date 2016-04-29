<?php
templateload("searchproducts","shop");
$filtro = " AND active_product=1 ";

if (isset($_REQUEST['ref_search'])) $filtro .= " AND ref_product LIKE '%".$_REQUEST['ref_search']."%' ";
if (isset($_REQUEST['name_search'])) $filtro .= " AND name_product LIKE '%".$_REQUEST['name_search']."%' ";
if (isset($_REQUEST['manufacturer_search'])) $filtro .= " AND name_manufacturer LIKE '%".$_REQUEST['manufacturer_search']."%' ";
if (isset($_REQUEST['category_search'])) $filtro .= " AND category_product LIKE '%".$_REQUEST['category_search']."%' ";
if (isset($_REQUEST['subcategory_search'])) $filtro .= " AND subcategory_product LIKE '%".$_REQUEST['subcategory_search']."%' ";
$filtro .= " ORDER BY name_product DESC";

session::getFlashMessage( 'actions_message' );
shopProductsController::exportListAction($filtro);
shopProductsController::deleteAction();
$elements = shopProductsController::getListAction(15, $filtro);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"admin-shopproducts"),
			array("ItemLabel"=> strTranslate("Shop_products_list"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">     
			<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="admin-shopproduct"><?php e_strTranslate("Shop_product_new");?></a></li>
			<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
		</ul>
		<div class="row">
			<div class="col-md-7">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th><?php e_strTranslate("Name");?></th>
							<th>Stock</th>
						</tr>		
						<?php foreach($elements['items'] as $element): ?>
								<tr>
									<td nowrap="nowrap">
										<span class="fa fa-edit icon-table" title="<?php e_strTranslate("Edit");?>"
											onClick="location.href='admin-shopproduct?id=<?php echo $element['id_product'];?>'">
										</span>

										<span class="fa fa-ban icon-table" title="<?php e_strTranslate("Delete");?>"
											onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-shopproducts?pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_product'];?>')">
										</span>
									</td>
									<td><?php echo $element['id_product'];?></td>
									<td><?php echo $element['name_product'];?></td>
									<td><?php echo $element['stock_product'];?></td>
								</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<?php searchProducts("admin-shopproducts");?>
			</div>
		</div>
		<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-shopproducts',strTranslate("APP_Shop"), $elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/shop/pages' : 'modules\\shop\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");
include_once($base_dir . "modules/pages/classes/class.pages.php");
include_once($base_dir . "modules/class.footer.php");

addJavascripts(array(getAsset("shop")."js/admin-shoporders.js"));

$filtro = "";
if (isset($_POST['find_reg'])) $filtro .= " AND d.id_order LIKE '%".$_POST['find_reg']."%' ";
if (isset($_REQUEST['f'])) $filtro .= " AND d.id_order LIKE '%".$_REQUEST['f']."%' ";
$filtro .= " ORDER BY d.id_order DESC";

shopOrdersController::exportListDetailAction($filtro);
session::getFlashMessage( 'actions_message' );
shopOrdersController::estadosAction();
$elements = shopOrdersController::getListDetailAction(15, $filtro);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"admin-shoporders"),
			array("ItemLabel"=> strTranslate("Shop_orders_list"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">     
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'];?>?export=true"><?php e_strTranslate("Export");?></a></li>
					<li><a href="admin-cargas-states"><?php e_strTranslate("Import_order_states");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'], "admin-shoporders", "searchForm", strTranslate("Search"), strTranslate("Search"), "", "navbar-form navbar-left");?>
					</div>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th>ID</th>
							<th><?php e_strTranslate("User");?></th>
							<th>Artículo</th>
							<th><?php e_strTranslate("Date");?></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
						<?php foreach($elements['items'] as $element): ?>
								<tr>
								<form class="form-inline form-status" name="form-status-<?php echo $element['id_order'];?>" id="form-status-<?php echo $element['id_order'];?>" method="post">
								<input type="hidden" name="id_order" id="id_order" value="<?php echo $element['id_order'];?>" />
								<input type="hidden" name="status_order_old" id="status_order_old" value="<?php echo $element['status_order'];?>" />
									<td nowrap="nowrap">
										<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>"
											onClick="location.href='admin-shopordersdetail?id=<?php echo $element['id_order'];?>'; return false;"><i class="fa fa-edit icon-table"></i>
										</button>
									</td>
									<td><?php echo $element['id_order'];?></td>
									<td><?php echo $element['username_order'];?></td>
									<td><?php echo $element['name_product'];?></td>
									<td><?php echo getDateFormat($element['date_order'], 'SHORT');?></td>
									<td>
										<select name="status_order" class="form-control input-xs">
											<?php if ($element['status_order'] != 'finalizado'):?>
											<option value="finalizado">Finalizado</option>
											<?php endif;?>
											<?php if ($element['status_order'] != 'cancelado'):?>
											<option value="cancelado">Cancelado</option>
											<?php endif;?>
											<?php if ($element['status_order'] != 'pendiente'):?>
											<option value="pendiente">Pendiente</option>
											<?php endif;?>
										</select>
									</td>
									<td>
										<input data-ido="<?php echo $element['id_order'];?>" type="button" value="cambiar estado" class="btn btn-primary btn-xs btn-status" />
									</td>
									<td>
										<?php if($element['status_order'] == 'cancelado'):?>
											<span class="label label-danger">Cancelado</span>
										<?php endif;?>

										<?php if($element['status_order'] == 'finalizado'):?>
											<span class="label label-success">Finalizado</span>
										<?php endif;?>

										<?php if($element['status_order'] == 'pendiente'):?>
											<span class="label label-warning">Pendiente</span>
										<?php endif;?>
									</td>
								</form>
								</tr>
						<?php endforeach;?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], 'admin-shoporders', 'Pedidos', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
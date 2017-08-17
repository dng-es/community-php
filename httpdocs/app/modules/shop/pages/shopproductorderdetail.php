<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/shop/pages' : 'modules\\shop\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "modules/class.headers.php");
include_once($base_dir . "modules/pages/classes/class.pages.php");
include_once($base_dir . "modules/class.footer.php");

session::getFlashMessage( 'actions_message' );

shopOrdersController::createAction();
$id = ((isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? sanitizeInput($_REQUEST['id']) : 0);
$filtro_order = " AND username_order='".$_SESSION['user_name']."' AND d.id_order=".$id." ";

$elements = shopOrdersController::getListDetailAction(1, $filtro_order);
$historico = shopOrdersController::getListStatusAction(100, " AND id_order=".$id." ");
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("APP_Shop"), "ItemUrl"=>"shopproducts"),
			array("ItemLabel"=> "Realizar pedido", "ItemClass"=>"active"),
		));
		if (isset($elements['items'][0])):
			$element = $elements['items'][0];?>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<h2>
							Datos del pedido <?php echo $id;?>
							<?php if($element['status_order'] == 'cancelado'):?>
								<small><span class="label label-danger">Cancelado</span></small>
							<?php endif;?>

							<?php if($element['status_order'] == 'finalizado'):?>
								<small><span class="label label-success">Finalizado</span></small>
							<?php endif;?>

							<?php if($element['status_order'] == 'pendiente'):?>
								<small><span class="label label-warning">Pendiente</span></small>
							<?php endif;?>
						</h2>
						<div class="col-md-6">
							<table class="table">
								<tr><td colspan="2">
									<label class="control-label"><i class="fa fa-check-square-o"></i> Fecha solicitud:</label> <?php echo getDateFormat($element['date_order'], 'DATE_TIME');?>
								</td></tr>

							<?php foreach($historico['items'] as $historico_status): ?>
								<tr>
									<td><span class="label label-info"><?php echo $historico_status['order_status'];?></span></td>
									<td width="100%"><?php echo getDateFormat($historico_status['date_status'], 'DATE_TIME');?></td>
								</tr>
							<?php endforeach;?>

							</table>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<th colspan="2">Artículos</th>
										<th class="text-center">Precio</th>
									</tr>
									<tr>
										<td width="80px">
											<img src="images/shop/<?php echo $element['image_product'];?>" width="80px" />
										</td>
										<td>
											<?php echo $element['name_product'];?><br />
											<small class="text-muted"><?php echo shortText(html_entity_decode(strip_tags($element['description_product'])), 50);?></small>
										</td>
										<td class="text-center">
											<big><?php echo $element['price_order'];?></big> <small><?php e_strTranslate("APP_Credits");?></small>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<h2>Datos de entrega</h2>
						<div class="col-md-6">
							<table class="table">
								<tr><td>
									<label class="control-label" for="name_order"><?php e_strTranslate("Name");?>: </label>
									<?php echo $element['name_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="surname_order"><?php e_strTranslate("Surname");?>: </label>
									<?php echo $element['surname_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="telephone_order"><?php e_strTranslate("Telephone");?>: </label>
									<?php echo $element['telephone_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="postal_order"><?php e_strTranslate("Order_notes");?>: </label>
									<?php echo $element['notes_order'];?>
								</td></tr>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table">
								<tr><td>
									<label class="control-label" for="address_order"><?php e_strTranslate("Group_user");?>: </label>
									<?php echo $element['address_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="address_order"><?php e_strTranslate("Address");?>: </label>
									<?php echo $element['address2_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="city_order"><?php e_strTranslate("City");?>: </label>
									<?php echo $element['city_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="state_order"><?php e_strTranslate("State");?>: </label>
									<?php echo $element['state_order'];?>
								</td></tr>
								<tr><td>
									<label class="control-label" for="postal_order"><?php e_strTranslate("Postal_code");?>: </label>
									<?php echo $element['postal_order'];?>
								</td></tr>
							</table>
						</div>
					</div>
				</div>
			</div>		
			<?php else:?>
			<div class="row">
				<div class="col-md-12">
					<?php e_strTranslate("Error_procesing");?>
				</div>
			</div>
			<?php endif;?>
	</div>
	<div class="app-sidebar hidden-xs hidden-sm">
		<div class="panel-interior">
			<h2><?php e_strTranslate("APP_Shop");?></h2>
			<p>Puedes canjear tus <?php e_strTranslate("APP_Credits");?> por fantasticos <?php strtolower(e_strTranslate("Shop_products"));?>!</p>
			<p class="text-center"><i class="fa fa-shopping-cart fa-big"></i></p>
		</div>
	</div>
</div>
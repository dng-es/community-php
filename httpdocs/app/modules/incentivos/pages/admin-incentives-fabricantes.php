<?php
incentivosFabricantesController::exportAction();

addJavascripts(array(getAsset("incentivos")."js/admin-incentives-fabricantes.js"));

session::getFlashMessage( 'actions_message' ); 
incentivosFabricantesController::createAction();
incentivosFabricantesController::deleteAction();
$elements = incentivosFabricantesController::getListAction(35);
?>

<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"admin-incentives"),
			array("ItemLabel"=>strTranslate("Incentives_manufacturers"), "ItemClass"=>"active"),
		));
		?>
		<ul class="nav nav-pills navbar-default">       
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
			<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php echo strTranslate("Export");?></a></li>
		</ul>
		<br />

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
								<th width="40px"></th>
								<th><?php echo strTranslate("Incentives_manufacturers");?></th>
								<th width="60px"></th>
								</tr>	
								<?php foreach($elements['items'] as $element):?>
									<tr>
										<td nowrap="nowrap">						
											<span class="fa fa-ban icon-table" title="<?php echo strTranslate("Delete");?>"
												onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', 'admin-incentives-fabricantes&pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_fabricante'];?>', '<?php echo strTranslate("Are_you_sure");?>', '<?php echo strTranslate("Cancel_text");?>', '<?php echo strTranslate("Confirm_text");?>')">
											</span>
										</td>					
										<td><?php echo $element['nombre_fabricante'];?></td>
										<td>
											<a class="btn btn-default btn-xs" href="admin-incentives-products?m=<?php echo $element['id_fabricante'];?>"><?php echo strTranslate("Incentives_products");?></a>
										</td>
									</tr>  
								<?php endforeach; ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><?php echo strTranslate("Incentives_manufacturers_new");?></div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<div class="form-group">
								<label for="fabricante-nombre"><?php echo strTranslate("Incentives_manufacturer");?></label>
								<input type="text" class="form-control" name="fabricante-nombre" id="fabricante-nombre" data-alert="<?php echo strTranslate("Required_field");?>" />
							</div>
							<button type="submit" class="btn btn-primary"><?php echo strTranslate("Save_data");?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
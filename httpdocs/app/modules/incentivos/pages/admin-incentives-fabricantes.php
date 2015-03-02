<?php
addJavascripts(array(getAsset("incentivos")."js/admin-incentives-fabricantes.js"));

session::getFlashMessage( 'actions_message' ); 
incentivosFabricantesController::createAction();
incentivosFabricantesController::deleteAction();
$elements = incentivosFabricantesController::getListAction(35);
?>

<div class="row row-top">
	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Incentives"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Fabricantes", "ItemClass"=>"active"),
		));
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th>Fabricantes</th>
						</tr>	
						<?php foreach($elements['items'] as $element):?>
							<tr>
							<td nowrap="nowrap">						
								<span class="fa fa-ban icon-table" title="Eliminar"
									onClick="Confirma('¿Seguro que desea eliminar el fabricante?', 'admin-incentives-fabricantes&pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_fabricante'];?>')">
								</span>
							</td>					
							<td><?php echo $element['nombre_fabricante'];?></td>
							</tr>  
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">Nuevo fabricante</div>
					<div class="panel-body">
						<form role="form" action="" method="post" name="formData" id="formData">
							<label for="fabricante-nombre">Nombre del fabricante</label>
							<input type="text" class="form-control" name="fabricante-nombre" id="fabricante-nombre" data-alert="<?php echo strTranslate("Required_field");?>" />
							<br />
							<button type="submit" class="btn btn-primary">Crear fabricante</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
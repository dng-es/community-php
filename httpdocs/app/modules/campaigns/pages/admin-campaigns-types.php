<?php
session::getFlashMessage( 'actions_message' ); 
campaignsController::deleteTypeAction();
$elements = campaignsController::getListTypesAction(20);
?>
<div class="row row-top">
  	<div class="col-md-9 inset">
  		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Campaigns"), "ItemUrl"=>"?page=admin-campaigns"),
			array("ItemLabel"=>strTranslate("Campaign_types"), "ItemClass"=>"active"),
		));?>
		<ul class="nav nav-pills navbar-default">
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>  
			<li><a href="?page=admin-campaigns-type&act=new">Nuevo tipo</a></li>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>Nombre</th>
					<th>Descripcion</th>
				</tr>
				<?php foreach($elements['items'] as $element): ?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar"
							onClick="location.href='?page=admin-campaigns-type&id=<?php echo $element['id_campaign_type'];?>'; return false;">
						</a>

						<a class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que deseas eliminar el tipo?', '?page=admin-campaigns-types&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_campaign_type'];?>'); return false;">
						</a>
					</td>			
					<td><?php echo $element['campaign_type_name'];?></td>
					<td><?php echo $element['campaign_type_desc'];?></td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
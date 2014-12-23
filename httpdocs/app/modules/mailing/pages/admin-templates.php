<?php
session::getFlashMessage( 'actions_message' ); 
mailingTemplatesController::deleteAction();
mailingTemplatesController::updateEstadoAction();
$elements = mailingTemplatesController::getListAction(20);

?>
<div class="row row-top">
  	<div class="col-md-9 inset">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"?page=home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"?page=admin"),
			array("ItemLabel"=>strTranslate("Massive_Mailing"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Mailing_templates"), "ItemClass"=>"active"),
		));
		?>		
		<ul class="nav nav-pills navbar-default">     
			<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>    
			<li><a href="?page=admin-template&act=new">Nueva plantilla</a></li>
		</ul>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="40px">&nbsp;</th>
					<th>Nombre de la plantilla</th>
					<th>Tipo</th>
					<th>Campaña</th>
					<th>Activo</th>
				</tr>
				<?php foreach($elements['items'] as $element): 
					$new_act = ($element['activo']==1 ? 0 : 1);
				?>
					<tr>
					<td nowrap="nowrap">
						<a class="fa fa-edit icon-table" title="Ver/editar"
							onClick="location.href='?page=admin-template&id=<?php echo $element['id_template'];?>'; return false;">
						</a>

						<a class="fa fa-ban icon-table" title="Eliminar"
							onClick="Confirma('¿Seguro que deseas eliminar la plantilla?', '?page=admin-templates&pag=<?php echo $elements['pag'];?>&act=del&id=<?php echo $element['id_template'];?>'); return false;">
						</a>
					</td>			
					<td><?php echo $element['template_name'];?></td>
					<td><?php echo $element['tipo'];?></td>
					<td><?php echo $element['campana'];?></td>
					<td>
						<a href="#" onClick="Confirma('¿Seguro que deseas cambiar el estado de la plantilla?', '?page=admin-templates&pag=<?php echo $elements['pag'];?>&act=dela&a=<?php echo $new_act;?>&id=<?php echo $element['id_template'];?>'); return false;" >
							<span class="label<?php echo ($element['activo']==0 ? " label-danger" : " label-success");?>"><?php echo $element['activo'];?></span>
						</a>
					</td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>
		<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page'],'',$elements['find_reg']);?>
	</div>
	<?php menu::adminMenu();?>
</div>
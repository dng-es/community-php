<?php
session::getFlashMessage( 'actions_message' );
promocionesController::activeAction();
$elements = promocionesController::getListAction(35);
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Retos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Listado de retos"), "ItemClass"=>"active"),
		));
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">       
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-promociones-new"><?php e_strTranslate("Nuevo reto");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-promociones","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
						<th width="40px"></th>
						<th><?php e_strTranslate("Name");?></th>
						<th>Fotos</th>
						<th>Videos</th>
						<th>Comentarios</th>
						<th>Activo</th>
						<th width="40px"></th>
						</tr>	
						<?php foreach($elements['items'] as $element):
							$texto_activar1 = ($element['active'] == 1 ? '¿Seguro que deseas desactivar?' : '¿Seguro que deseas activar?');
							$texto_activar = ($element['active'] == 1 ? '¿Seguro que deseas desactivar?' : '¿Seguro que deseas activar?');
							$valor_activar = ($element['active'] == 1 ? 0 : 1);
							?>
							<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php echo $texto_activar1;?>" onClick="Confirma('<?php echo $texto_activar;?>', 'admin-promociones?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&idd='.$valor_activar.'&id='.$element['id_promocion'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-promociones-new?id=<?php echo $element['id_promocion'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><?php echo $element['nombre_promocion'];?></td>
							<td><span class="label<?php echo ($element['galeria_videos'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['galeria_videos'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
							<td><span class="label<?php echo ($element['galeria_fotos'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['galeria_fotos'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span></td>
							<td><span class="label<?php echo ($element['galeria_comentarios'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['galeria_comentarios'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span></td>
							<td><span class="label<?php echo ($element['active'] == 0 ? " label-danger" : " label-success");?>"><?php echo ($element['active'] == 1 ? strTranslate("App_Yes") : strTranslate("App_No"));?></span></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>"Listado de emociones", "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		emocionesController::deleteAction();
		$elements = emocionesController::getListAction(35, " AND active=1 ");
		?>	
		<div class="panel panel-default">
			<div class="panel-body">	
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="admin-emocion">Nueva emoción</a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-hover table-striped">
						<tr>
							<th width="40px"></th>
							<th width="60px"></th>
							<th><?php e_strTranslate("Emotion");?></th>
						</tr>
						<?php foreach($elements['items'] as $element):?>
						<tr>
							<td nowrap="nowrap">
								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
									onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-emociones?pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_emocion'];?>'); return false"><i class="fa fa-trash icon-table"></i>
								</button>

								<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Edit");?>" onClick="location.href='admin-emocion?id=<?php echo $element['id_emocion'];?>'; return false"><i class="fa fa-edit icon-table"></i>
								</button>
							</td>
							<td><img style="height: 50px" src="images/emociones/<?php echo $element['image_emocion'];?>" /></td>
							<td><?php echo $element['name_emocion'];?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
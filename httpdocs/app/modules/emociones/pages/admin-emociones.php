<?php
//EXPORT USERS
usersController::exportListAction();
?>
<div class="row row-top">
	<div class="col-md-6 col-md-offset-3">
		<div class="col-md-12">
			<h1>alta y modificación de emociones</h1>
			<?php
			session::getFlashMessage('actions_message');
			emocionesController::deleteAction();
			$elements = emocionesController::getListAction(35, " AND active=1 ");
			?>
			<a href="?page=admin-emocion" class="btn btn-primary">nueva emoción</a>
			<div class="clearfix"></div>
			<br />
			<p><?php echo strtolower(strTranslate("Total"));?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></p>
			<table class="table" >
				<tr>
				<th width="40px"></th>
				<th><?php e_strTranslate("Image");?></th>
				<th><?php e_strTranslate("Emotion");?></th>
				</tr>
				<?php foreach($elements['items'] as $element):?>
					<tr>
					<td nowrap="nowrap">
						<span class="fa fa-edit icon-table" title="<?php e_strTranslate("Edit");?>" onClick="location.href='?page=admin-emocion&act=edit&id=<?php echo $element['id_emocion'];?>'">
						</span>
						
						<span class="fa fa-ban icon-table" title="eliminar"
							onClick="Confirma('¿Seguro que desea eliminar la emoción?', '?page=admin-emociones&pag=<?php echo $elements['pag'].'&f='.$elements['find_reg'].'&act=del&id='.$element['id_emocion'];?>')">
						</span>
					</td>
					<td><img style="height: 50px" src="images/banners/<?php echo $element['image_emocion'];?>" /></td>
					<td><?php echo $element['name_emocion'];?></td>
					</tr>
				<?php endforeach;?>
			</table>
			<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
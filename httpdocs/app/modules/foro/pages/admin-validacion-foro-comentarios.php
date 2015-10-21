<?php
session::getFlashMessage( 'actions_message' );
foroController::validateComentarioAction();
foroController::cancelComentarioAction();
$elements = foroController::getListComentariosAction(15, " AND estado=1 ORDER BY id_comentario DESC");?>

<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemUrl"=>"#"),
			array("ItemLabel"=>"Comentarios en los foros", "ItemClass"=>"active"),
		));?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default"> 
					<li class="disabled"><a href="#"><?php echo strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por mensaje: <b><?php echo PUNTOS_FORO;?></b></a></li>
				</ul>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
						<th width="40px">&nbsp;</th>
						<th>ID</th>
						<th><?php echo strTranslate("Comment");?></th>
					</tr>
					<?php foreach($elements['items'] as $element):
						echo '<tr>';
						echo '<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" title="Eliminar"
								    onClick="Confirma(\'¿Seguro que desea eliminar el comentario '.$element['id_comentario'].'?\',
									\'admin-validacion-foro-comentarios?pag='.(isset($_REQUEST['pag']) ? $_REQUEST['pag'] : 1).'&act=foro_ko&id='.$element['id_comentario'].'&u='.$element['user_comentario'].'\')">
								</span>
							 </td>';
						echo '<td>'.$element['id_comentario'].'</td>';
						echo '<td>
								<p class="text-muted"><small>'.$element['user_comentario'].' ('.$element['canal'].') '.getDateFormat($element['date_comentario'], "SHORT").' - <b>'.strTranslate("Forum").'</b>: '.$element['nombre'].'</small><br />
							<em class="text-primary">'.$element['comentario'].'</em></p>';
						echo '</tr>';
					endforeach;?>
					</table>
				</div>
				<br />
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
<?php
$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);

set_time_limit(0);
ini_set('memory_limit', '-1');

//EXPORT REGS
fotosController::exportListAction(" AND f.id_album=".$id." ");

addJavascripts(array(getAsset("fotos")."js/admin-albumes-new.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Photo_albums"), "ItemUrl"=>"admin-albumes"),
			array("ItemLabel"=>strTranslate("Edit")." ".strTranslate("Photo_albums"), "ItemClass"=>"active"),
		));

		session::getFlashMessage('actions_message');
		fotosController::changeTags();
		fotosAlbumController::addFotoAction();
		fotosAlbumController::cancelFotoAction();
		fotosAlbumController::createAction();
		fotosAlbumController::updateAction();
		$album = fotosAlbumController::getItemAction($id); 
		$elements = fotosController::getListAction(15, "AND estado=1 AND f.id_album=".$id." ");?>

		<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading"><?php e_strTranslate("Photo_albums");?></div>
				<div class="panel-body">
					<form id="form-album" name="form-album" method="post" action="" role="form">
						<input type="hidden" name="id" value="<?php echo $id;?>" />
						<div class="form-group">
							<label for="nombre"><?php e_strTranslate("Title");?></label>
							<input type="text" class="form-control form-big" name="nombre" id="nombre" value="<?php echo isset($album[0]) ? $album[0]['nombre_album'] : '';?>" placeholder="<?php e_strTranslate("Title");?>" />
						</div>
						<div class="form-group">
							<label for="canal_album"><?php e_strTranslate("Channel");?></label>
							<select name="canal_album[]" id="canal_album" class="selectpicker show-menu-arrow show-tick" data-container="body" data-style="btn-default" data-width="100%" multiple data-actions-box="true" data-none-selected-text="<?php e_strTranslate("Choose_channel");?>" data-deselect-all-text="<?php e_strTranslate('deselect_all');?>"  data-select-all-text="<?php e_strTranslate('select_all');?>">
								<?php comboCanales(isset($album[0]) ? $album[0]['canal_album'] : '');?>
							</select>
						</div>
						<input type="submit" name="SubmitData" class="btn btn-primary" value="<?php e_strTranslate("Save_data");?>" />
					</form>
				</div>
			</div>
		</div>

		<?php if ($id > 0): ?>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Agregar imagen al álbum</div>
				<div class="panel-body">
					<form action="admin-albumes-new?act=edit&id=<?php echo $id;?>" method="post" role="form">
						<input type="hidden" name="id_album" value="<?php echo $id;?>" />
						<label for="file_id">Introduce el ID de la foto:</label>
						<input type="text" class="form-control entero" name="file_id" id="file_id" />
						<br />
						<button type="submit" class="btn btn-primary">Agregar foto</button>
					</form>
				</div>
			</div>
		</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Fotos incluidas en el álbum</div>
					<div class="panel-body">
						<?php 
						if (count($elements['items']) == 0):?>
							<div class="alert alert-warning">No existen fotos en el álbum</div>
						<?php else: ?>
							<ul class="nav nav-pills navbar-default">
								<li class="disabled"><a href="#"><?php e_strTranslate("Items");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
								<li><a href="<?php echo $_SERVER['REQUEST_URI'].'&export=true';?>"><?php e_strTranslate("Export");?></a></li>
							</ul>
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<tr>
										<th width="40px">&nbsp;</th>
										<th>ID</th>
										<th><?php e_strTranslate("Title");?></th>
										<th><?php e_strTranslate("Tags");?></th>
										<th><?php e_strTranslate("Date");?></th>
										<th><?php e_strTranslate("User");?></th>
										<th><span class="fa fa-heart"></span></th>
										<th><span class="fa fa-comment"></span></th>
									</tr>
									<?php foreach($elements['items'] as $element):
										$num_comentarios = connection::countReg("galeria_fotos_comentarios", " AND estado=1 AND id_file=".$element['id_file']." ");?>
										<tr>
											<td nowrap="nowrap">
												<button type="button" class="btn btn-default btn-xs" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-albumes-new?act=foto_ko&id=<?php echo $id.'&idf='.$element['id_file'].'&u='.$element['user_add'];?>'); return false;" title="<?php e_strTranslate("Delete");?>" /><i class="fa fa-trash icon-table"></i></button>
											</td>
											<td><?php echo $element['id_file'];?></td>
											<td><a href="#" data-img="<?php echo $element['name_file'];?>" class="abrir-modal"><?php echo $element['titulo'];?></a></td>
											<td><input type="text" name="tipo_foto" id="tipo_foto_<?php echo $element['id_file'];?>" value="<?php echo $element['tipo_foto'];?>" /> <button data-album="<?php echo $element['id_album'];?>" data-id="<?php echo $element['id_file'];?>" class="btn btn-default trigger-tags btn-xs">modificar</button></td>
											<td><?php echo getDateFormat($element['date_foto'], "SHORT");?></td>
											<td><?php echo $element['user_add'];?></td>
											<td><?php echo $element['fotos_puntos'];?></td>
											<td><?php echo $num_comentarios>0 ? '<a href="admin-fotos-comentarios?id='.$element['id_file'].'&ida='.$id.'">'.$num_comentarios.'</a>' : $num_comentarios; ?></td>
										</tr>
									<?php endforeach;?>
								</table>
							</div>
							<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page']."?id=".$id, '', $elements['find_reg']);?>
							<!-- Modal -->
							<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-images">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photo");?></h4>
										</div>
										<div class="modal-body">
											<img class="galeria-fotos" style="width:100%" />
										</div>
									</div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<?php
						endif;?>
						</div>
					</div>
				</div>
			</div>
	<?php else:
		echo '</div>';
	endif;?>
	</div>
	<?php menu::adminMenu();?>
</div>
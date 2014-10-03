<?php

addJavascripts(array(getAsset("fotos")."js/admin-albumes-new.js"));

//CONTROL NIVEL DE ACCESO
$session = new session();
$perfiles_autorizados = array("admin");
$session->AccessLevel($perfiles_autorizados);

?>
<div class="row row-top">
	<div class="col-md-9">
		<h1>Albumes de fotos</h1>
		<?php

		session::getFlashMessage( 'actions_message' );
		fotosAlbumController::addFotoAction();
		fotosAlbumController::cancelFotoAction();
		fotosAlbumController::createAction();
		fotosAlbumController::updateAction();
		$id = (isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		$album = fotosAlbumController::getItemAction($id); 
		$elements = fotosController::getListAction(15, "AND estado=1 AND id_album=".$id." "); ?>

		<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Datos del album</div>
				<div class="panel-body">
					<form id="formData" name="formData" method="post" action="" role="form">
						<input type="hidden" name="id" value="<?php echo $id;?>" />
						<label for="nombre">Nombre del album</label>
						<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo isset($album[0]) ? $album[0]['nombre_album'] : '';?>" placeholder="título del album" />
						<br />
						<input type="submit" name="SubmitData" class="btn btn-primary" value="Guardar datos" />
					</form>
				</div>
			</div>
		</div>

		<?php if ($id > 0): ?>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Agregar imagen al álbum</div>
				<div class="panel-body">
					<form action="?page=admin-albumes-new&act=edit&id=<?php echo $id;?>" method="post" role="form">
						<input type="hidden" name="id_album" value="<?php echo $id;?>" />
						<label for="file_id">Introduce el ID de la foto:</label>
						<input type="text" class="form-control entero" name="file_id" id="file_id" />
						<br />
						<button type="submit" class="btn btn-primary">Agregar</button>
					</form>
				</div>
			</div>
		</div>
		</div>

		<h3>Fotos incluidas en el álbum</h3>
		<?php 
		if (count($elements['items'])==0):?>
			<div class="alert alert-warning">No existen fotos en el álbum</div>
		<?php else: ?>
			<div class="table-responsive">
				<table class="table">
					<tr>
						<th width="40px">&nbsp;</th>
						<th>ID</th>
						<th><?php echo strTranslate("Title");?></th>
						<th><?php echo strTranslate("Date");?></th>
						<th><?php echo strTranslate("User");?></th>
						<th><span class="fa fa-heart"></span></th>
						<th><span class="fa fa-comment"></span></th>
					</tr>
					<?php foreach($elements['items'] as $element):
						$num_comentarios = connection::countReg("galeria_fotos_comentarios"," AND estado=1 AND id_file=".$element['id_file']." ");?>
						<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" onClick="Confirma('<?php echo strTranslate("Are_you_sure_to_delete");?>', '?page=admin-albumes-new&act=foto_ko&id=<?php echo $id.'&idf='.$element['id_file'].'&u='.$element['user_add'];?>')" title="<?php echo strTranslate("Delete");?>" /></span>
							</td>
							<td><?php echo $element['id_file'];?></td>
							<td><a href="#" data-img="<?php echo $element['name_file'];?>" class="abrir-modal"><?php echo $element['titulo'];?></a></td>
							<td><?php echo strftime(DATE_FORMAT_SHORT,strtotime($element['date_foto']));?></td>
							<td><?php echo $element['user_add'];?></td>
							<td><?php echo $element['fotos_puntos'];?></td>
							<td><?php echo $num_comentarios>0 ? '<a href="?page=admin-fotos-comentarios&id='.$element['id_file'].'&ida='.$id.'">'.$num_comentarios.'</a>' : $num_comentarios; ?></td>
						</tr> 
					<?php endforeach;?>
				</table>
			</div>
			<?php Paginator($elements['pag'],$elements['reg'],$elements['total_reg'],$_REQUEST['page']."&id=".$id,'',$elements['find_reg']);?>
			<!-- Modal -->
			<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-images">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel"><?php echo strTranslate("Photo");?></h4>
						</div>
						<div class="modal-body">
							<img class="galeria-fotos" style="width:100%" />
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<?php
		endif;
	else:
		echo '</div>';
	endif; ?>	
	</div>
	<?php menu::adminMenu();?>
</div>
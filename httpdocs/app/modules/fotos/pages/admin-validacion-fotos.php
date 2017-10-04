<?php
addJavascripts(array(getAsset("fotos")."js/admin-validacion-fotos.js"));
templateload("cmbAlbumes","fotos");
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Photos"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Photo_validation"), "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		fotosController::validatePhotoAction();
		fotosController::cancelPhotoAction();
		$pendientes = fotosController::getListAction(9999, " AND estado=0 ");
		$albumes = fotosAlbumController::getListAction(9999, " AND activo=1 ORDER BY nombre_album");?>
		
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $pendientes['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?>. <?php echo ucfirst(strTranslate("APP_points"));?> a otorgar por foto: <b><?php echo PUNTOS_FOTO;?></b></a></li>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th width="40px">&nbsp;</th>
							<th><?php e_strTranslate("Photo_albums");?></th>
							<th><?php e_strTranslate("Author");?></th>
							<th><?php e_strTranslate("Title");?></th>
							<th><?php e_strTranslate("Tags");?></th>
							<th><?php e_strTranslate("Date");?></th>
						</tr>
						<?php foreach($pendientes['items'] as $element): ?>
						<tr>
							<td nowrap="nowrap">
								<span class="fa fa-ban icon-table" onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', 'admin-validacion-fotos?act=foto_ko&id=<?php echo $element['id_file'];?>&u=<?php echo $element['user_add'];?>')" title="<?php e_strTranslate("Delete");?>" />
								</span>

								<span class="fa fa-check-circle icon-table trigger-validar" data-id="<?php echo $element['id_file'];?>" data-user="<?php echo $element['user_add'];?>"	title="Validar" />
								</span>
							</td>
							<td><?php comboAlbumes($element['id_album'], $albumes['items'], "nombre_album_" .$element['id_file']);?></td>
							<td><?php echo $element['user_add'];?></td>
							<td><a href="#" class="abrir-modal" title="MensajeFoto<?php echo $element['id_file'];?>"><?php echo $element['titulo'];?></a>
								<!-- Modal -->
								<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								        <h4 class="modal-title" id="myModalLabel"><?php e_strTranslate("Photo");?></h4>
								      </div>
								      <div class="modal-body">
										<img src="<?php echo PATH_FOTOS.$element['name_file'];?>" class="galeria-fotos" style="width:100%" />
								      </div>
								    </div><!-- /.modal-content -->
								  </div><!-- /.modal-dialog -->
								</div><!-- /.modal -->
							</td>
							<td><input type="text" name="tipo_foto" id="tipo_foto_<?php echo $element['id_file'];?>" value="<?php echo $element['tipo_foto'];?>" /></td>
							<td><?php echo getDateFormat($element['date_foto'], "SHORT");?></td>
						</tr>
						<?php endforeach;?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>
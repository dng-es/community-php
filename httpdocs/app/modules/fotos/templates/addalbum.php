<?php
templateload("cmbCanales", "users");

function ModalSubirAlbum(){ 
	$module_config = getModuleConfig("fotos");
	if ($module_config['options']['allow_users_albums'] == true){
	?>

	<!-- Modal -->
	<div class="modal modal-wide fade" id="albumModal" tabindex="-1" role="dialog" aria-labelledby="albumModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="albumModalLabel"><?php e_strTranslate("New_album");?></h4>
				</div>
				<div class="modal-body">
					<form id="formAlbum" name="formAlbum" method="post" action="" role="form" class="">
						<input type="hidden" name="id" value="0" />
						<div class="row">
						<div class="form-group col-md-8">
							<label for="nombre" class="sr-only"><?php e_strTranslate("Title");?></label>
							<input type="text" style="width: 100% !important;" class="form-control" name="nombre" id="nombre" value="<?php echo isset($album[0]) ? $album[0]['nombre_album'] : '';?>" placeholder="<?php e_strTranslate("Title");?>" />
						</div>
						<div class="form-group col-md-4">
							<input type="submit" name="SubmitData" class="btn btn-primary btn-block" value="<?php e_strTranslate("Save_data");?>" />
						</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<?php } ?>
<?php } ?>
<?php
addJavascripts(array("js/mociones-graph.js"));
addJavascripts(array("js/bootstrap.file-input.js",
			getAsset("emociones")."js/admin-emocion.js"));

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Emociones"), "ItemUrl"=>"admin-emociones"),
			array("ItemLabel"=>"Datos de la emoción", "ItemClass"=>"active"),
		));
		session::getFlashMessage('actions_message');
		emocionesController::createAction();
		emocionesController::updateAction($id);
		emocionesController::createConsejoAction();
		emocionesController::deleteConsejoAction();
		$elements = emocionesController::getItemAction($id);
		?>
			<div class="panel panel-default">
				<div class="panel-body">
					<form id="formData" role="form" name="formData" method="post" enctype="multipart/form-data" action="">
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<div class="row">
						<div class="col-md-5 form-group">
							<label for="info_title"><?php e_strTranslate("Name");?>:</label>
							<input class="form-control" type="text" id="info_title" name="info_title" value="<?php echo $elements['name_emocion'];?>" data-alert="<?php e_strTranslate("Required_field");?>" />
						</div>
						
						<div class="col-md-4 form-group">
							<label for="info_file"><?php e_strTranslate("Image");?>:</label><br />
							<input name="info_file" id="info_file" type="file" class="btn btn-default" title="seleccionar archivo de imagen" />
						</div>
						<div class="col-md-3 form-group">
						<?php
						if ($elements['image_emocion']!=""){ 
							echo '<img src="images/emociones/'.$elements['image_emocion'].'" style="height: 100px" />';
						}

						?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<input type="submit" name="SubmitData" id="SubmitData" class="btn btn-primary" value="<?php e_strTranslate("Save_data");?>" />
						</div>
					</div>
					</form>

					<?php if($id > 0):
						$consejos = emocionesController::getListConsejosAction(1000, " AND id_emocion=".$id." ");
					?>
					<hr />
					<div class="row">
						<div class="col-md-7">
							<div class="table-responsive">
								<table class="table table-hover table-striped">
									<tr>
										<th width="40px"></th>
										<th><?php e_strTranslate("Emotion_tip");?></th>
									</tr>
									<?php foreach($consejos['items'] as $consejo):?>
									<tr>
										<td nowrap="nowrap">								
											<button type="button" class="btn btn-default btn-xs" title="<?php e_strTranslate("Delete");?>"
												onClick="Confirma('<?php e_strTranslate("Are_you_sure_to_delete");?>', '?page=admin-emocion&pag=<?php echo $consejos['pag'].'&f='.$consejos['find_reg'].'&act=del&id='.$id.'&idc='.$consejo['id_consejo'];?>'); return false"><i class="fa fa-trash icon-table"></i>
											</button>
										</td>
										<td><?php echo $consejo['emocion_consejo'];?></td>
									</tr>
									<?php endforeach;?>
								</table>
							</div>
						</div>
						<div class="col-md-5">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4><?php e_strTranslate("Emotion_tip_new");?></h4>
								</div>
								<div class="panel-body">
									<form id="formConsejoData" role="form" name="formConsejoData" method="post" action="">
										<input type="hidden" name="id_emocion" id="id_emocion" value="<?php echo $id;?>" />
										<div class="form-group">
											<label><?php e_strTranslate("Consejo");?></label>
											<textarea class="form-control" name="emocion_consejo" id="emocion_consejo" data-alert="<?php e_strTranslate("Required_field");?>"></textarea>
										</div>
										<div class="form-group">
											<input type="submit" name="SubmitConsejoData" id="SubmitConsejoData" class="btn btn-primary" value="<?php e_strTranslate("Save");?>" />
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<?php endif?>
				</div>
			</div>
	</div>
	<?php menu::adminMenu();?>
</div>
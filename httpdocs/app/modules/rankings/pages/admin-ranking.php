<?php
addJavascripts(array("js/libs/ckeditor/ckeditor.js", 
					 "js/libs/ckfinder/ckfinder.js",
					 "js/bootstrap.file-input.js", 
					 getAsset("rankings")."js/admin-ranking.js"));
?>
<div class="row row-top">
	<div class="app-main">
		<?php
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Rankings_list"), "ItemUrl"=>"admin-rankings"),
			array("ItemLabel"=>strTranslate("Rankings"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		rankingsController::createAction();
		rankingsController::updateAction();

		//OBTENER DATOS DEL Cuestionario
		$id_ranking = intval(isset($_REQUEST['id']) ? $_REQUEST['id'] : 0);
		if ($id_ranking>0){
			$ranking=rankingsController::getItemAction($id_ranking);
			$ranking_nombre = $ranking[0]['nombre_ranking'];
			$ranking_descripcion = $ranking[0]['descripcion_ranking'];
			$id_category = $ranking[0]['id_ranking_category'];
		}
		else{
			$ranking_nombre = "";
			$ranking_descripcion = "";
			$id_category = 0;
		}
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#general" data-toggle="tab"><?php e_strTranslate("Main_data");?></a></li>
					<?php if ($id_ranking>0):?>
					<li><a href="#import" data-toggle="tab"><?php e_strTranslate("Import_file");?></a></li>
					<?php endif; ?>
				</ul>
				
				<form method="post" name="formRanking" id="formRanking" role="form" enctype="multipart/form-data">
				<div class="tab-content">
					<div class="tab-pane fade in active" id="general">
						<div class="inset">

								<input type="hidden" name="id_ranking" id="id_ranking" value="<?php echo $id_ranking;?>" />
								
								<div class="row">
									<div class="col-md-6">
										<label for="nombre"><small><?php e_strTranslate("Name");?>:</small></label>
										<input data-alert="<?php e_strTranslate("Required_field");?>" type="text" name="nombre" id ="nombre" class="form-control" value="<?php echo $ranking_nombre;?>" />
									</div>

									<div class="col-md-6">
										<label for="id_ranking_category"><small>Categoria:</small></label>
											<select name="id_ranking_category" id="id_ranking_category" class="form-control">
											<?php
											$rankings = new rankings();
											$categorias = $rankings->getRankingsCategories("");
											foreach($categorias as $categoria):
												echo '<option value="'.$categoria['id_ranking_category'].'" '.($categoria['id_ranking_category']==$id_category ? 'selected="selected"' : '').'>'.$categoria['ranking_category_name'].'</option>';
											endforeach;?>
											</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<label for="descripcion"><small><?php e_strTranslate("Description");?>:</small></label>
										<textarea name="descripcion" id ="descripcion" class="form-control"><?php echo $ranking_descripcion;?></textarea>
										<script type="text/javascript">
											var editor=CKEDITOR.replace('descripcion',{customConfig : 'config-page.js'});
											CKFinder.setupCKEditor(editor, 'js/libs/ckfinder/') ;
										</script>
									</div>
								</div>
						</div>
					</div>

					<?php if ($id_ranking > 0):?>
					<div class="tab-pane fade" id="import">
						<div class="inset">
							<div class="form-group">
								<label for="fichero">Selecciona el fichero con los datos del ranking, los datos existentes se borran y se insertan los del fichero. El fichero deberá tener la estructura especificada, puedes descargar el fichero modelo <a href="docs/model_rankings.xls"><b><?php e_strTranslate("Click_here")?></b></a></label>
								<br />
								<input type="file" class="btn btn-default" name="fichero" id="fichero" title="<?php e_strTranslate("Choose_file");?>" />
							</div>
						</div>
					</div>
					<?php endif;?>
				</div>
				<br />
				<button class="btn btn-primary" id="SubmitCuestionario" name="SubmitForm" type="submit"><?php e_strTranslate("Save_data");?></button>
				</form>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>